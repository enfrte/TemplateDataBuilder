<?php

require_once __DIR__.'/TemplateDataBuilder.php';

$personData = [
    [
        'first_name' => 'John',
        'last_name'  => 'Doe',
        'street'     => 'Main Street 12',
        'postcode'   => '00100',
        'city'       => 'Helsinki',
        'gender'     => 1, // 1 = male, 2 = female
    ],
    [
        'first_name' => 'Jane',
        'last_name'  => 'Doe',
        'street'     => '',
        'postcode'   => '00100',
        'city'       => '',
        'gender'     => 2, // 1 = male, 2 = female
    ],
    [
        'first_name' => 'Jane',
        'last_name'  => 'Doe',
        'street'     => '',
        'postcode'   => '',
        'city'       => '',
        'gender'     => 3, // 3 = other
    ],
];

// Build the data step by step with chaining
$tdBuilder = new TemplateDataBuilder('en');

foreach ($personData as &$person) {
    $person = $tdBuilder
        ->setData($person)
        ->concatNames('full_name', 'first_name', 'last_name', false)
        ->concatNames('formal_name', 'last_name', 'first_name', true)
        ->concatAddress('full_address', 'street', 'postcode', 'city')
        ->title('title', 'gender') 
        ->get();
}

echo '<pre>';
print_r($personData);
