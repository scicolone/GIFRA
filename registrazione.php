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
            max-width:600px;
            width:100%;
            padding:40px 35px;
            box-shadow:0 8px 20px rgba(0,0,0,.25);
        }
        .card h2{margin-bottom:25px;text-align:center;color:#0d47a1}
        label{display:block;font-weight:600;margin-bottom:4px;margin-top:15px}
        input,select{
            width:100%;padding:10px;border:1px solid #ccc;border-radius:4px;font-size:15px
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
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
        .cf-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cf-container input {
            flex: 1;
        }
        .cf-container button {
            width: auto;
            padding: 10px;
            margin-top: 0;
            background: #0d47a1;
        }
        .cf-container button:hover {
            background: #083c8a;
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
        <form method="post" autocomplete="off" id="registrationForm">
            <div class="form-row">
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div class="form-group">
                    <label>Cognome</label>
                    <input type="text" name="cognome" id="cognome" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Sesso</label>
                    <select name="sesso" id="sesso" required>
                        <option value="">Seleziona</option>
                        <option value="M">Maschio</option>
                        <option value="F">Femmina</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Data di nascita</label>
                    <input type="date" name="data_nascita" id="data_nascita" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Luogo di nascita</label>
                    <input type="text" name="luogo_nascita" id="luogo_nascita" required>
                </div>
                <div class="form-group">
                    <label>Provincia di nascita</label>
                    <input type="text" name="provincia_nascita" id="provincia_nascita" maxlength="2" required>
                </div>
            </div>

            <label>Codice fiscale</label>
            <div class="cf-container">
                <input type="text" name="codice_fiscale" id="codice_fiscale" maxlength="16" required pattern="[A-Za-z0-9]{16}">
                <button type="button" id="calcolaCF">Calcola</button>
            </div>

            <label>Indirizzo</label>
            <input type="text" name="indirizzo" required>

            <div class="form-row">
                <div class="form-group">
                    <label>Comune di residenza</label>
                    <input type="text" name="comune_residenza" required>
                </div>
                <div class="form-group">
                    <label>Provincia di residenza</label>
                    <input type="text" name="provincia_residenza" maxlength="2" required>
                </div>
            </div>

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
// Funzione per calcolare il codice fiscale
function calcolaCodiceFiscale() {
    const nome = document.getElementById('nome').value.toUpperCase();
    const cognome = document.getElementById('cognome').value.toUpperCase();
    const sesso = document.getElementById('sesso').value;
    const dataNascita = document.getElementById('data_nascita').value;
    const luogoNascita = document.getElementById('luogo_nascita').value.toUpperCase();
    const provinciaNascita = document.getElementById('provincia_nascita').value.toUpperCase();
    
    if (!nome || !cognome || !sesso || !dataNascita || !luogoNascita || !provinciaNascita) {
        alert('Compila tutti i campi necessari per calcolare il codice fiscale: Nome, Cognome, Sesso, Data di nascita, Luogo e Provincia di nascita.');
        return;
    }
    
    // Estrai le parti della data di nascita
    const data = new Date(dataNascita);
    const giorno = data.getDate();
    const mese = data.getMonth() + 1; // I mesi partono da 0
    const anno = data.getFullYear().toString().substr(-2);
    
    // Calcola le consonanti del cognome
    let consCognome = cognome.replace(/[AEIOU ]/gi, '');
    let vocCognome = cognome.replace(/[BCDFGHJKLMNPQRSTVWXYZ ]/gi, '');
    
    // Se le consonanti sono meno di 3, aggiungi le vocali e poi le X
    let parteCognome = (consCognome + vocCognome + 'XXX').substr(0, 3);
    
    // Calcola le consonanti del nome
    let consNome = nome.replace(/[AEIOU ]/gi, '');
    let vocNome = nome.replace(/[BCDFGHJKLMNPQRSTVWXYZ ]/gi, '');
    
    let parteNome;
    if (consNome.length >= 4) {
        parteNome = consNome.charAt(0) + consNome.charAt(2) + consNome.charAt(3);
    } else {
        parteNome = (consNome + vocNome + 'XXX').substr(0, 3);
    }
    
    // Calcola l'anno di nascita (ultime due cifre)
    const parteAnno = anno;
    
    // Calcola il mese di nascita (lettera corrispondente)
    const lettereMesi = ['A','B','C','D','E','H','L','M','P','R','S','T'];
    const parteMese = lettereMesi[mese - 1];
    
    // Calcola il giorno di nascita (con aggiunta di 40 per le donne)
    let parteGiorno = giorno < 10 ? '0' + giorno : giorno.toString();
    if (sesso === 'F') {
        parteGiorno = (parseInt(parteGiorno) + 40).toString();
    }
    
    // Per il codice catastale, in un'implementazione reale si dovrebbe
    // interrogare un database di comuni. Per ora usiamo una semplificazione
    let parteLuogo = (luogoNascita.substring(0, 3) + provinciaNascita).toUpperCase();
    
    // Costruisci il codice fiscale parziale (manca il carattere di controllo)
    const cfParziale = parteCognome + parteNome + parteAnno + parteMese + parteGiorno + parteLuogo;
    
    // Calcola il carattere di controllo (algoritmo semplificato)
    // In un'implementazione reale, questo sarebbe più complesso
    const caratteriDispari = {
        '0':1, '1':0, '2':5, '3':7, '4':9, '5':13, '6':15, '7':17, '8':19, '9':21,
        'A':1, 'B':0, 'C':5, 'D':7, 'E':9, 'F':13, 'G':15, 'H':17, 'I':19, 'J':21,
        'K':2, 'L':4, 'M':18, 'N':20, 'O':11, 'P':3, 'Q':6, 'R':8, 'S':12, 'T':14,
        'U':16, 'V':10, 'W':22, 'X':25, 'Y':24, 'Z':23
    };
    
    const caratteriPari = {
        '0':0, '1':1, '2':2, '3':3, '4':4, '5':5, '6':6, '7':7, '8':8, '9':9,
        'A':0, 'B':1, 'C':2, 'D':3, 'E':4, 'F':5, 'G':6, 'H':7, 'I':8, 'J':9,
        'K':10, 'L':11, 'M':12, 'N':13, 'O':14, 'P':15, 'Q':16, 'R':17, 'S':18, 'T':19,
        'U':20, 'V':21, 'W':22, 'X':23, 'Y':24, 'Z':25
    };
    
    const carattereControllo = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    let somma = 0;
    for (let i = 0; i < cfParziale.length; i++) {
        const c = cfParziale.charAt(i);
        if ((i + 1) % 2 === 0) { // Caratteri pari
            somma += caratteriPari[c];
        } else { // Caratteri dispari
            somma += caratteriDispari[c];
        }
    }
    
    const resto = somma % 26;
    const controllo = carattereControllo.charAt(resto);
    
    // Codice fiscale completo
    const codiceFiscale = cfParziale + controllo;
    
    // Inserisci nel campo
    document.getElementById('codice_fiscale').value = codiceFiscale;
}

// Aggiungi l'event listener al pulsante di calcolo
document.getElementById('calcolaCF').addEventListener('click', calcolaCodiceFiscale);

// Aggiungi anche il calcolo automatico quando tutti i campi sono compilati
const campiCF = ['nome', 'cognome', 'sesso', 'data_nascita', 'luogo_nascita', 'provincia_nascita'];
campiCF.forEach(campo => {
    document.getElementById(campo).addEventListener('change', function() {
        // Verifica se tutti i campi necessari sono compilati
        const tuttiCompilati = campiCF.every(id => document.getElementById(id).value);
        if (tuttiCompilati && !document.getElementById('codice_fiscale').value) {
            calcolaCodiceFiscale();
        }
    });
});
</script>
</body>
</html>
