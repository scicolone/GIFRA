<?php
/*  CF.php – libreria per calcolo Codice Fiscale italiano
    Fonte: https://github.com/napolux/PHP-Italian-CodiceFiscale
*/
class CF {

    private $mesi = ['A','B','C','D','E','H','L','M','P','R','S','T'];
    private $pari  = ['0'=>1,'1'=>0,'2'=>5,'3'=>7,'4'=>9,'5'=>13,'6'=>15,'7'=>17,'8'=>19,'9'=>21,
                      'A'=>1,'B'=>0,'C'=>5,'D'=>7,'E'=>9,'F'=>13,'G'=>15,'H'=>17,'I'=>19,'J'=>21,
                      'K'=>2,'L'=>4,'M'=>18,'N'=>20,'O'=>11,'P'=>3,'Q'=>6,'R'=>8,'S'=>12,'T'=>14,
                      'U'=>16,'V'=>10,'W'=>22,'X'=>25,'Y'=>24,'Z'=>23];
    private $dispari = ['0'=>1,'1'=>0,'2'=>5,'3'=>7,'4'=>9,'5'=>13,'6'=>15,'7'=>17,'8'=>19,'9'=>21,
                        'A'=>1,'B'=>0,'C'=>5,'D'=>7,'E'=>9,'F'=>13,'G'=>15,'H'=>17,'I'=>19,'J'=>21,
                        'K'=>2,'L'=>4,'M'=>18,'N'=>20,'O'=>11,'P'=>3,'Q'=>6,'R'=>8,'S'=>12,'T'=>14,
                        'U'=>16,'V'=>10,'W'=>22,'X'=>25,'Y'=>24,'Z'=>23];

    private function codiceConsonanti($str,$num=3){
        $str=strtoupper($str);
        $consonanti=preg_replace('/[^BCDFGHJKLMNPQRSTVWXYZ]/','',$str);
        if(strlen($consonanti)>=$num) return substr($consonanti,0,$num);
        $vocali=preg_replace('/[^AEIOU]/','',$str);
        return str_pad($consonanti.$vocali,$num,'X',STR_PAD_RIGHT);
    }
    private function codNome($nome){
        $nome=strtoupper($nome);
        $consonanti=preg_replace('/[^BCDFGHJKLMNPQRSTVWXYZ]/','',$nome);
        if(strlen($consonanti)>=4) return $consonanti[0].$consonanti[2].$consonanti[3];
        if(strlen($consonanti)===3) return $consonanti;
        $vocali=preg_replace('/[^AEIOU]/','',$nome);
        return str_pad($consonanti.$vocali,3,'X',STR_PAD_RIGHT);
    }
    private function codGiorno($g,$s){
        return str_pad($s==='M'?$g:$g+40,2,'0',STR_PAD_LEFT);
    }
    private function codiceControllo($cf){
        $somma=0;
        for($i=0;$i<15;$i++){
            $c=$cf[$i];
            $somma += ($i%2==0) ? $this->dispari[$c] : $this->pari[$c];
        }
        $resto=$somma % 26;
        return chr(ord('A')+$resto);
    }

    public static function calcola($cognome,$nome,$data,$sesso,$comune){
        $cf=new self();
        $cognome=strtoupper($cognome);
        $nome=strtoupper($nome);
        $sesso=strtoupper($sesso);
        $comune=strtoupper($comune);

        // carica lista comuni
        $comuni=json_decode(file_get_contents(__DIR__.'/comuni.json'),true);
        $codice='Z999';
        foreach($comuni as $c){
            if($c['nome']===$comune){
                $codice=$c['codiceCatastale'];
                break;
            }
        }

        $anno=substr($data,2,2);
        $mese=$cf->mesi[substr($data,5,2)-1];
        $giorno=$cf->codGiorno(substr($data,8,2),$sesso);
        $cfStr=$cf->codiceConsonanti($cognome).$cf->codNome($nome).$anno.$mese.$giorno.$codice;
        return $cfStr.$cf->codiceControllo($cfStr);
    }
}
