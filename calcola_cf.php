<?php
require_once 'lib/CodiceFiscale.php';
use NigroSimone\CodiceFiscale;

header('Content-Type: text/plain; charset=utf-8');

$cf = new CodiceFiscale();
echo $cf->calcola(
    $_GET['cognome'] ?? '',
    $_GET['nome']   ?? '',
    $_GET['data']   ?? '',
    $_GET['sesso']  ?? '',
    $_GET['luogo']  ?? ''
);
