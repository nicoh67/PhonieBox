<?php

include '../../vendor/autoload.php';
include '../functions.func.php';

// $niveaux_folders = glob("./*", GLOB_ONLYDIR);
$niveaux_folders = ['oiseaux'];

print_r($niveaux_folders);


foreach($niveaux_folders as $niveau_folder) {

    $instruments_folders = glob($niveau_folder .'/*', GLOB_ONLYDIR);

    foreach($instruments_folders as $instrument_folder) {

        $texte = urlencode(basename($instrument_folder));

        // if(!file_exists($instrument_folder ."/0.mp3") && !file_exists($instrument_folder ."/00.mp3")) {
        //     $mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=$texte&tl=fr");
            
        //     file_put_contents($instrument_folder ."/00.mp3", $mp3);
        //     print($instrument_folder ."/00.mp3<br>");

        // }

        // if(!file_exists($instrument_folder ."/0.mp3")) {

        //     $instrument_folder = str_replace('/', '\\', $instrument_folder);
        //     $cmd = "F:\\ffmpeg\\bin\\ffmpeg -i \"concat:". $instrument_folder ."\\00.mp3|..\\silence-0.5sec.mp3\" -acodec mp3 -ar 44100 \"". $instrument_folder ."\\0.mp3\"";
        //     // @unlink($instrument_folder ."/0.mp3");
        //     exec($cmd, $output, $ret);
        // }

        // @unlink($instrument_folder .'\\00.mp3');


        $instrument_folder = str_replace('/', '\\', $instrument_folder);

        $sons = glob($instrument_folder ."/*.mp3");
        foreach($sons as $son) {
            
            if(basename($son)=="0.mp3" || basename($son)=="00.mp3" || strstr(basename($son, ".mp3"), "_")===false)
                continue;
                
            $texte_a_lire = explode("_", basename($son));
            $texte_a_lire = $texte_a_lire[0];

            $file_mp3 = speak($texte_a_lire);

            
            copy($file_mp3, "$instrument_folder/$texte_a_lire.mp3");
            // $son_dest = dirname($son) ."/". basename($son);
            // $son_dest = (dirname(realpath($son_dest)) ."\\". basename($son_dest, ".mp3")) ."_1.mp3";
            
            // $cmd = "F:\\ffmpeg\\bin\\ffmpeg -i \"concat:". realpath($file_mp3) ."|silence-0.5sec.mp3|". realpath($son) ."\" -acodec mp3 -ar 44100 \"$son_dest\"";
            // exec($cmd, $output, $ret);
            // dump([$output, $ret]);
            // dd([ $texte_a_lire , $son_dest , $cmd]);
            // print_r("$cmd\n");
        }


        // @unlink($instrument_folder ."/0.mp3");
        // dump($cmd);
        // exec($cmd, $output, $ret);
        // print_r([$output, $ret]);
        
        // unlink($instrument_folder .'\\00.mp3');

    }

}

?>