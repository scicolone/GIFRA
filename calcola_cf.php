<?php
require_once __DIR__ . '/lib/CodiceFiscale.php';
use NigroSimone\CodiceFiscale;

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

$cf = new CodiceFiscale();
$cf->setCognome($cognome)
   ->setNome($nome)
   ->setData($data)
   ->setSesso($sesso)
   ->setComune($luogo);

echo $cf->getCodiceFiscale();
