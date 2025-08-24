<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['ruolo'] !== 'genitore') {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head><meta charset="UTF-8"><title>Dashboard Genitore – ASD Gi.Fra. Milazzo</title>
<style>header{background:#b71c1c;color:#fff;padding:15px 20px;display:flex;justify-content:space-between}header a{color:#fff;margin-left:15px;text-decoration:none}.content{padding:30px}</style>
</head>
<body>
<header>
    <span>Dashboard Genitore – <?= htmlspecialchars($_SESSION['nome']) ?></span>
    <div>
        <a href="javascript:history.back()">Indietro</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</header>
<div class="content">
    <h2>I miei figli</h2>
    <ul>
        <li><a href="figli.php">Visualizza dati iscritti</a></li>
        <li><a href="calendari.php">Calendari squadre</a></li>
        <li><a href="quote.php">Quote & ricevute</a></li>
    </ul>
</div>
</body>
</html>
