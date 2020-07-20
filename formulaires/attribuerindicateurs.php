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
function formulaires_attribuerindicateurs_charger_dist(
	$id_auteur,$url
) {
	$valeurs = array();

	$valeurs['id'] = $id_auteur;
	$valeurs['id_auteur'] = $id_auteur;
	$valeurs['indicateurs']=array();
	$indicateurs = sql_allfetsel('id_objet','spip_auteurs_liens',"id_auteur=$id_auteur AND objet='indicateur'");
	foreach($indicateurs as $indicateur){
		$valeurs['indicateurs'][]=$indicateur['id_objet'];
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_attribuerindicateurs_verifier_dist(
	$id_auteur,$url
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
function formulaires_attribuerindicateurs_traiter_dist(
	$id_auteur,$url
) {
	$res=array();
	$messages_erreur=array();
	if (count($messages_erreur)) {
		$res['message_erreur'] = 'erreur';
	}
	if ($sel) {
		$res['message_ok'] = ' ok';
	}

	$avant=array();
	$indicateurs = sql_allfetsel('id_objet','spip_auteurs_liens',"id_auteur=$id_auteur AND objet='indicateur'");
	foreach($indicateurs as $indicateur){
		$avant[]=$indicateur['id_objet'];
	}

	$apres=_request('indicateurs');

	include_spip('action/editer_liens');

	objet_associer(
		array('auteur'=>$id_auteur),
		array(
			'indicateur'=>$apres,
		)
	);
	objet_dissocier(
		array('auteur'=>$id_auteur),
		array(
			'indicateur'=>array_diff($avant,$apres),
		)
	);

	$res['redirect'] = $url;
	if(_request('retourindicateurs')){
		$res['redirect'] = generer_url_public('utilisateurs');
	}
	return $res;
}

