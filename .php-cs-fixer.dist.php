<?php

$finder = (new PhpCsFixer\Finder())->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'elseif' => false,
        'single_blank_line_at_eof' => false,
        'single_trait_insert_per_statement' => false,
        'return_type_declaration' => ['space_before' => 'one']
    ])
    ->setFinder($finder);
