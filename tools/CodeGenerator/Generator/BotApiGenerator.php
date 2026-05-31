<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\PsrPrinter;
use Nette\PhpGenerator\Type;
use RuntimeException;
use SplFileInfo;
use Steelbot\TelegramBotApi\Method\AbstractMethod;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\ParameterDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

readonly class BotApiGenerator
{
    private Printer $printer;

    public function __construct(
        private string $baseDir,
        private ParameterTypeGenerator $parameterTypeGenerator,
    ) {
        $this->printer = new PsrPrinter();
        $this->printer->indentation = '    ';
    }

    public function generate(BotApiDefinition $botApiDefinition): void
    {
        foreach ($botApiDefinition->getSections() as $section) {
            printf("Generating classes for section '%s'\n", $section->getTitle());
            foreach ($section->getItems() as $item) {
                if ($item instanceof TypeDefinition) {
                    $this->generateApiType($item);
                } elseif ($item instanceof MethodDefinition) {
                    $this->generateApiMethod($item);
                } else {
                    throw new LogicException("Unknown item: " . $item::class);
                }
            }
        }
    }

    private function generateApiType(TypeDefinition $typeDefinition): string
    {
        $classDir = $this->buildDir('Type', $typeDefinition->owner->getSectionId());
        $filename = $classDir . DIRECTORY_SEPARATOR . $typeDefinition->name . '.php';

        printf(
            "  Generating class for type '%s': \$baseDir%s%s\n",
            $typeDefinition->name,
            DIRECTORY_SEPARATOR,
            $this->getRelativeFilename($filename),
        );

        $file = new PhpFile()->setStrictTypes();
        $namespace = $file->addNamespace($this->getNamespaceByDirectory($classDir));
        $class = $namespace->addClass($typeDefinition->name)
            ->setReadOnly();

        foreach ($typeDefinition->getFields() as $field) {
            $this->parameterTypeGenerator->injectParameterTypes($class, $field);
        }


        $this->saveFile($file, $filename);

        return $filename;
    }

    private function generateApiMethod(MethodDefinition $methodDefinition): string
    {
        $classDir = $this->buildDir('Method', $methodDefinition->owner->getSectionId());
        $filename = $classDir . DIRECTORY_SEPARATOR . mb_ucfirst($methodDefinition->name) . '.php';
        printf(
            "  Generating class for method '%s': \$baseDir%s%s\n",
            $methodDefinition->name,
            DIRECTORY_SEPARATOR,
            $this->getRelativeFilename($filename)
        );

        $file = new PhpFile()->setStrictTypes();
        $namespace = $file->addNamespace($this->getNamespaceByDirectory($classDir));
        $class = $namespace->addClass(mb_ucfirst($methodDefinition->name))
            ->setExtends(AbstractMethod::class)
            ->addImplement('\JsonSerializable');

        foreach ($methodDefinition->getParameters() as $parameter) {
            $this->injectMethodParameter($class, $parameter);
            $this->addGetter($class, $parameter);
            $this->addSetter($class, $parameter);
        }

        $class->addMethod('getMethodName')
            ->setReturnType('string')
            ->setBody('return ?;', [$methodDefinition->name]);

        $class->addMethod('getHttpMethod')
            ->setReturnType('string')
            ->setBody('return self::HTTP_POST;');

        $class->addMethod('getParams')
            ->setReturnType('array')
            ->setBody('return [];');

        $this->addBuildResultMethod($class, $methodDefinition);

        $class->addMethod('jsonSerialize')
            ->setReturnType('mixed')
            ->setBody($this->buildJsonSerializeBody($methodDefinition));

        $this->saveFile($file, $filename);

        return $filename;
    }

    private function injectMethodParameter(ClassType $class, ParameterDefinition $parameterDefinition): void
    {
        $resolvedType = $this->parameterTypeGenerator->resolve($parameterDefinition);

        foreach ($resolvedType->imports as $import) {
            $this->addImport($class, $import);
        }

        $parameter = $this->getOrCreateConstructor($class)
            ->addPromotedParameter($this->snakeToCamel($parameterDefinition->name))
            ->setPrivate()
            ->setType(Type::union(...$resolvedType->nativeTypes));

        if ($parameterDefinition->isOptional) {
            $parameter->setDefaultValue(null);
            if (!in_array('mixed', $resolvedType->nativeTypes, true)) {
                $parameter->setNullable();
            }
        }

        $comment = $resolvedType->rawPhpDocType
            ?? ($resolvedType->phpDocType !== null ? sprintf('@var %s', $resolvedType->phpDocType) : null);

        if ($comment !== null) {
            $parameter->setComment($comment);
        }
    }

    private function addGetter(ClassType $class, ParameterDefinition $parameterDefinition): void
    {
        $resolvedType = $this->parameterTypeGenerator->resolve($parameterDefinition);
        $propertyName = $this->snakeToCamel($parameterDefinition->name);
        $method = $class->addMethod('get' . ucfirst($propertyName))
            ->setReturnType($this->buildNativeType($resolvedType, $parameterDefinition->isOptional))
            ->setBody(sprintf('return $this->%s;', $propertyName));

        if ($resolvedType->phpDocType !== null) {
            $method->addComment('@return ' . $resolvedType->phpDocType . ($parameterDefinition->isOptional ? '|null' : ''));
        }
    }

    private function addSetter(ClassType $class, ParameterDefinition $parameterDefinition): void
    {
        $resolvedType = $this->parameterTypeGenerator->resolve($parameterDefinition);
        $propertyName = $this->snakeToCamel($parameterDefinition->name);
        $method = $class->addMethod('set' . ucfirst($propertyName))
            ->setReturnType('self')
            ->setBody(sprintf('$this->%s = $%s;' . "\n\n" . 'return $this;', $propertyName, $propertyName));

        $parameter = $method->addParameter($propertyName)
            ->setType($this->buildNativeType($resolvedType, $parameterDefinition->isOptional));

        if ($parameterDefinition->isOptional) {
            $parameter->setDefaultValue(null);
        }

        if ($resolvedType->phpDocType !== null) {
            $method->addComment('@param ' . $resolvedType->phpDocType . ($parameterDefinition->isOptional ? '|null' : '') . ' $' . $propertyName);
        }
    }

    private function addBuildResultMethod(ClassType $class, MethodDefinition $methodDefinition): void
    {
        $method = $class->addMethod('buildResult');
        $method->addParameter('result');

        $returnTypeDefinition = $methodDefinition->getReturnTypeDefinition();
        if ($returnTypeDefinition === null) {
            $method->setBody('return $result;');

            return;
        }

        $resolvedType = $this->parameterTypeGenerator->resolveTypeDefinition($returnTypeDefinition);
        foreach ($resolvedType->imports as $import) {
            $this->addImport($class, $import);
        }

        $phpDocType = $resolvedType->phpDocType ?? implode('|', $resolvedType->nativeTypes);
        $method->addComment('@return ' . $phpDocType);

        if (count($resolvedType->nativeTypes) !== 1 || in_array('mixed', $resolvedType->nativeTypes, true)) {
            $method->setBody('return $result;');

            return;
        }

        $nativeType = $resolvedType->nativeTypes[0];
        if ($this->isScalarNativeType($nativeType)) {
            $method->setBody('return $result;');

            return;
        }

        if ($nativeType !== 'array') {
            $method->setBody(sprintf('return new %s($result);', $this->shortClassName($nativeType)));

            return;
        }

        if ($resolvedType->imports === []) {
            $method->setBody('return $result;');

            return;
        }

        $method->setBody(sprintf(
            <<<'PHP'
$items = [];
foreach ($result as $item) {
    $items[] = new %s($item);
}

return $items;
PHP,
            $this->shortClassName($resolvedType->imports[0])
        ));
    }

    /**
     * @psalm-mutation-free
     */
    private function buildJsonSerializeBody(MethodDefinition $methodDefinition): string
    {
        $requiredParameters = array_filter(
            $methodDefinition->getParameters(),
            static fn(ParameterDefinition $parameter): bool => !$parameter->isOptional,
        );
        $optionalParameters = array_filter(
            $methodDefinition->getParameters(),
            static fn(ParameterDefinition $parameter): bool => $parameter->isOptional,
        );

        $lines = ['$data = ['];
        foreach ($requiredParameters as $parameter) {
            $lines[] = sprintf(
                "    '%s' => \$this->%s,",
                $parameter->name,
                $this->snakeToCamel($parameter->name),
            );
        }
        $lines[] = '];';

        foreach ($optionalParameters as $parameter) {
            $propertyName = $this->snakeToCamel($parameter->name);
            $lines[] = '';
            $lines[] = sprintf('if ($this->%s !== null) {', $propertyName);
            $lines[] = sprintf("    \$data['%s'] = \$this->%s;", $parameter->name, $propertyName);
            $lines[] = '}';
        }

        $lines[] = '';
        $lines[] = 'return $data;';

        return implode("\n", $lines);
    }

    private function getOrCreateConstructor(ClassType $class): Method
    {
        if ($class->hasMethod('__construct')) {
            return $class->getMethod('__construct');
        }

        return $class->addMethod('__construct');
    }

    private function addImport(ClassType $class, string $import): void
    {
        $namespace = $class->getNamespace();

        if (!$namespace instanceof PhpNamespace) {
            throw new LogicException(sprintf('Cannot add import "%s" to class without namespace.', $import));
        }

        $namespace->addUse($import);
    }

    private function buildNativeType(ResolvedPhpType $resolvedType, bool $isOptional): string
    {
        $type = Type::union(...$resolvedType->nativeTypes);

        if (!$isOptional || in_array('mixed', $resolvedType->nativeTypes, true)) {
            return $type;
        }

        return Type::nullable($type);
    }

    /**
     * @psalm-pure
     */
    private function isScalarNativeType(string $nativeType): bool
    {
        return in_array($nativeType, ['bool', 'float', 'int', 'string', 'true'], true);
    }

    /**
     * @psalm-pure
     */
    private function snakeToCamel(string $string): string
    {
        return $string
                |> strtolower(...)
                |> (static fn($x) => ucwords($x, '_'))
                |> (static fn($x) => str_replace('_', '', $x))
                |> lcfirst(...);
    }

    /**
     * @psalm-pure
     */
    private function shortClassName(string $fqcn): string
    {
        $parts = explode('\\', trim($fqcn, '\\'));

        return end($parts) ?: $fqcn;
    }

    private function saveFile(PhpFile $file, string $filename): void
    {
        $fileInfo = new SplFileInfo($filename);

        $fileObject = $fileInfo->openFile('w');
        $fileObject->fwrite($this->printer->printFile($file));
    }

    private function getNamespaceByDirectory(string $directory): string
    {
        $targetDir = realpath($directory);
        if (!$targetDir) {
            throw new RuntimeException('Target directory not found: ' . $directory);
        }

        foreach (ClassLoader::getRegisteredLoaders() as $classLoader) {
            foreach ($classLoader->getPrefixesPsr4() as $namespace => $dirs) {
                foreach ($dirs as $dir) {
                    $dir = realpath($dir);
                    if ($dir === false) {
                        continue;
                    }

                    if (str_starts_with($targetDir, $dir)) {
                        $relativePath = substr($targetDir, strlen($dir) + 1);
                        $subNamespace = str_replace(DIRECTORY_SEPARATOR, '\\', $relativePath);

                        return rtrim($namespace . $subNamespace, '\\');
                    }
                }
            }
        }

        throw new RuntimeException("Can't determine namesapce for directory $targetDir");
    }

    private function buildDir(string ...$subdirectories): string
    {
        $dir = $this->baseDir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $subdirectories);
        $fileInfo = new SplFileInfo($dir);
        if ($fileInfo->isFile()) {
            throw new RuntimeException("$dir is a file, not directory");
        }

        if (!$fileInfo->isDir()) {
            $dirname = $fileInfo->getPathname();
            if (!mkdir($dirname, 0755, true) && !is_dir($dirname)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $dirname));
            }
        }

        return $dir;
    }

    /**
     * @psalm-mutation-free
     */
    private function getRelativeFilename(string $filename): string
    {
        return mb_substr($filename, strlen($this->baseDir) + 1);
    }
}
