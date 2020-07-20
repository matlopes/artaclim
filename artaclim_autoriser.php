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
 * Définit les autorisations du plugin Artaclim
 *
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Fonction d'appel pour le pipeline
 *
 * @pipeline autoriser
 */
function artaclim_autoriser() {
}

function autoriser_supprimer_indicateur_dist($faire, $type, $id, $qui, $opt) {
	if ($qui['statut'] == '0minirezo'
		and !$qui['restreint']
	) {
		return true;
	}
}

function autoriser_desepingler_indicateur_dist($faire, $type, $id, $qui, $opt) {
	if (isset($GLOBALS["visiteur_session"]["id_auteur"]) ) {
		return true;
	}else{
		return false;
	}
}

/**
 * Fonction pour autoriser à modifier un indicateur
 * Cette fonction est appellée pour l'action dissocier_document sur un indicateur,
 * elle doit donc être permise pour les indicateurs sur lesquels on peut modifier les données
*/

function autoriser_indicateur_modifier_dist($faire, $type, $id, $qui, $opt){
	if ($qui['statut'] == '0minirezo'
		and !$qui['restreint']
	) {
		return true;
	}
	$config_indicateur = unserialize(sql_getfetsel('config_indicateur','spip_indicateurs','id_indicateur = '.$id));
	if(isset($config_indicateur['autoriser_modifier_donnees'])){
		return ($config_indicateur['autoriser_modifier_donnees']==1);
	}
	return false;
}
?>
