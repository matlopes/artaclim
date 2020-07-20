<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_creerindicateur_charger_dist(){
	$valeurs = array();
	$valeurs['_etapes']=2;
	$valeurs['type']=1;
	$valeurs['titre']='';
	$valeurs['descriptif']='';
	$valeurs['lieu']='';
	$valeurs['source']='';
	$valeurs['interpretation']='';
	$valeurs['thematiques']=array();
	$valeurs['usage']=sql_getfetsel(
		'id_mot',
		'spip_mots',
		'id_groupe = 2',
		'',
		'id_mot',
		'0,1'
	);

	return $valeurs;
}


function formulaires_creerindicateur_verifier_1_dist(){
	$erreurs=array();
	if(!_request('type')){
		$erreurs['type']=_T('artaclim:erreur_type');
	}
	return $erreurs;
}
function formulaires_creerindicateur_verifier_2_dist(){
	$erreurs=array();
	if(!_request('titre')){
		$erreurs['titre']=_T('info_obligatoire');
	}
	return $erreurs;
}

function formulaires_creerindicateur_traiter_dist(){
	$res = array();
	//créer indicateur en base et récupérer id_indicateur pour renvoyer à la page de liaison de document
	include_spip('action/editer_objet');
	if($id_indicateur = objet_inserer('indicateur', 0,array(
		'titre'=>_request('titre'),
		'id_type_indicateur' => _request('type'),
		'lieu'=>_request('lieu'),
		'source'=>_request('source'),
		'descriptif'=>_request('descriptif'),
		'interpretation'=>_request('interpretation'),
	))){
		if(in_array(_request('id_type_indicateur'),_TYPES_INDICATEURS_SANS_DATA)){
			$res['redirect'] = generer_url_public('parametrer_indicateur',array('id_indicateur' => $id_indicateur));
		}else{
			$res['redirect'] = generer_url_public('donnees_indicateur',array('id_indicateur' => $id_indicateur));
		}
	}else{
		spip_log("Le nouvel indicateur '"._request('titre')."' n'a pas pu être inséré");
		$res['message_erreur']=_T('artaclim:erreur_creation_indicateur');
	}
	include_spip('action/editer_mot');
	foreach(_request('thematiques') as $key => $value){
		if($value==1){
			mot_associer($key, array('indicateur'=>$id_indicateur));
		}
	}
	mot_associer(_request('usage'), array('indicateur'=>$id_indicateur));
	return $res;	
}
?>
