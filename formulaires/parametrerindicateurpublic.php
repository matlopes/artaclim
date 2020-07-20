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
function formulaires_parametrerindicateurpublic_charger_dist(
	$id_indicateur,$url
) {
	$valeurs = array();
	
	if(isset($GLOBALS["visiteur_session"]["id_auteur"])){
		$valeurs['id_indicateur'] = $id_indicateur;
		$valeurs['type_graphique'] = 'line';
		$valeurs['donnees_dates'] = 0;
		$valeurs['autoriser_modifier_type_graphique'] = 1;
		$valeurs['autoriser_modifier_couleurs'] = 1;
		$valeurs['autoriser_modifier_bornes'] = 1;
		$valeurs['autoriser_modifier_donnees'] = 0;
		$valeurs['autoriser_telecharger_donnees'] = 0;
		$valeurs['autoriser_modifier_base'] = 0;
		$valeurs['autoriser_afficher_droite'] = 1;
		$valeurs['base'] = '';
		$valeurs['min'] = 0;
		$valeurs['max'] = 0;
		$valeurs['seuil'] = '';
		$valeurs['couleurs'] = array();
		$valeurs['couleurs_sous_base'] = array();
		$valeurs['enregistrer'] = '';
		$valeurs['afficher_droite'] = 0;
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

		$vals = unserialize(sql_getfetsel('config_indicateur','spip_indicateurs',"id_indicateur=$id_indicateur"));
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
		$valeurs['couleurs'] = $valeurs['couleurs'] + _COULEURS_DEFAUT;
		$valeurs['couleurs_sous_base'] = $valeurs['couleurs_sous_base'] + _COULEURS_INF_DEFAUT;
	}
	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_parametrerindicateurpublic_verifier_dist(
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
function formulaires_parametrerindicateurpublic_traiter_dist(
	$id_indicateur,$url
) {
	$res=array();
	$messages_erreur=array();
	if (count($messages_erreur)) {
		$res['message_erreur'] = 'erreur';
	}
	$res['message_ok'] = _T('artaclim:parametres_sauvegardes');

	$valeurs=array();
	$valeurs['type_graphique'] = _request('type_graphique');
	$valeurs['afficher_droite'] =  _request('afficher_droite');
	$valeurs['min'] =  _request('min');
	$valeurs['max'] =  _request('max');
	$valeurs['base'] =  _request('base');
	$valeurs['seuil'] =  _request('seuil');
	$valeurs['couleurs'] =  _request('couleurs');
	$valeurs['couleurs_sous_base'] =  _request('couleurs_sous_base');
	
	sql_updateq('spip_auteurs_liens' , 
			array('config_indicateur' => serialize($valeurs)) , 
			array("id_objet = $id_indicateur",
				"id_auteur = ".$GLOBALS["visiteur_session"]["id_auteur"],
				"objet = 'indicateur'") );


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

	$res['redirect']=$url;
	return $res;
}

