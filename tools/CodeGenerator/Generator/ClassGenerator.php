<?php


declare(strict_types=1);

namespace Steelbot\TelegramBotApi\Tools\CodeGenerator\Generator;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\Printer;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\BotApiDefinition;
use Steelbot\TelegramBotApi\Tools\CodeGenerator\Definition\TypeDefinition;

class ClassGenerator
{
    public function generate(BotApiDefinition $botApiDefinition, string $srcPath): void
    {
        foreach ($botApiDefinition->getSections() as $section) {
            foreach ($section->getItems() as $item) {
                if ($item instanceof TypeDefinition) {
                    $printer = new Printer();
                    $printer->indentation = '    ';

                    $file = $this->generateType($item, $srcPath);

                    // todo
                    echo $printer->printFile($file);
                }
            }
        }
    }

    private function generateType(TypeDefinition $typeDefinition, string $srcPath): PhpFile
    {
        $file = new PhpFile();
        $class = $file->setStrictTypes(true)->addClass($typeDefinition->name);

        $class->setReadOnly(true);

        $constructor = $class->addMethod('__construct');

        foreach ($typeDefinition->getFields() as $field) {
            $constructor->addPromotedParameter($this->snakeToCamel($field->name))
                ->setNullable($field->isOptional)
                ->setPublic();
        }

        return $file;
    }

    private function snakeToCamel($string)
    {
        return $string
                |> strtolower(...)
                |> (static fn($x) => ucwords($x, '_'))
                |> (static fn($x) => str_replace('_', '', $x))
                |> lcfirst(...);
    }
}