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


if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Retirer un indicateur du tableau de bord
 *
 * @param string $arg
 *     fournit les arguments de la fonction desepingler_indicateur
 *     sous la forme `$id_indicateur-desepingler`
 *
 *     - 1er arg : id_indicateur = id de l'indicateur à supprimer
 *     - 2eme arg : suppr = true, false sinon
 *
 * @return void
 */
function action_desepingler_indicateur_dist($arg = null) {
	if (is_null($arg)) {
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}

	$arg = explode('-', $arg);
	list($id_indicateur, $desepingler) = $arg;

	$suppr = false;
	if (count($arg) > 1 and $arg[1] == 'desepingler') {
		$desepingler = true;
	}
	if ($id_indicateur = intval($id_indicateur)
		and autoriser('desepingler_indicateur', 'indicateur',$id_indicateur)
	) {
		sql_updateq('spip_auteurs_liens', array('choisi_tableau' => 'non'),
			array(
				'id_objet = '.$id_indicateur,
				'objet = "indicateur"',
				'id_auteur = '.intval($GLOBALS["visiteur_session"]["id_auteur"])
			));
	} else {
		spip_log("Interdit de retirer l'indicateur $id_indicateur du tableau de bord", 'spip');
	}
}

