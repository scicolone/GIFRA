<?php
$query = $_GET['q'] ?? '';

if (strlen($query) > 2) {
    $comuni = json_decode(file_get_contents('comuni.json'), true);
    $stati = json_decode(file_get_contents('stati.json'), true);
    
    $risultati = [];
    
    // Cerca nei comuni italiani
    foreach ($comuni as $comune) {
        if (stripos($comune['nome'], $query) !== false) {
            $risultati[] = $comune['nome'];
        }
    }
    
    // Cerca negli stati esteri
    foreach ($stati as $stato) {
        if (stripos($stato['nome'], $query) !== false) {
            $risultati[] = $stato['nome'];
        }
    }
    
    // Limita i risultati
    $risultati = array_slice($risultati, 0, 10);
    
    // Mostra i suggerimenti
    foreach ($risultati as $risultato) {
        echo '<div class="suggerimento">' . htmlspecialchars($risultato) . '</div>';
    }
}
?>
