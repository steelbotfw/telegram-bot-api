<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Composer\Autoload\ClassLoader;
use LogicException;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;
use Nette\PhpGenerator\PsrPrinter;
use RuntimeException;
use SplFileInfo;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\MethodDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\SectionDefinition;
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
            printf("Generating classes for section %s\n", $section->getTitle());
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
        $classDir = $this->buildDir('Type', $this->sectionToDir($typeDefinition->owner));

        $file = new PhpFile()->setStrictTypes();
        $namespace = $file->addNamespace($this->getNamespaceByDirectory($classDir));
        $class = $namespace->addClass($typeDefinition->name)
            ->setReadOnly();

        foreach ($typeDefinition->getFields() as $field) {
            $this->parameterTypeGenerator->injectParameterTypes($class, $field);
        }

        $filename = $classDir . DIRECTORY_SEPARATOR . $typeDefinition->name . '.php';
        $this->saveFile($file, $filename);

        return $filename;
    }

    private function generateApiMethod(MethodDefinition $methodDefinition): string
    {
        $classDir = $this->buildDir('Method', $this->sectionToDir($methodDefinition->owner));

        $file = new PhpFile()->setStrictTypes();
        $namespace = $file->addNamespace($this->getNamespaceByDirectory($classDir));
        $class = $namespace->addClass(mb_ucfirst($methodDefinition->name))
            ->setReadOnly();

        $filename = $classDir . DIRECTORY_SEPARATOR . mb_ucfirst($methodDefinition->name) . '.php';
        $this->saveFile($file, $filename);

        return $filename;
    }

    private function saveFile(PhpFile $file, string $filename): void
    {
        $fileInfo = new SplFileInfo($filename);

        $fileObject = $fileInfo->openFile('w');
        $fileObject->fwrite($this->printer->printFile($file));
    }

    private function getNamespaceByDirectory(string $directory): ?string
    {
        $targetDir = realpath($directory);
        if (!$targetDir)  {
            throw new RuntimeException('Target directory not found: ' . $directory);
        }

        $prefixes = array_values(ClassLoader::getRegisteredLoaders())[0]?->getPrefixesPsr4() ??
            throw new RuntimeException('Class loader for target directory not found');

        foreach ($prefixes as $namespace => $dirs) {
            foreach ($dirs as $dir) {
                $dir = realpath($dir);
                if (str_starts_with($targetDir, $dir)) {
                    $relativePath = substr($targetDir, strlen($dir)+1);
                    $subNamespace = str_replace(DIRECTORY_SEPARATOR, '\\', $relativePath);

                    return rtrim($namespace . $subNamespace, '\\');
                }
            }
        }

        throw new RuntimeException("Can't determine namesapce for directory $targetDir");
    }

    /**
     * @psalm-mutation-free
     */
    private function sectionToDir(SectionDefinition $sectionDefinition): string
    {
        return match ($sectionDefinition->getTitle()) {
            'Getting updates' => 'Update',

            default => throw new RuntimeException("Unknown section: {$sectionDefinition->getTitle()}"),
        };
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
}
