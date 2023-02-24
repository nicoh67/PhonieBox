<?php
include '../vendor/autoload.php';
include 'functions.func.php';

$folder = isset($_GET['folder']) ? $_GET['folder'] : "";

$niveaux_folders = glob("./$folder/*", GLOB_ONLYDIR);
// $niveaux_folders = ['oiseaux'];

?>
<style>
body {
    font-family:Arial, Helvetica, sans-serif;
    margin: 0;
}
h2 {
    padding: 10px;
    background: #EEE;
    position: sticky;
    border-bottom: 1px solid #CCC;
    margin: 0;
    top: 0;
    left: 0;
    width: 100%;
    box-sizing: border-box;
}
.cartes {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 4em;
}    
.cartes .carte {
    width:400px;
    padding: 6px;
    display: flex;
    justify-items: auto;
}
.cartes .carte .carte_contents {
    background: #EEE;
    display: flex;
    border: 1px solid #000;

}
.cartes .carte .img {
    /* display: flex; */
    /* align-items: center; */
    padding: 5px;
}
.cartes .carte .img img {
    width:100%;
}
.cartes .carte .details {
    width: 150px;
    flex-shrink: 0;
    padding: 5px;
    text-align: center;
}

.cartes .carte .texte {
    padding: 5px;
    background: #DDD;
    text-align: center;
}
.sounds > div {
    padding: 5px;
}
.sounds a {
    text-decoration: none;
    color: #88F;
}

#player {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background: #CCC;
    border-top: 1px solid #888;
    display: flex;
    align-items: center;
}
#player_title {
    white-space: nowrap;
    padding: 10px;
}
#player audio {
    width: 100%;
    border: 0;
}

</style>

<?php

foreach($niveaux_folders as $niveau_folder) {

    $objects_folders = glob($niveau_folder .'/*', GLOB_ONLYDIR);

    echo('
    <h2>'. basename($niveau_folder) .'</h2>
    <div class=cartes>');
    foreach($objects_folders as $object_folder) {
        $texte = basename($object_folder);

        $sounds = glob($object_folder .'/*.mp3');


        echo("
        <div class=carte>
            <div class=carte_contents>
                <div class=img><img src=\"$object_folder/cover.jpg\" /></div>
                <div class=details>
                    <div class=texte>$texte</div>
                    <div class=sounds>
                        <div>
        ");
        echo(implode('</div>
                        <div>', array_filter(array_map(function($v) use ($texte) {
                            $r = explode("_", str_replace(".mp3", "", basename($v)));
                            // if(!$r[0])
                            //     return false;
                            return "<a title=\"$texte - ". $r[0] ."\" href=\"$v\">". $r[0] ."</a>";
                        }, $sounds))));
                
        echo("
                        </div>
                    </div>
                </div>
            </div>
        </div>");
    }
    echo('
    </div>');

}

?>

<div id=player>
    <div id=player_title>Lecteur audio</div>
    <audio id=audio controls></audio>
</div>


<script>

let $audio = document.getElementById('audio');

document.querySelectorAll('.sounds a').forEach(elem => {

    elem.addEventListener('click', e => {
        e.preventDefault();
        $audio.src = elem.getAttribute('href');
        console.log(elem);
        $audio.load();
        document.getElementById('player_title').innerHTML = elem.getAttribute('title');
        $audio.play();
    });

});

</script>