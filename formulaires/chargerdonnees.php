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
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $valeurs
 *    Les valeurs chargées dans le formulaire
 */
function formulaires_chargerdonnees_charger_dist(
	$id_indicateur,$url,$url_next=''
) {
	$valeurs = array();
//	$mode = joindre_determiner_mode($mode, $id_document, $objet);
	$mode = 'document';

	$valeurs['id_indicateur'] = $id_indicateur;
	$valeurs['_mode'] = $mode;
	$valeurs['id_document'] = '';
	$valeurs['url'] = 'http://';
	$valeurs['fichier_upload'] = '';
	$valeurs['joindre_upload'] =  '';
	

	$valeurs['id_objet'] = $id_indicateur;
	$valeurs['objet'] = 'indicateur';
	$valeurs['refdoc_joindre'] = '';
	if($url_next != ''){
	$valeurs['url_next'] = $url_next;
	}

	return $valeurs;
}

/**
 * Vérification du formulaire
 *
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $erreurs
 *    Les erreurs éventuelles dans un tableau
 */
function formulaires_chargerdonnees_verifier_dist(
	$id_indicateur,$url,$url_next=''
) {
	include_spip('inc/joindre_document');

	$erreurs = array();
	// on joint un document deja dans le site
	 // sinon c'est un upload
		$files = joindre_trouver_fichier_envoye();
		if (is_string($files)) {
			$erreurs['message_erreur'] = $files;
		} elseif (is_array($files)) {
			// erreur si on a pas trouve de fichier
			if (!count($files)) {
				$erreurs['message_erreur'] = _T('medias:erreur_aucun_fichier');
			} else {
				// regarder si on a eu une erreur sur l'upload d'un fichier
				foreach ($files as $file) {
					if (isset($file['error'])
						and $test = joindre_upload_error($file['error'])
					) {
						if (is_string($test)) {
							$erreurs['message_erreur'] = $test;
						} else {
							$erreurs['message_erreur'] = _T('medias:erreur_aucun_fichier');
						}
					}
				}

				
			}
		}

		if (count($erreurs) and defined('_TMP_DIR')) {
			effacer_repertoire_temporaire(_TMP_DIR);
		}

	return $erreurs;
}

/**
 * Traitement du formulaire
 *
 * @param int|string $id_document
 *    L'identidiant numérique du document s'il est à remplacer, sinon "new"
 * @param int $id_objet
 *    L'identifiant numérique de l'objet sur lequel on ajoute le document
 * @param string $objet
 *    Le type de l'objet sur lequel on ajoute le document
 * @param string $mode
 *    Le mode du document (auto,choix,document,image,vignette...), par défaut auto
 * @param string $galerie
 *    Passer optionnellement une galerie jointe au form, plus utilise nativement,
 *    on prefere la mise a jour apres upload par ajaxReload('documents')
 * @param bool|string $proposer_media
 *    Doit on afficher la médiathèque ?  par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @param bool|string $proposer_ftp
 *    Doit on afficher le ftp ? par défaut oui
 *    Valeurs possibles si string : false,'non','no'.
 * @return array $res
 *    Le tableau renvoyé par les CVT avec le message et editable
 */
function formulaires_chargerdonnees_traiter_dist(
	$id_indicateur,$url,$url_next=''
) {
	$res = array('editable' => true);
	$ancre = '';
	$ajouter_documents = charger_fonction('ajouter_documents', 'action');

	$mode = 'document';
	include_spip('inc/joindre_document');
	$files = joindre_trouver_fichier_envoye();

	$nouveaux_doc = $ajouter_documents($id_document, $files, 'indicateur', $id_indicateur, $mode);

	if (defined('_TMP_ZIP')) {
		unlink(_TMP_ZIP);
	}
	if (defined('_TMP_DIR')) {
		effacer_repertoire_temporaire(_TMP_DIR);
	}

	// checker les erreurs eventuelles
	$messages_erreur = array();
	$sel = array();
	foreach ($nouveaux_doc as $doc) {
		if (!is_numeric($doc)) {
			$messages_erreur[] = $doc;
		} // cas qui devrait etre traite en amont
		elseif (!$doc) {
			$messages_erreur[] = _T('medias:erreur_insertion_document_base', array('fichier' => '<em>???</em>'));
		} else {
			if (!$ancre) {
				$ancre = $doc;
			}
			$sel[] = $doc;
		}
	}
	if (count($messages_erreur)) {
		$res['message_erreur'] = implode('<br />', $messages_erreur);
	}
	if ($sel) {
		$res['message_ok'] = singulier_ou_pluriel(
			count($sel),
			'medias:document_installe_succes',
			'medias:nb_documents_installe_succes'
		);
	}
	//$res['redirect'] = $url;
	// On invalide les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='indicateur/$id_indicateur'");
	return $res;
}

