<?php
use KubAT\PhpSimple\HtmlDomParser;


$pages = [
    "aigle-royal",
    "aigrette-garzette",
    "avocette-elegante",
    "balbuzard-pecheur",
    "barge-a-queue-noire",
    "bergeronnette-grise",
    "bernache-du-canada",
    "bruant-des-roseaux",
    "busard-des-roseaux",
    "buse-variable",
    "canard-colvert",
    "chardonneret-elegant",
    "chevalier-gambette",
    "chouette-hulotte",
    "cigogne-blanche",
    "corneille-noire",
    "cygne-tubercule",
    "effraie-des-clochers",
    "faucon-crecerelle",
    "faucon-pelerin",
    "fauvette-a-tete-noire",
    "foulque-macroule",
    "fulmar-boreal",
    "gallinule-poule-deau",
    "geai-des-chenes",
    "gobemouche-a-collier",
    "goeland-argente",
    "grand-cormoran",
    "grande-aigrette",
    "grebe-huppe",
    "grimpereau-des-bois",
    "grive-musicienne",
    "heron-cendre",
    "hirondelle-de-fenetre",
    "huppe-fasciee",
    "martinet-noir",
    "martin-pecheur-deurope",
    "merle-noir",
    "mesange-bleue",
    "mesange-charbonniere",
    "mesange-huppee",
    "milan-noir",
    "moineau-domestique",
    "oie-cendree",
    "ouette-degypte",
    "perruche-a-collier",
    "pic-epeiche",
    "pic-vert",
    "pie-bavarde",
    "pigeon-ramier",
    "pinson-des-arbres",
    "pygargue-a-queue-blanche",
    "roitelet-huppe",
    "rouge-gorge-familier",
    "sarcelle-dete",
    "sittelle-torchepot",
    "spatule-blanche",
    "sterne-caugek",
    "tourterelle-turque",
    "troglodyte-mignon",
    "verdier-deurope",
];


include '../vendor/autoload.php';
include '../instruments/functions.func.php';

foreach($pages as $page) {
    set_time_limit(120);

    $f = "sources/$page.html";
    if(file_exists($f))
        $html = HtmlDomParser::file_get_html($f);
    else {
        $html = HtmlDomParser::file_get_html("https://www.chant-oiseaux.fr/$page", false, null, 0 );
        file_put_contents($f, $html);
    }

    $name = trim($html->find(".header h1")[0]->plaintext);

    $sounds = [];
    $soundtypes = $html->find("#soundtypes div");
    if(!empty($soundtypes)) {

        $bird_folder = "oiseaux/$name/";
        @mkdir($bird_folder, 0775, true);

        foreach($soundtypes as $soundtype) {
            
            if($soundtype->id) {
                $id = str_replace("type", "", $soundtype->id);
                $type = str_replace("/", "-", trim($soundtype->plaintext));
                $f_mp3 = $bird_folder . $type .'_'. $id .'.mp3';
                if(!file_exists($f_mp3))
                    file_put_contents($f_mp3, file_get_contents("https://www.chant-oiseaux.fr/sounds/". $id .".mp3"));
            }
        }

        $f_img = "$bird_folder/cover.jpg";
        
        if(!file_exists($f_img)) {
            $img_src = "https://www.chant-oiseaux.fr/images/". basename($html->find('#pic-div picture img')[0]->src);
            file_put_contents($f_img, file_get_contents($img_src));
        }

    }

}








die();

$niveaux_folders = glob("./*", GLOB_ONLYDIR);
print_r($niveaux_folders);

foreach($niveaux_folders as $niveau_folder) {

    $instruments_folders = glob($niveau_folder .'/*', GLOB_ONLYDIR);

    foreach($instruments_folders as $instrument_folder) {

        $texte = urlencode(basename($instrument_folder));
        /*
        $mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=${texte}&tl=fr");

        file_put_contents($instrument_folder ."/00.mp3", $mp3);
        print($instrument_folder ."/00.mp3<br>");
        $instrument_folder = str_replace('/', '\\', $instrument_folder);
        $cmd = "F:\\ffmpeg\\bin\\ffmpeg -i \"concat:". $instrument_folder ."\\00.mp3|silence-0.5sec.mp3\" -acodec mp3 -ar 44100 \"". $instrument_folder ."\\0.mp3\"";

        @unlink($instrument_folder ."/0.mp3");
        print($cmd);
        exec($cmd, $output, $ret);
        print_r([$output, $ret]);
        */
        unlink($instrument_folder .'\\00.mp3');

    }

}

?>