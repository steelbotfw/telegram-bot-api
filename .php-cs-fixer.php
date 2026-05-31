<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        //__DIR__ . '/examples',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/tools',
    ])
    ->append([
        __DIR__ . '/tools/codegen',
    ])
    ->exclude('vendor')
    ->name('*.php');

return (new Config())
    ->setFormat('txt')
    ->setRiskyAllowed(false)
    ->setUsingCache(false)
    ->setRules([
        '@PSR12' => true,
        'fully_qualified_strict_types' => [
            'import_symbols' => true,
        ],
        'function_declaration' => [
            'closure_fn_spacing' => 'none',
        ],
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'no_unused_imports' => true,
        'ordered_imports' => true,
    ])
    ->setFinder($finder);
