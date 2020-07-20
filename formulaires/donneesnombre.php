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
function formulaires_donneesnombre_charger_dist(
	$id_indicateur,$url
) {
	$valeurs = array();
	$valeurs['url']=$url;
	$valeurs['id_indicateur'] = $id_indicateur;
	$valeurs['nombre'] = '';
	$valeurs['intitule'] = '';

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
function formulaires_donneesnombre_verifier_dist(
	$id_indicateur,$url
) {

	$erreurs = array();
	
	if(!is_numeric(_request('nombre'))){
		$erreurs['nombre'] = _T('artaclim:erreur_non_numerique');
	}

	return $erreurs;
}

/**
 * Traitement du formulaire
 *
 *
 */
function formulaires_donneesnombre_traiter_dist(
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
	$valeurs['nombre'] = _request('nombre');
	$valeurs['intitule'] =  _request('intitule');
	
	sql_updateq('spip_indicateurs' , array('config_indicateur' => serialize($valeurs)) , "id_indicateur=$id_indicateur" );	

	$res['redirect'] = $url;
	
	// On invalide les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='indicateur/$id_indicateur'");
	return $res;
}

