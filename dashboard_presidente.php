<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['ruolo'] !== 'presidente') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Presidente – ASD Gi.Fra. Milazzo</title>
    <style>
        body{margin:0;font-family:'Segoe UI',sans-serif;background:#f4f4f4;color:#333}
        header{background:#b71c1c;color:#fff;padding:15px 20px;display:flex;justify-content:space-between;align-items:center}
        header a{color:#fff;margin-left:15px;text-decoration:none}
        .content{padding:30px}
    </style>
</head>
<body>
<header>
    <span>Dashboard Presidente – <?= htmlspecialchars($_SESSION['nome'].' '.$_SESSION['cognome']) ?></span>
    <div>
        <a href="javascript:history.back()">Indietro</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</header>
<div class="content">
    <h2>Gestione completa</h2>
    <ul>
        <li><a href="approva_utenti.php">Approva / gestisci utenti</a></li>
        <li><a href="gestione_calciatori.php">Calciatori</a></li>
        <li><a href="gestione_quote.php">Quote sociali</a></li>
        <li><a href="calendari.php">Calendari & distinte</a></li>
    </ul>
</div>
</body>
</html>
