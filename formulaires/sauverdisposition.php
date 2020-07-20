<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_sauverdisposition_charger_dist(){
	$valeurs = array();
	$valeurs['ordre_tableau']='';
	return $valeurs;
}
function formulaires_sauverdisposition_verifier_dist(){
	$erreurs=array();
	/*NB : ordre_tableau doit normalement contenir une chaine produite par serialize de sortable de la forme :
	* ordretab[]=6&ordretab[]=10&ordretab[]=11&ordretab[]=14&ordretab[]=18&ordretab[]=20&ordretab[]=22&ordretab[]=25&ordretab[]=27
	* parse_str doit donc initaliser la variable $ordretab en tableau
	*/
	if(_request('ordre_tableau')){
		parse_str( _request('ordre_tableau') );
		if(!isset($ordretab)){
			$erreurs['ordre_tableau'] = "1 - "._T('artaclim:erreur_disposition_mal_formee');
		}else{
			if(!is_array($ordretab)){
				$erreurs['ordre_tableau'] = "2 - ". _T('artaclim:erreur_disposition_mal_formee');
			}
		}
	}
	if(_request('ordre_tableau_pilotage')){
		parse_str( _request('ordre_tableau_pilotage') );
		if(!isset($ordretabpilotage)){
			$erreurs['ordre_tableau'] = "1 - "._T('artaclim:erreur_disposition_mal_formee');
		}else{
			if(!is_array($ordretabpilotage)){
				$erreurs['ordre_tableau'] = "2 - ". _T('artaclim:erreur_disposition_mal_formee');
			}
		}
	}

	return $erreurs;
}
function formulaires_sauverdisposition_traiter_dist(){
	if(_request('ordre_tableau')){	
		parse_str(_request('ordre_tableau'));
		if(isset($ordretab)){
			foreach($ordretab as $k => $v){
				spip_log("Ordre $k indicateur $v");
				sql_updateq('spip_auteurs_liens', array('ordre_tableau' => $k),
				array(
					'id_objet = '.$v,
					'objet = "indicateur"',
					'id_auteur = '.intval($GLOBALS["visiteur_session"]["id_auteur"])
				));
			}
		}
	}
	if(_request('ordre_tableau_pilotage')){	
		parse_str(_request('ordre_tableau_pilotage'));
		if(isset($ordretabpilotage)){
			foreach($ordretabpilotage as $k => $v){
				spip_log("Ordre $k indicateur $v");
				sql_updateq('spip_auteurs_liens', array('ordre_tableau' => $k),
				array(
					'id_objet = '.$v,
					'objet = "indicateur"',
					'id_auteur = '.intval($GLOBALS["visiteur_session"]["id_auteur"])
				));
			}
		}
	}
	return array(

	);
}

?>
