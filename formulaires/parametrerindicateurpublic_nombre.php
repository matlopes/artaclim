<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2019                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

/**
 * Gestion du formulaire de téléversement de documents
 *
 * @package SPIP\Medias\Formulaires
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Chargement du formulaire
 *
 * @return array $valeurs
 *    Les valeurs chargées dans le formulaire
 */
function formulaires_parametrerindicateurpublic_nombre_charger_dist(
	$id_indicateur,$url
) {
		$valeurs = array();

	$valeurs['id_indicateur'] = $id_indicateur;
	$valeurs['autoriser_modifier_donnees'] = 1;
	$valeurs['couleur'] = _COULEURS_DEFAUT[1];
	$valeurs['autoriser_modifier_couleurs'] = 1;
	$valeurs['autoriser_modifier_picto'] = 1;
	$valeurs['picto'] = '';
	$valeurs['enregistrer'] = '';

	$vals=unserialize(sql_getfetsel('config_indicateur','spip_indicateurs',"id_indicateur=$id_indicateur"));
	$vals_user = unserialize(sql_getfetsel('config_indicateur',
			'spip_auteurs_liens',
			array("id_objet = $id_indicateur",
				"id_auteur = ".$GLOBALS["visiteur_session"]["id_auteur"],
				"objet = 'indicateur'")));
	foreach($vals as $k => $v){
		if($v != NULL){
			$valeurs[$k]=$v;
		}
	}
	foreach($vals_user as $k => $v){
		if($v != NULL){
			$valeurs[$k]=$v;
		}
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_parametrerindicateurpublic_nombre_verifier_dist(
	$id_indicateur,$url
) {

	$erreurs = array();
	
	//$erreurs['test'] = 'erreur'	;

	return $erreurs;
}

/**
 * Traitement du formulaire
 *
 *
 */
function formulaires_parametrerindicateurpublic_nombre_traiter_dist(
	$id_indicateur,$url
) {
	$res=array();
	$messages_erreur=array();
	if (count($messages_erreur)) {
		$res['message_erreur'] = 'erreur';
	}
	if ($sel) {
		$res['message_ok'] = ' ok';
	}
	$valeurs=array();
	$valeurs=unserialize(sql_getfetsel('config_indicateur',
			'spip_auteurs_liens',
			array("id_objet = $id_indicateur",
				"id_auteur = ".$GLOBALS["visiteur_session"]["id_auteur"],
				"objet = 'indicateur'")));
	$valeurs['autoriser_modifier_donnees'] = _request('autoriser_modifier_donnees');
	$valeurs['autoriser_modifier_couleurs'] = _request('autoriser_modifier_couleurs');
	$valeurs['autoriser_modifier_picto'] = _request('autoriser_modifier_picto');
	$valeurs['picto'] = _request('picto');
	$valeurs['couleur'] = _request('couleur');

	sql_updateq('spip_auteurs_liens' , array('config_indicateur' => serialize($valeurs)) , array("id_objet = $id_indicateur",
				"id_auteur = ".$GLOBALS["visiteur_session"]["id_auteur"],
				"objet = 'indicateur'") );	

	$res['redirect'] = $url;

	// On invalide les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='indicateur/$id_indicateur'");
	return $res;
}

