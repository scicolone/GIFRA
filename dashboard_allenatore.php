<?php
session_start();
if (!isset($_SESSION['uid']) || $_SESSION['ruolo'] !== 'allenatore') {
    header('Location: login.php'); exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Allenatore – ASD Gi.Fra. Milazzo</title>
    <style>header{background:#0d47a1;color:#fff;padding:15px 20px;display:flex;justify-content:space-between}header a{color:#fff;margin-left:15px;text-decoration:none}.content{padding:30px}</style>
</head>
<body>
<header>
    <span>Dashboard Allenatore – <?= htmlspecialchars($_SESSION['nome']) ?></span>
    <div>
        <a href="javascript:history.back()">Indietro</a>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</header>
<div class="content">
    <h2>Gestione squadra</h2>
    <ul>
        <li><a href="calendari.php">Calendari</a></li>
        <li><a href="distinte.php">Distinte di gara</a></li>
        <li><a href="comunicazioni.php">Comunicazioni</a></li>
    </ul>
</div>
</body>
</html>
