<?php

include 'functions.func.php';

$texte = "bonjour";

$mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=${texte}&tl=fr");

file_put_contents("bonjour.mp3", $mp3);


$niveaux_folders = glob("./*", GLOB_ONLYDIR);


foreach($niveaux_folders as $niveau_folder) {

    $instruments_folders = glob($niveau_folder .'*', GLOB_ONLYDIR);

    foreach($instruments_folders as $instrument_folder) {

        $texte = basename($instrument_folder);
        $mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=${texte}&tl=fr");

        file_put_contents($instrument_folder ."/0.mp3", $mp3);
    }

}

?>