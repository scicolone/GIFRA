<?php
require_once 'config.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare('SELECT id FROM utenti WHERE email = ?');
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        // qui andrebbe l'invio email con token
        $msg = 'Se l’email esiste, riceverai a breve le istruzioni per reimpostare la password.';
    } else {
        $msg = 'Se l’email esiste, riceverai a breve le istruzioni per reimpostare la password.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Recupera Password – ASD Gi.Fra. Milazzo</title>
    <style>
        body{margin:0;font-family:'Segoe UI',sans-serif;background:#f4f4f4;
             display:flex;align-items:center;justify-content:center;height:100vh}
        .card{background:#fff;border-radius:8px;padding:40px 30px;box-shadow:0 4px 12px rgba(0,0,0,.15);
              max-width:400px;width:100%}
        .card h2{margin-bottom:25px;color:#0d47a1}
        .card input[type=email]{width:100%;padding:10px;margin-bottom:20px;border:1px solid #ccc;border-radius:4px}
        .card button{width:100%;padding:12px;background:#b71c1c;border:none;color:#fff;
                     font-size:16px;border-radius:4px;cursor:pointer}
        .card a{display:block;margin-top:15px;color:#0d47a1;font-size:14px;text-decoration:none}
    </style>
</head>
<body>
    <div class="card">
        <h2>Recupera Password</h2>
        <?php if ($msg): ?>
            <p><?= htmlspecialchars($msg) ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="email" name="email" placeholder="Inserisci la tua email" required>
            <button type="submit">Invia istruzioni</button>
        </form>
        <a href="login.php">← Torna al Login</a>
        <a href="index.php">← Torna alla Home</a>
    </div>
</body>
</html>
