<?php
session_start();
require_once 'config.php'; // File di configurazione del database
require_once 'codicefiscale.php'; // Libreria per il calcolo del CF

// Funzione per generare il codice fiscale
function generaCodiceFiscale($nome, $cognome, $data_nascita, $sesso, $luogo_nascita) {
    $cf = new CodiceFiscale();
    return $cf->calcola($nome, $cognome, $data_nascita, $sesso, $luogo_nascita);
}

// Processamento del form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupero dati dal form
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_nascita = $_POST['data_nascita'];
    $sesso = $_POST['sesso'];
    $luogo_nascita = $_POST['luogo_nascita'];
    $cf_calcolato = generaCodiceFiscale($nome, $cognome, $data_nascita, $sesso, $luogo_nascita);
    
    // Salva i dati nella sessione per il recupero dopo l'eventuale modifica
    $_SESSION['dati_registrazione'] = [
        'nome' => $nome,
        'cognome' => $cognome,
        'data_nascita' => $data_nascita,
        'sesso' => $sesso,
        'luogo_nascita' => $luogo_nascita,
        'cf_calcolato' => $cf_calcolato
    ];
    
    // Reindirizza alla pagina di conferma
    header('Location: conferma_registrazione.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione ASD Gi.Fra. Milazzo</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Registrazione ASD Gi.Fra. Milazzo</h1>
        
        <form id="registrationForm" method="post" action="registrazione.php">
            <!-- Campi esistenti del modulo -->
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome" required>
            </div>
            
            <div class="form-group">
                <label for="data_nascita">Data di nascita:</label>
                <input type="date" id="data_nascita" name="data_nascita" required>
            </div>
            
            <div class="form-group">
                <label for="sesso">Sesso:</label>
                <select id="sesso" name="sesso" required>
                    <option value="">Seleziona</option>
                    <option value="M">Maschio</option>
                    <option value="F">Femmina</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="luogo_nascita">Luogo di nascita:</label>
                <input type="text" id="luogo_nascita" name="luogo_nascita" required 
                       placeholder="Comune italiano o Stato estero">
                <div id="suggerimenti_luogo" class="suggerimenti"></div>
            </div>
            
            <div class="form-group">
                <label for="codice_fiscale">Codice Fiscale:</label>
                <input type="text" id="codice_fiscale" name="codice_fiscale" readonly 
                       placeholder="Verrà generato automaticamente">
            </div>
            
            <!-- Altri campi del modulo di iscrizione -->
            <!-- ... -->
            
            <button type="submit" class="btn btn-primary">Continua</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Funzione per generare il codice fiscale in tempo reale
            function generaCF() {
                const nome = $('#nome').val();
                const cognome = $('#cognome').val();
                const data_nascita = $('#data_nascita').val();
                const sesso = $('#sesso').val();
                const luogo_nascita = $('#luogo_nascita').val();
                
                if (nome && cognome && data_nascita && sesso && luogo_nascita) {
                    $.ajax({
                        url: 'calcola_cf.php',
                        method: 'POST',
                        data: {
                            nome: nome,
                            cognome: cognome,
                            data_nascita: data_nascita,
                            sesso: sesso,
                            luogo_nascita: luogo_nascita
                        },
                        success: function(response) {
                            $('#codice_fiscale').val(response);
                        }
                    });
                }
            }
            
            // Eventi per la generazione automatica
            $('#nome, #cognome, #data_nascita, #sesso').on('input change', generaCF);
            
            // Autocompletamento per il luogo di nascita
            $('#luogo_nascita').on('input', function() {
                const query = $(this).val();
                if (query.length > 2) {
                    $.ajax({
                        url: 'cerca_comune.php',
                        method: 'GET',
                        data: { q: query },
                        success: function(response) {
                            $('#suggerimenti_luogo').html(response).show();
                        }
                    });
                } else {
                    $('#suggerimenti_luogo').hide();
                }
            });
            
            // Selezione del suggerimento
            $(document).on('click', '.suggerimento', function() {
                $('#luogo_nascita').val($(this).text());
                $('#suggerimenti_luogo').hide();
                generaCF();
            });
        });
    </script>
</body>
</html>
