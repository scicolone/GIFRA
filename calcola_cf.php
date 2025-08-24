<?php
require_once __DIR__ . '/lib/CF.php';   // la nostra libreria CF.php
header('Content-Type: text/plain; charset=utf-8');

$cognome = isset($_GET['cognome']) ? trim($_GET['cognome']) : '';
$nome    = isset($_GET['nome'])   ? trim($_GET['nome'])   : '';
$data    = isset($_GET['data'])   ? trim($_GET['data'])   : '';
$sesso   = isset($_GET['sesso'])  ? trim($_GET['sesso'])  : '';
$luogo   = isset($_GET['luogo'])  ? trim($_GET['luogo'])  : '';

if (!$cognome || !$nome || !$data || !$sesso || !$luogo) {
    http_response_code(400);
    exit('Parametri mancanti');
}

// carica i dati ufficiali
$comuni = json_decode(file_get_contents(__DIR__ . '/lib/comuni.json'), true);
$codice = null;
foreach ($comuni as $c) {
    if (strcasecmp($c['denominazione'], $luogo) === 0) {
        $codice = $c['codiceCatastale'];
        break;
    }
}
if (!$codice) {
    http_response_code(404);
    exit('Comune non trovato');
}

echo CF::calcola($cognome, $nome, $data, $sesso, $luogo);
