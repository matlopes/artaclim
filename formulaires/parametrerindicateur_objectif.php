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
function formulaires_parametrerindicateur_objectif_charger_dist(
	$id_indicateur,$url
) {
	$valeurs = array();

	$valeurs['id_indicateur'] = $id_indicateur;
	$valeurs['autoriser_modifier_donnees'] = 1;
	$valeurs['retourindicateurs'] = '';
	$valeurs['enregistrer'] = '';

	$vals=unserialize(sql_getfetsel('config_indicateur','spip_indicateurs',"id_indicateur=$id_indicateur"));

	foreach($vals as $k => $v){
		$valeurs[$k]=$v;
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_parametrerindicateur_objectif_verifier_dist(
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
function formulaires_parametrerindicateur_objectif_traiter_dist(
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
	$valeurs=unserialize(sql_getfetsel('config_indicateur','spip_indicateurs',"id_indicateur=$id_indicateur"));
	$valeurs['autoriser_modifier_donnees'] =  _request('autoriser_modifier_donnees');
	
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

