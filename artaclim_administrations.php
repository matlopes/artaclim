<?php


if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Mise a jour de la BDD
 *
 * @param string $nom_meta_base_version
 * @param string $version_cible
 */
function artaclim_upgrade($nom_meta_base_version, $version_cible) {

	$maj = array();
	$maj['create'] = array(
		array('maj_tables', array('spip_indicateurs', 'spip_types_indicateurs')),
		array('peupler_types_indicateurs'), //cf. base/artaclim.php
		array('sql_alter', "TABLE spip_auteurs_liens ADD config_indicateur text DEFAULT '' NOT NULL"),
		array('sql_alter', "TABLE spip_auteurs_liens ADD choisi_tableau VARCHAR(3) DEFAULT 'non' NOT NULL"),
		array('sql_alter', "TABLE spip_auteurs_liens ADD ordre_tableau INT(11) DEFAULT 100 NOT NULL"),
		array('ajouter_type_geojson') //cf. base/artaclim.php
	);
	$maj['0.2.1'] =array(
		array('sql_alter', "TABLE spip_auteurs_liens ADD choisi_tableau VARCHAR(3) DEFAULT 'non' NOT NULL")
	);
	$maj['0.3.2'] =array(
		array('sql_alter', "TABLE spip_indicateurs CHANGE config config_indicateur text DEFAULT '' NOT NULL")
	);
	$maj['0.3.3'] =array(
		array('sql_alter', "TABLE spip_auteurs DROP COLUMN disposition_tableau"),
		array('sql_alter', "TABLE spip_auteurs_liens ADD ordre_tableau INT(11) DEFAULT 100 NOT NULL")
	);
	include_spip('base/upgrade');
	include_spip('base/artaclim');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);

}

function artaclim_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_indicateurs");
	sql_drop_table("spip_types_indicateurs");
	sql_alter('TABLE spip_auteurs_liens DROP COLUMN config_indicateur');
	sql_alter('TABLE spip_auteurs_liens DROP COLUMN choisi_tableau');
	sql_alter('TABLE spip_auteurs_liens DROP COLUMN ordre_tableau');
	effacer_meta($nom_meta_base_version);
}

?>
