<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_modifierindicateur_charger_dist($id_indicateur,$url){
	$valeurs = array();

	$valeurs = sql_fetsel("*", "spip_indicateurs", "id_indicateur=$id_indicateur");
	$valeurs['thematiques']=array();
	
	$thematiques = sql_allfetsel("id_mot","spip_mots_liens","id_objet=$id_indicateur AND objet='indicateur'");
	foreach($thematiques as $v){
		$valeurs['thematiques'][$v['id_mot']]=1;
	}
	$valeurs['usage'] = sql_getfetsel(
		'L.id_mot',
		'spip_mots_liens AS L LEFT JOIN spip_mots AS M ON L.id_mot=M.id_mot',
		array(
			"L.id_objet = $id_indicateur",
			"L.objet = ".sql_quote('indicateur'),
			"M.id_groupe = 2"
		),
		"",
		"L.id_mot",
		"0,1"
	);
	return $valeurs;
}


function formulaires_modifierindicateur_verifier_dist($id_indicateur,$url){
	$erreurs=array();

	return $erreurs;
}

function formulaires_modifierindicateur_traiter_dist($id_indicateur,$url){
	$res = array();
	$valeurs=array(
		'titre'=>_request('titre'),
		'lieu'=>_request('lieu'),
		'source'=>_request('source'),
		'descriptif'=>_request('descriptif'),
		'interpretation'=>_request('interpretation'),
	);
	sql_updateq("spip_indicateurs",$valeurs,"id_indicateur=$id_indicateur");
	if(_request('suivant')){
		$res['redirect'] = generer_url_public('modifier_donnees',"id_indicateur=$id_indicateur");
	}else{
		$res['redirect'] = $url;
	}
	include_spip('action/editer_mot');
	$old_thematiques = sql_allfetsel(
		'L.id_mot',
		'spip_mots_liens AS L LEFT JOIN spip_mots AS M ON L.id_mot=M.id_mot',
		array(
			"L.id_objet = $id_indicateur",
			"L.objet = ".sql_quote('indicateur'),
			"M.id_groupe != 2"
		),
		"",
		"L.id_mot"
	);
	$oldmots=array();
	foreach($old_thematiques as $key => $value){
		if( !in_array( $value['id_mot'],array_keys( _request('thematiques') ) ) ){
			mot_dissocier($value['id_mot'], array('indicateur'=>$id_indicateur));
		}
		$oldmots[] = $value['id_mot'];
	}
	foreach(_request('thematiques') as $key => $value){
		if($value==1 && !in_array($key,$oldmots)){
			mot_associer($key, array('indicateur'=>$id_indicateur));
		}
	}
	$old_usage = sql_getfetsel(
		'L.id_mot',
		'spip_mots_liens AS L LEFT JOIN spip_mots AS M ON L.id_mot=M.id_mot',
		array(
			"L.id_objet = $id_indicateur",
			"L.objet = ".sql_quote('indicateur'),
			"M.id_groupe = 2"
		),
		"",
		"L.id_mot",
		"0,1"
	);
	if($old_usage != _request('usage')){
		include_spip('action/editer_mot');
		mot_associer(_request('usage'), array('indicateur'=>$id_indicateur));
		mot_dissocier($old_usage, array('indicateur'=>$id_indicateur));
	}
	// On invalide les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='indicateur/$id_indicateur'");
	return $res;	
}
?>
