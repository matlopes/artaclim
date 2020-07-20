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
function formulaires_parametrerindicateur_charger_dist(
	$id_indicateur,$url
) {
	$valeurs = array();

	$valeurs['id_indicateur'] = $id_indicateur;
	$valeurs['type_graphique'] = 'line';
	$valeurs['donnees_dates'] = 0;
	$valeurs['autoriser_modifier_type_graphique'] = 1;
	$valeurs['autoriser_modifier_couleurs'] = 1;
	$valeurs['autoriser_modifier_bornes'] = 1;
	$valeurs['autoriser_modifier_donnees'] = 0;
	$valeurs['autoriser_modifier_base'] = 0;
	$valeurs['autoriser_telecharger_donnees'] = 0;
	$valeurs['empiler'] = 0;
	$valeurs['autoriser_afficher_droite'] = 1;
	$valeurs['base'] = '';
	$valeurs['min'] = 0;
	$valeurs['max'] = 0;
	$valeurs['suggestedmin'] = '';
	$valeurs['suggestedmax'] = '';
	$valeurs['seuil'] = '';
	$valeurs['couleurs'] = array();
	$valeurs['couleurs_sous_base'] = array();
	$valeurs['retourindicateurs'] = '';
	$valeurs['enregistrer'] = '';

	$vals=unserialize(sql_getfetsel('config_indicateur','spip_indicateurs',"id_indicateur=$id_indicateur"));

	foreach($vals as $k => $v){
		$valeurs[$k]=$v;
	}

	$valeurs['couleurs'] = $valeurs['couleurs'] + _COULEURS_DEFAUT;
	$valeurs['couleurs_sous_base'] = $valeurs['couleurs_sous_base'] + _COULEURS_INF_DEFAUT;

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_parametrerindicateur_verifier_dist(
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
function formulaires_parametrerindicateur_traiter_dist(
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
	$valeurs['type_graphique'] = _request('type_graphique');
	$valeurs['autoriser_modifier_type_graphique'] =  _request('autoriser_modifier_type_graphique');
	$valeurs['autoriser_modifier_couleurs'] =  _request('autoriser_modifier_couleurs');
	$valeurs['donnees_dates'] =  _request('donnees_dates');
	$valeurs['autoriser_modifier_bornes'] =  _request('autoriser_modifier_bornes');
	$valeurs['autoriser_modifier_base'] =  _request('autoriser_modifier_base');
	$valeurs['autoriser_modifier_donnees'] =  _request('autoriser_modifier_donnees');
	$valeurs['autoriser_telecharger_donnees'] =  _request('autoriser_telecharger_donnees');
	$valeurs['autoriser_afficher_droite'] =  _request('autoriser_afficher_droite');
	$valeurs['empiler'] =  _request('empiler');
	$valeurs['base'] =  _request('base');
	$valeurs['min'] =  _request('min');
	$valeurs['max'] =  _request('max');
	$valeurs['suggestedmin'] = _request('suggestedmin');
	$valeurs['suggestedmax'] = _request('suggestedmax');
	$valeurs['seuil'] =  _request('seuil');
	$valeurs['couleurs'] =  _request('couleurs');
	$valeurs['couleurs_sous_base'] =  _request('couleurs_sous_base');
	
	sql_updateq('spip_indicateurs' , array('config_indicateur' => serialize($valeurs)) , "id_indicateur=$id_indicateur" );	

	$res['redirect'] = $url;
	if(_request('retourindicateurs')){
		$res['redirect'] = generer_url_public('indicateurs');
	}
	// On invalide les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='indicateur/$id_indicateur'");
	return $res;
}

