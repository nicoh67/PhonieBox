<?php

function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function file_cache($file) {
	$cache_file = dirname(__FILE__) .'/cache/'. str_replace(array(':', '/', '\\', '?', '|'), '_', $file);
	
	if(!file_exists($cache_file) || file_exists($cache_file) && filemtime($cache_file) + 60*3600 < date('U')) {

		if($html=curl_get_contents($file))
			file_put_contents($cache_file, $html);
	}
	
	Return $cache_file;
}





function filter_by_value($array, $index, $value, $return_approx_results_from_levenshtein_minor_than=false) {
	if(is_array($array) && count($array)>0)  
	{ 
		foreach(array_keys($array) as $key){ 
			$temp[$key] = $array[$key][$index]; 
			 
			if(
				$temp[$key] == $value
				||
				is_array($value) && in_array($temp[$key], $value)
				||
				$return_approx_results_from_levenshtein_minor_than && levenshtein($temp[$key], $value) < $return_approx_results_from_levenshtein_minor_than
			) {
				$newarray[$key] = $array[$key]; 
			}
		} 
	  } 
	return $newarray; 
} 


function sort_by_key($array, $index, $order=1) {
	$sort = array();
	//préparation d'un nouveau tableau basé sur la clé à trier
	if(is_array($array)) {
		foreach($array as $key => $val) {
			$sort[$key] = $val[$index];
		}
	}
	//tri par ordre naturel et insensible à la casse
	//natcasesort($sort);
	if($order==-1)
		arsort($sort);
	else
		asort($sort);

	//formation du nouveau tableau trié selon la clé
	$output = array();
	foreach($sort as $key => $val) {
		$output[$key] = $array[$key];
	}
	return $output;
}



function formatNumber($n) {
	if($n < 10)
		Return '0'. $n;
	Return $n;
}


function conv_octets($octet)
{
    // Array contenant les differents unités 
    $unite = array(' o',' Ko',' Mo',' Go');
    
    if ($octet < 1000) // octet
    {
        return $octet.$unite[0];
    }
    else 
    {
        if ($octet < 1000000) // ko
        {
            $ko = round($octet/1024,2);
            return $ko.$unite[1];
        }
        else // Mo ou Go 
        {
            if ($octet < 1000000000) // Mo 
            {
                $mo = round($octet/(1024*1024),2);
                return $mo.$unite[2];
            }
            else // Go 
            {
                $go = round($octet/(1024*1024*1024),2);
                return $go.$unite[3];    
            }
        }
    }
}


function speak($texte, $fichier="") {
	$texte = urlencode($texte);

	if(!$fichier)
		$fichier = __DIR__ ."/sounds/$texte.mp3";

	if(!file_exists($fichier)) {
		$mp3 = curl_get_contents("http://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=$texte&tl=fr");
		@mkdir(dirname($fichier), 0775, true);
		file_put_contents($fichier, $mp3);
		
		$fichier_dest = $fichier .".mp3";
		$cmd = "F:\\ffmpeg\\bin\\ffmpeg -i \"concat:". realpath($fichier) ."|silence-0.5sec.mp3\" -acodec mp3 -ar 44100 \"$fichier_dest\"";
		exec($cmd, $output, $ret);
		if(file_exists($fichier_dest))
			rename($fichier_dest, $fichier);

	}
	return $fichier;
}


?>