<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_epingler_charger_dist($id_indicateur){
	$valeurs = array();
	$valeurs['id_indicateur']=$id_indicateur;
	if(isset($GLOBALS["visiteur_session"]["id_auteur"])){
		$valeurs['choisi_tableau']=sql_getfetsel('choisi_tableau','spip_auteurs_liens',
			array(
				'id_objet = '.$id_indicateur,
				'objet = "indicateur"',
				'id_auteur = '.intval($GLOBALS["visiteur_session"]["id_auteur"])
			)
		);
	}else{
		$valeurs['choisi_tableau']='non';
	}
	return $valeurs;
}
function formulaires_epingler_verifier_dist($id_indicateur){
	return array();
}
function formulaires_epingler_traiter_dist($id_indicateur){
	sql_updateq('spip_auteurs_liens', array('choisi_tableau' => _request('choisi_tableau')),
			array(
				'id_objet = '.$id_indicateur,
				'objet = "indicateur"',
				'id_auteur = '.intval($GLOBALS["visiteur_session"]["id_auteur"])
			));
	return array(
		'message_ok' => "ok",
		'editable' => true
	);
}

?>
