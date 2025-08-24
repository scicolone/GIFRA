<?php
session_start();
require_once 'config.php';    // conterrà $pdo (PDO) e la configurazione base
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // ricerca utente
    $stmt = $pdo->prepare('SELECT id, nome, cognome, password, ruolo, stato_approvazione
                           FROM utenti
                           WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['stato_approvazione'] !== 'approvato') {
            $error = 'Account non ancora approvato dal presidente o dal segretario.';
        } else {
            // login OK
            $_SESSION['uid']   = $user['id'];
            $_SESSION['nome']  = $user['nome'];
            $_SESSION['cognome'] = $user['cognome'];
            $_SESSION['ruolo'] = $user['ruolo'];

            // redirect ruolo-specifico
            switch ($user['ruolo']) {
                case 'presidente':
                case 'segretario':
                    header('Location: dashboard_presidente.php');
                    break;
                case 'cassiere':
                    header('Location: dashboard_cassiere.php');
                    break;
                case 'allenatore':
                    header('Location: dashboard_allenatore.php');
                    break;
                case 'genitore':
                    header('Location: dashboard_genitore.php');
                    break;
                default:   // socio, dirigente, consigliere
                    header('Location: dashboard_socio.php');
            }
            exit;
        }
    } else {
        $error = 'Credenziali errate.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login – ASD Gi.Fra. Milazzo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            margin:0;
            font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
            background:#f4f4f4;
            display:flex;
            align-items:center;
            justify-content:center;
            height:100vh;
        }
        .card{
            background:#fff;
            border-radius:8px;
            padding:40px 30px;
            box-shadow:0 4px 12px rgba(0,0,0,.15);
            max-width:400px;
            width:100%;
        }
        .card img{
            width:120px;
            margin-bottom:20px;
        }
        .card h2{
            margin-bottom:25px;
            color:#0d47a1;
        }
        .card label{
            display:block;
            margin-bottom:6px;
            font-weight:600;
        }
        .card input[type=email],
        .card input[type=password]{
            width:100%;
            padding:10px;
            margin-bottom:20px;
            border:1px solid #ccc;
            border-radius:4px;
        }
        .card button{
            width:100%;
            padding:12px;
            background:#b71c1c;
            border:none;
            color:#fff;
            font-size:16px;
            border-radius:4px;
            cursor:pointer;
        }
        .card button:hover{
            background:#a01515;
        }
        .error{
            margin-bottom:15px;
            color:#b71c1c;
            font-size:14px;
        }
        .card a{
            display:block;
            margin-top:15px;
            color:#0d47a1;
            font-size:14px;
            text-decoration:none;
        }
        .card a:hover{
            text-decoration:underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="Logo GiFra nuovo.png" alt="Logo Gi.Fra. Milazzo">
        <h2>Accedi all'Area Riservata</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Entra</button>
        </form>

        <a href="registrazione.php">Non hai un account? Registrati</a>
        <a href="index.php" style="text-align:center;display:block;margin-top:10px;">← Torna alla Home</a>
    </div>
</body>
</html>
