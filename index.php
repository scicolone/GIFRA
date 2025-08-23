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
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background:#f4f4f4;color:#333}

        header{
            background:linear-gradient(135deg,#b71c1c 0%,#0d47a1 100%);
            color:#fff;
            padding:60px 20px;
            text-align:center;
        }
        header img{
            max-width:160px;
            margin-bottom:20px;
            /* elimina l'alone bianco residuo del logo trasparente */
            -webkit-mask-image: radial-gradient(circle, black 95%, transparent 100%);
            mask-image: radial-gradient(circle, black 95%, transparent 100%);
            filter: brightness(1.05) contrast(1.05);
        }
        header h1{font-size:28px;margin-bottom:10px}
        header p{font-size:16px;max-width:600px;margin:0 auto;opacity:.9}

        .cta{background:#0d47a1;padding:60px 20px;text-align:center}
        .cta a{
            display:inline-block;background:#fff;color:#0d47a1;
            padding:15px 30px;margin:10px;border-radius:5px;
            font-weight:bold;text-decoration:none;font-size:16px;
            transition:.3s
        }
        .cta a:hover{background:#e3f2fd}

        footer{background:#b71c1c;color:#fff;text-align:center;padding:15px;font-size:14px}
    </style>
</head>
<body>

<header>
    <img src="Logo GiFra nuovo.png" alt="Logo Gi.Fra. Milazzo">
    <h1>Benvenuti nella famiglia del Gi.Fra. Milazzo</h1>
    <p>Società Sportiva Dilettantistica – Formiamo giovani calciatori con passione, professionalità e valori sportivi.</p>
</header>

<section class="cta">
    <a href="login.php">Accedi all'Area Riservata</a>
    <a href="registrazione.php">Iscrivi tuo figlio</a>
</section>

<footer>
    &copy; 2025 ASD Gi.Fra. Milazzo – Piazza San Papino, 33 – 98057 Milazzo (ME)
</footer>

</body>
</html>
