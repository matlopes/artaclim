<?php

function artaclim_jqueryui_plugins($scripts){
   $scripts[] = "jquery.ui.slider";
   return $scripts;
} 

function artaclim_declarer_champs_extras($champs = array()) {

	
	// Table : spip_documents
	if (!is_array($champs['spip_documents'])) {
		$champs['spip_documents'] = array();
	}

	$champs['spip_documents']['guide'] = array(
			'saisie' => 'case',
			'options' => array(
				'nom' => 'guide',
				'label' => 'Guide utilisateur',
				'explication' => 'Cochez cette case pour indiquer que le document est le guide utilisateur',
				'valeur_oui' => 'on',
				'restrictions' => array(
					'modifier' => array(
						'auteur' => 'admin',
					),
				),
				'sql' => 'varchar(3) DEFAULT \'\' NOT NULL',
				'rechercher_ponderation' => '2',
			),
			'verifier' => array(
			),
		);

	return $champs;
}

?>
