<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'app/cache',
        'app/var',
        'bin',
        'myVendors',
        'vendor',
        'web',
    ])
;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,

        'array_syntax' => ['syntax' => 'short'],
        'linebreak_after_opening_tag' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,

        // 'modernize_types_casting' => true,
        // 'no_useless_return' => true,
        // 'phpdoc_add_missing_param_annotation' => true,
        // 'protected_to_private' => true,
        // 'strict_param' => true,
    ])
    ->setFinder($finder)
;
