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
 * Gestion de l'action dissocier_document
 *
 * @package SPIP\Medias\Action
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Supprimer un indicateur
 *
 * @param string $arg
 *     fournit les arguments de la fonction supprimer_indicateur
 *     sous la forme `$id_indicateur-suppr`
 *
 *     - 1er arg : id_indicateur = id de l'indicateur à supprimer
 *     - 2eme arg : suppr = true, false sinon
 *
 * @return void
 */
function action_supprimer_indicateur_dist($arg = null) {
	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	$arg = explode('-', $arg);
	list($id_indicateur, $suppr) = $arg;

	$suppr = false;
	if (count($arg) > 1 and $arg[1] == 'suppr') {
		$suppr = true;
	}
	if ($id_indicateur = intval($id_indicateur)
		and autoriser('supprimer_indicateur', 'indicateur',$id_indicateur)
	) {
		/* Supprimer indicateur et dissocier ses documents */
		sql_delete('spip_indicateurs',"id_indicateur=$id_indicateur");
		$mots=sql_allfetsel('id_mot','spip_mots_liens',"objet='indicateur' AND id_objet=$id_indicateur");
		include_spip('action/editer_mot');
		foreach($mots as $mot){
			mot_dissocier($mot['id_mot'], array('indicateur'=>$id_indicateur));
		}
		$docs=sql_allfetsel('id_document','spip_documents_liens',"objet='indicateur' AND id_objet=$id_indicateur");
		include_spip('action/dissocier_document');
		foreach($docs as $doc){
			dissocier_document($doc['id_document'], 'indicateur', $id_indicateur, $suppr);
		}

	} else {
		spip_log("Interdit de supprimer indicateur $id_indicateur", 'spip');
	}
}

