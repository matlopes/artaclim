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
 * Déclarations relatives à la base de données
 *
 * @package SPIP\Medias\Pipelines
 **/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Interfaces des tables documents pour le compilateur
 *
 * @param array $interfaces
 * @return array
 */
function artaclim_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['indicateurs'] = 'indicateurs';
	$interfaces['table_des_tables']['types_indicateurs'] = 'types_indicateurs';

	return $interfaces;
}


/**
 * Table principale spip_types_indicateurs
 *
 * @param array $tables_principales
 * @return array
 */
function artaclim_declarer_tables_principales($tables_principales) {
	$spip_types_indicateurs = array(
		'id_type_indicateur' => "bigint(21) NOT NULL",
		'titre' => "text DEFAULT '' NOT NULL",
		'mode' => "ENUM('numerique', 'carto','pilotage') DEFAULT 'numerique'  NOT NULL",
		'maj' => 'TIMESTAMP'
	);
	$spip_types_indicateurs_key = array(
		'PRIMARY KEY' => 'id_type_indicateur'
	);
	$tables_principales['spip_types_indicateurs'] =
		array('field' => &$spip_types_indicateurs, 'key' => &$spip_types_indicateurs_key);

	return $tables_principales;
}

/**
 * Table des liens RAS
 *
 * @param array $tables_auxiliaires
 * @return array
 */
function artaclim_declarer_tables_auxiliaires($tables_auxiliaires) {

	return $tables_auxiliaires;
}

/**
 * Declarer le surnom des types d'indicateurs au singulier
 *
 * @param array $surnoms
 * @return array
 */
function artaclim_declarer_tables_objets_surnoms($surnoms) {
	$surnoms['type_indicateur'] = 'types_indicateurs';
	return $surnoms;
}

/**
 * Declarer l'objet indicateur suivant https://www.spip.net/fr_article5525.html
 *
 * @param array $surnoms
 * @return array
 */
function artaclim_declarer_tables_objets_sql($tables) {
	$tables['spip_indicateurs']=array(
		'table_objet' => 'indicateurs',
		'type' => 'indicateur',
		'principale' => 'oui',
		'field'=>array(
			'id_indicateur' => 'bigint(21) NOT NULL',
			'id_type_indicateur' => 'bigint(21) NOT NULL',
			'titre' => "text DEFAULT '' NOT NULL",
			'descriptif' => "text DEFAULT '' NOT NULL",
			'interpretation' => "text DEFAULT '' NOT NULL",
			'source' => "text DEFAULT '' NOT NULL",
			'lieu' => "text DEFAULT '' NOT NULL",
			'config_indicateur' => "text DEFAULT '' NOT NULL",
			'date' => "datetime DEFAULT CURRENT_TIMESTAMP NOT NULL",
			'maj' => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY' => 'id_indicateur',
			'KEY' => 'id_type_indicateur',
		),
		
		'titre' => 'titre',
		'date' => 'date',
		'rechercher_champs' => array(
			'titre' => 3,
			'descriptif' => 2,
			'interpretation' => 1,
		),

		'texte_objets' => 'artaclim:texte_objets',
		'texte_objet' => 'artaclim:texte_objet',
		'texte_modifier' => 'artaclim:texte_modifier',
		'info_aucun_objet' => 'artaclim:info_aucun_objet',
		'info_1_objet' => 'artaclim:info_1_objet',
		'info_nb_objets' => 'artaclim:info_nb_objets',
	);
	
	return $tables;
}

function peupler_types_indicateurs(){
	include_spip('base/abstract_sql');
	$types_indicateurs=array(
		array('titre' => 'Simple',
			'mode' => 'numerique'),
		array('titre' => 'Multiple',
			'mode' => 'numerique'),
		array('titre' => 'Multiple - parties d\'un tout',
			'mode' => 'numerique'),
		array('titre' => 'Spatial simple',
			'mode' => 'carto'),
		array('titre' => 'Avancée sur objectif',
			'mode' => 'pilotage'),
		array('titre' => 'Nombre simple',
			'mode' => 'pilotage'),
	);
	sql_insertq_multi('spip_types_indicateurs', $types_indicateurs);
}

function ajouter_type_geojson(){
	include_spip('base/abstract_sql');
	sql_insertq('spip_types_documents',
		array(
			'extension' => 'geojson',
			'titre' => 'GeoJSON',
			'mime_type' => 'application/geo+json',
			'inclus' => 'non',
			'upload' => 'oui',
			'media_defaut' => 'file'
		)
	);
}

?>
