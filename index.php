<?php
session_start();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>ASD Gi.Fra. Milazzo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #b71c1c;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header img {
            max-width: 150px;
        }
        .container {
            padding: 40px 20px;
            text-align: center;
        }
        .btn {
            background-color: #0d47a1;
            color: white;
            padding: 15px 30px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #083083;
        }
    </style>
</head>
<body>
<header>
    <img src="Logo GiFra nuovo.png" alt="Logo Gi.Fra. Milazzo">
    <h1>Benvenuti nella famiglia del Gi.Fra. Milazzo</h1>
    <p>Società Sportiva Dilettantistica - Formiamo giovani calciatori con passione e valori.</p>
</header>
<div class="container">
    <a href="login.php" class="btn">Accedi</a>
    <a href="registrazione.php" class="btn">Iscrivi tuo figlio</a>
</div>
</body>
</html>
