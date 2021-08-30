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
function formulaires_attribuerthematique_charger_dist(
	$id_auteur,$url=""
) {
	$valeurs = array();

	$valeurs['id_thematique'] = 1; // Par défaut, c'est le groupe 1 : adaptation au changement climatique.
	$valeurs['id_auteur'] = $id_auteur;
	$thematiques = sql_allfetsel(
		'id_objet',
		'spip_auteurs_liens',
		"id_auteur=$id_auteur AND objet='groupe_mots'",
		);
	if(isset($thematiques[0]['id_objet'])){
		$valeurs['id_thematique']=$thematiques[0]['id_objet'];
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * 
 */
function formulaires_attribuerthematique_verifier_dist(
	$id_auteur,$url=""
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
function formulaires_attribuerthematique_traiter_dist(
	$id_auteur,$url=""
) {
	$res=array();
	$messages_erreur=array();
	if (count($messages_erreur)) {
		$res['message_erreur'] = 'erreur';
	}
	if ($sel) {
		$res['message_ok'] = ' ok';
	}

	$id_thematique=intval(_request('id_thematique'));
	include_spip('action/editer_liens');
	objet_associer(array("auteur"=>$id_auteur), array("groupe_mots"=>$id_thematique));
	objet_dissocier(array("auteur"=>$id_auteur), array("groupe_mots"=>array('NOT', $id_thematique)));

	$res['redirect'] = generer_url_public('attribuer_indicateurs',array('id_auteur'=>$id_auteur));

	return $res;
}

