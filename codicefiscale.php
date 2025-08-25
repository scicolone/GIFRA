<?php
class CodiceFiscale {
    private $mesi = array('A', 'B', 'C', 'D', 'E', 'H', 'L', 'M', 'P', 'R', 'S', 'T');
    
    public function calcola($nome, $cognome, $data_nascita, $sesso, $luogo_nascita) {
        // Calcolo lettere cognome
        $cognome_cf = $this->calcolaCognome($cognome);
        
        // Calcolo lettere nome
        $nome_cf = $this->calcolaNome($nome);
        
        // Calcolo data e sesso
        $data_sesso_cf = $this->calcolaDataSesso($data_nascita, $sesso);
        
        // Calcolo codice luogo
        $luogo_cf = $this->calcolaLuogo($luogo_nascita);
        
        // Calcolo carattere di controllo
        $cf = $cognome_cf . $nome_cf . $data_sesso_cf . $luogo_cf;
        $cf .= $this->calcolaCarattereControllo($cf);
        
        return $cf;
    }
    
    private function calcolaCognome($cognome) {
        $consonanti = preg_replace('/[AEIOU]/i', '', strtoupper($cognome));
        $vocali = preg_replace('/[^AEIOU]/i', '', strtoupper($cognome));
        
        $codice = substr($consonanti, 0, 3);
        if (strlen($codice) < 3) {
            $codice .= substr($vocali, 0, 3 - strlen($codice));
        }
        if (strlen($codice) < 3) {
            $codice .= str_repeat('X', 3 - strlen($codice));
        }
        
        return $codice;
    }
    
    private function calcolaNome($nome) {
        $consonanti = preg_replace('/[AEIOU]/i', '', strtoupper($nome));
        $vocali = preg_replace('/[^AEIOU]/i', '', strtoupper($nome));
        
        if (strlen($consonanti) >= 4) {
            $codice = $consonanti[0] . $consonanti[2] . $consonanti[3];
        } else {
            $codice = substr($consonanti, 0, 3);
            if (strlen($codice) < 3) {
                $codice .= substr($vocali, 0, 3 - strlen($codice));
            }
        }
        if (strlen($codice) < 3) {
            $codice .= str_repeat('X', 3 - strlen($codice));
        }
        
        return $codice;
    }
    
    private function calcolaDataSesso($data_nascita, $sesso) {
        $data = new DateTime($data_nascita);
        $anno = substr($data->format('Y'), -2);
        $mese = $this->mesi[$data->format('n') - 1];
        $giorno = $data->format('j');
        
        if (strtoupper($sesso) == 'F') {
            $giorno += 40;
        }
        
        return $anno . $mese . str_pad($giorno, 2, '0', STR_PAD_LEFT);
    }
    
    private function calcolaLuogo($luogo_nascita) {
        // Carica il database dei comuni
        $comuni = json_decode(file_get_contents('comuni.json'), true);
        
        // Cerca il comune
        foreach ($comuni as $comune) {
            if (strtoupper($comune['nome']) == strtoupper($luogo_nascita)) {
                return $comune['codicecatastale'];
            }
        }
        
        // Se non trovato, cerca negli stati esteri
        $stati = json_decode(file_get_contents('stati.json'), true);
        foreach ($stati as $stato) {
            if (strtoupper($stato['nome']) == strtoupper($luogo_nascita)) {
                return $stato['codice'];
            }
        }
        
        // Default per luoghi non trovati
        return 'Z000';
    }
    
    private function calcolaCarattereControllo($cf) {
        $valori = array(
            '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
            'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9,
            'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18,
            'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25
        );
        
        $dispari = array(
            0 => 1, 1 => 0, 2 => 5, 3 => 7, 4 => 9, 5 => 13, 6 => 15, 7 => 17, 8 => 19, 9 => 21,
            10 => 2, 11 => 4, 12 => 18, 13 => 20, 14 => 11, 15 => 3, 16 => 6, 17 => 8, 18 => 12,
            19 => 14, 20 => 16, 21 => 10, 22 => 22, 23 => 25, 24 => 24, 25 => 23
        );
        
        $somma = 0;
        for ($i = 0; $i < 15; $i++) {
            $char = $cf[$i];
            $valore = $valori[$char];
            
            if ($i % 2 == 0) { // Posizioni dispari (1,3,5,...)
                $somma += $dispari[$valore];
            } else { // Posizioni pari
                $somma += $valore;
            }
        }
        
        $resto = $somma % 26;
        return chr(65 + $resto);
    }
}
?>
