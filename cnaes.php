<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

$cnaescsvfile = './cnaes.csv';

if (!file_exists($cnaescsvfile)) {
    echo json_encode(['error' => 'csv file not found']);
    exit;
}

$filecontent = file_get_contents($cnaescsvfile);

$enc = mb_detect_encoding($filecontent, 'UTF-8, ISO-8859-1, Windows-1252', true);

if ($enc !== 'UTF-8') {
    $filecontent = mb_convert_encoding($filecontent, 'UTF-8', $enc);
}

$alllines = array_map(function($line) {
    return str_getcsv($line,';');
}, explode("\n", $filecontent));

$alllines = array_filter($alllines, function($line) {
    return $line !== array(null);
});

if (empty($alllines)) {
    echo json_encode(["error"=> 'No content read from csv file']);
}

$apiConformant = [];

foreach ($alllines as $line) {
    $apiConformant[] = [
        'cnaeID' => $line[0],
        'cnaeDesc' => $line[1]
    ];
}

echo json_encode($apiConformant);