<?php
require_once 'config.php';   // $pdo già definito
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // campi base
    $nome     = trim($_POST['nome']);
    $cognome  = trim($_POST['cognome']);
    $luogo    = trim($_POST['luogo_nascita']);
    $provN    = trim($_POST['provincia_nascita']);
    $dataN    = $_POST['data_nascita'];
    $cf       = strtoupper(trim($_POST['codice_fiscale']));
    $indirizzo= trim($_POST['indirizzo']);
    $comune   = trim($_POST['comune_residenza']);
    $provR    = trim($_POST['provincia_residenza']);
    $email    = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $ruolo    = $_POST['ruolo'];   // stringa: genitore, allenatore, ecc.

    // controllo univocità email
    $stmt = $pdo->prepare('SELECT id FROM utenti WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $error = 'Email già registrata.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            'INSERT INTO utenti (nome, cognome, email, password, ruolo, stato_approvazione)
             VALUES (?, ?, ?, ?, ?, "in_attesa")'
        );
        $stmt->execute([$nome, $cognome, $email, $hash, $ruolo]);
        $success = 'Registrazione completata! Attendi l’approvazione del presidente o del segretario.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione – ASD Gi.Fra. Milazzo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{
            font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
            background:linear-gradient(135deg,#b71c1c 0%,#0d47a1 100%);
            color:#fff;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px 15px;
        }
        .card{
            background:#fff;
            color:#333;
            border-radius:10px;
            max-width:480px;
            width:100%;
            padding:40px 35px;
            box-shadow:0 8px 20px rgba(0,0,0,.25);
        }
        .card h2{margin-bottom:25px;text-align:center;color:#0d47a1}
        label{display:block;font-weight:600;margin-bottom:4px;margin-top:15px}
        input,select{
            width:100%;padding:10px;border:1px solid #ccc;border-radius:4px;font-size:15px
        }
        .ruoli{display:flex;justify-content:space-around;flex-wrap:wrap;margin:20px 0}
        .ruolo-item{display:flex;flex-direction:column;align-items:center;cursor:pointer}
        .ruolo-item svg{width:40px;height:40px;margin-bottom:6px;fill:#0d47a1}
        .ruolo-item input{display:none}
        .ruolo-item input:checked + label svg{fill:#b71c1c}
        .ruolo-item label{font-size:13px;font-weight:700;text-align:center;color:#333}
        button{
            margin-top:25px;width:100%;padding:12px;
            background:#b71c1c;color:#fff;font-size:16px;border:none;border-radius:4px;cursor:pointer
        }
        button:hover{background:#a01515}
        .error{color:#b71c1c;margin-bottom:15px}
        .success{color:#0d47a1;margin-bottom:15px}
        .back{
            display:inline-block;margin-top:15px;color:#0d47a1;text-decoration:none
        }
    </style>
</head>
<body>
<div class="card">
    <h2>Registrazione</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="success">
            <?= htmlspecialchars($success) ?>
            <br><br>
            <small>Ti stiamo reindirizzando alla Home…</small>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 7000);
        </script>
    <?php else: ?>
        <!-- FORM COMPLETO -->
        <form method="post" autocomplete="off">
            <label>Nome</label>
            <input type="text" name="nome" required>

            <label>Cognome</label>
            <input type="text" name="cognome" required>

            <label>Luogo di nascita</label>
            <input type="text" name="luogo_nascita" required>

            <label>Provincia di nascita</label>
            <input type="text" name="provincia_nascita" maxlength="2" required>

            <label>Data di nascita</label>
            <input type="date" name="data_nascita" required>
            <label>Sesso</label>
<select name="sesso" id="sesso" required>
    <option value="">-- Seleziona --</option>
    <option value="M">Maschio</option>
    <option value="F">Femmina</option>
</select>

            <label>Codice fiscale</label>
            <input type="text" name="codice_fiscale" maxlength="16" required pattern="[A-Za-z0-9]{16}">

            <label>Indirizzo</label>
            <input type="text" name="indirizzo" required>

            <label>Comune di residenza</label>
            <input type="text" name="comune_residenza" required>

            <label>Provincia di residenza</label>
            <input type="text" name="provincia_residenza" maxlength="2" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" minlength="6" required>

            <label>Seleziona ruolo</label>
            <div class="ruoli">
                <?php
                $ruoli = ['genitore','allenatore','socio','dirigente','segretario','cassiere'];
                $icons = [
                    'genitore'  => '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>',
                    'allenatore'=> '<path d="M5 13.18v2.81c0 .73.4 1.41 1.04 1.76l5 2.5c.6.3 1.32.3 1.92 0l5-2.5c.64-.35 1.04-1.03 1.04-1.76v-2.81l-6 2.4-6-2.4zM12 3L1 9l11 6 9-4.5V17h2V9L12 3z"/>',
                    'socio'     => '<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-.01L12 2z"/>',
                    'dirigente' => '<path d="M5 9.2h3V19H5zM10.6 5h2.8v14h-2.8zm5.6 8H19v6h-2.8z"/>',
                    'segretario'=> '<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>',
                    'cassiere'  => '<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>'
                ];
                foreach ($ruoli as $r) {
                    $id = 'r_'.$r;
                    echo "
                    <div class='ruolo-item'>
                        <input type='radio' name='ruolo' value='$r' id='$id' required>
                        <label for='$id'>
                            <svg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
                                {$icons[$r]}
                            </svg>
                            ".ucfirst($r)."
                        </label>
                    </div>";
                }
                ?>
            </div>

            <button type="submit">Registrati</button>
        </form>
    <?php endif; ?>

    <a href="index.php" class="back">← Torna alla Home</a>
</div>
    <script>
// Calcolo Codice Fiscale (semplificato)
function calcolaCF() {
    const nome = document.querySelector('[name="nome"]').value.trim();
    const cognome = document.querySelector('[name="cognome"]').value.trim();
    const luogo = document.querySelector('[name="luogo_nascita"]').value.trim().toUpperCase();
    const data = document.querySelector('[name="data_nascita"]').value;
    const sesso = document.querySelector('[name="sesso"]').value.toUpperCase();

    if (!nome || !cognome || !data || !sesso || !luogo) return;

    // funzione di codifica consonanti/vocali per cognome/nome
    function codCognome(c) {
        const consonanti = c.replace(/[^BCDFGHJKLMNPQRSTVWXYZ]/gi,'').toUpperCase();
        if (consonanti.length >= 3) return consonanti.substr(0,3);
        const vocali = c.replace(/[^AEIOU]/gi,'').toUpperCase();
        return (consonanti + vocali + 'XXX').substr(0,3);
    }
    function codNome(n) {
        const cons = n.replace(/[^BCDFGHJKLMNPQRSTVWXYZ]/gi,'').toUpperCase();
        if (cons.length === 3) return cons;
        if (cons.length > 3) return cons[0]+cons[2]+cons[3];
        const vow = n.replace(/[^AEIOU]/gi,'').toUpperCase();
        return (cons + vow + 'XXX').substr(0,3);
    }
    function codAnno(d) { return d.substr(2,2); }
    function codMese(d) {
        const m = parseInt(d.substr(5,2),10);
        const tab = ['A','B','C','D','E','H','L','M','P','R','S','T'];
        return tab[m-1];
    }
    function codGiorno(d, s) {
        const g = parseInt(d.substr(8,2),10);
        return (s === 'M' ? g : g + 40).toString().padStart(2,'0');
    }
    // codice catastale semplificato: prime 4 lettere
    function codLuogo(l) { return (l + 'XXXX').substr(0,4); }

    const cf =
        codCognome(cognome) +
        codNome(nome) +
        codAnno(data) +
        codMese(data) +
        codGiorno(data, sesso) +
        codLuogo(luogo);
    document.querySelector('[name="codice_fiscale"]').value = cf.toUpperCase();
}

// trigger su ogni cambio
['nome','cognome','luogo_nascita','data_nascita','sesso']
.forEach(el => document.querySelector(`[name="${el}"]`).addEventListener('input', calcolaCF));
</script>
</body>
</html>
