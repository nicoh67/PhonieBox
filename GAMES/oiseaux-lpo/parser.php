<?php
use KubAT\PhpSimple\HtmlDomParser;


$pages = [
    'Chant_Alouettes_pipits_bergeronnettes',
    'Chant_Faucons_chouettes_hiboux',
    'Chant_Fauvettes_pouillots_roitelets',
    'Chant_Gobemouches_pies-grieches_bruants',
    'Chant_Herons_faisans_pigeons_tourterelles_coucous_engoulevents_perruches',
    'Chant_Hirondelles_martinets_huppe_guepier',
    'Chant_Mesanges',
    'Chant_Pics_sittelles_grimpereaux',
    'Chant_Pies_geais_choucas_corbeaux_corneilles',
    'Chant_Pinsons_linottes_chardonnerets_verdiers_serins_bouvreuils_grosbecs',
    'Chant_Rougegorges_rossignols_rougequeues_grives_loriots_merles_etourneaux',
    'Chant_Troglodytes_accenteurs_moineaux'
];


include '../../vendor/autoload.php';
include '../functions.func.php';

$site = "https://www.lpo-idf.fr";

@mkdir("sources");

foreach($pages as $page) {
    set_time_limit(120);

    $f = "sources/$page.html";
    if(file_exists($f))
        $html = HtmlDomParser::file_get_html($f);
    else {
        $html = HtmlDomParser::file_get_html("$site/$page", false, null, 0 );
        file_put_contents($f, $html);
    }

    $name = trim($html->find("#snq h1")[0]->plaintext);

    $sounds = [];
    $soundsTables = $html->find("#snq table");


    if(!empty($soundsTables)) {

        $bird_folder = "oiseaux/";
        @mkdir($bird_folder, 0775, true);

        foreach($soundsTables as $soundsTable) {
            $birdsTable = [ 0 => [], 1 => [], 2 => [] ];
            
            $soundsTablesTds = $soundsTable->find("td");
            
            $imgs = $soundsTable->find("img");
            foreach($imgs as $k=>$img) {
                $birdsTable[$k]['image'] = $site ."/". $img->src;
            }

            $audios = $soundsTable->find("audio");
            foreach($audios as $k=>$audio) {
                $birdsTable[$k]['mp3'] = $site ."/". $audio->src;
            }

            $titles = $soundsTable->find(".leg strong");
            foreach($titles as $k=>$title) {
                $birdsTable[$k]['title'] = $title->innertext;
            }

            $titles = $soundsTable->find(".leg em");
            foreach($titles as $k=>$title) {
                $birdsTable[$k]['title_latin'] = $title->innertext;
            }

            foreach($birdsTable as $bird) {
                if(!empty($bird)) {
                    
                    dump($bird);
                    @mkdir($bird_folder . $bird['title']);
                    $f_mp3 = $bird_folder . $bird['title'] .'/1-chant.mp3';
                    if(!file_exists($f_mp3))
                        file_put_contents($f_mp3, file_get_contents($bird['mp3']));

                    $f_img = $bird_folder . $bird['title'] .'/cover.jpg';
                    if(!file_exists($f_img))
                        file_put_contents($f_img, file_get_contents($bird['image']));
                    
                }
    
                }


            // if($soundtype->id) {
            //     $id = str_replace("type", "", $soundtype->id);
            //     $type = str_replace("/", "-", trim($soundtype->plaintext));
            //     $f_mp3 = $bird_folder . $type .'_'. $id .'.mp3';
            //     if(!file_exists($f_mp3))
            //         file_put_contents($f_mp3, file_get_contents("$site/sounds/". $id .".mp3"));
            // }
        }

        // $f_img = "$bird_folder/cover.jpg";
        
        // if(!file_exists($f_img)) {
        //     $img_src = "$site/images/". basename($html->find('#pic-div picture img')[0]->src);
        //     file_put_contents($f_img, file_get_contents($img_src));
        // }

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