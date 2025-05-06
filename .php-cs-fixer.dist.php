<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'ordered_imports' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'php_unit_construct' => true,
        'phpdoc_align' => false,
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
        ],
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'nullable_type_declaration_for_default_null_value' => false,
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->exclude('tests/app/cache')
            ->exclude('tests/app/logs')
            ->exclude('node_modules')
            ->exclude('Resources')
            ->exclude('var')
            ->exclude('vendor')
            ->exclude('web/admin')
            ->exclude('web/bundles')
            ->exclude('web/uploads')
            ->in(__DIR__)
    );

