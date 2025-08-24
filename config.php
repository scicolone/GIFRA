<?php
$host = 'sql.giovannicusumano.it';
$db   = 'giovanni26877';
$user = 'giovanni26877';
$pass = 'giov37810';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Connessione fallita: ' . $e->getMessage());
}
?>
