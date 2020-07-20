<?php

/*
*	Nettoyage des données pour affichage par Chart.js
*
*	@filtre
*/

function nettoyer_data($texte){

	//On évite le 
//	$texte = number_format(str_replace(' ','',$texte), 4, '.', '');
	//$texte=preg_replace('/\s/', '', $texte);
	if(!preg_match("/[a-z]/i", $texte)){
		//spip_log("Trouvé : $texte",_LOG_ERREUR);
		$texte=str_replace('&#44;','.',$texte);
		$texte=str_replace(',','.',$texte);
		//spip_log("Filtre 1 : $texte",_LOG_ERREUR);
		$texte=number_format(filter_var($texte,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),3,'.','');
		//spip_log("Filtre 2 : $texte",_LOG_ERREUR);
	}
	return (float)$texte;	
}

function extraire_mois($datestring){
	$dates=explode("/",$datestring);
	return $dates[1];
}

function extraire_jour($datestring){
	$dates=explode("/",$datestring);
	return $dates[0];
}

function fluidifier_images($texte){
	if($texte){
	$dom=new DOMDocument;
	$dom->loadHTML(mb_convert_encoding($texte, 'HTML-ENTITIES', 'UTF-8'));//, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD

	$images= $dom->getElementsByTagName('img');
	
	foreach ($images as $image) {
	   $image->setAttribute("class","img-fluid");
	}

	return $dom->saveHTML();	
	}else{
	return '';
	}
}
?>
