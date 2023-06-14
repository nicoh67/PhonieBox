<?php

include '../../vendor/autoload.php';
include '../functions.func.php';

// $niveaux_folders = glob("./*", GLOB_ONLYDIR);
$niveaux_folders = ['oiseaux'];
print "<pre>";
print_r($niveaux_folders);

foreach($niveaux_folders as $niveau_folder) {

    $instruments_folders = glob($niveau_folder .'/*', GLOB_ONLYDIR);

    foreach($instruments_folders as $instrument_folder) {

        rename($instrument_folder ."/1-chant.mp3", $instrument_folder ."/chant_0.mp3");
        // $texte = urlencode(basename($instrument_folder));
        
        // $mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=$texte&tl=fr");

        // file_put_contents($instrument_folder ."/00.mp3", $mp3);
        // print($instrument_folder ."/00.mp3<br>");
        // $instrument_folder = str_replace('/', '\\', $instrument_folder);
        // $cmd = "F:\\ffmpeg\\bin\\ffmpeg -i \"concat:". $instrument_folder ."\\00.mp3|..\silence-0.5sec.mp3\" -acodec mp3 -ar 44100 \"". $instrument_folder ."\\0.mp3\"";

        // @unlink($instrument_folder ."/0.mp3");
        // print($cmd);
        // exec($cmd, $output, $ret);
        // print_r([$output, $ret]);
        
        // unlink($instrument_folder .'\\00.mp3');

    }

}
print "</pre>";

?>