<?php


// sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/* Liste des types d'indicateurs qui ne chargent pas de données CSV */
define('_TYPES_INDICATEURS_SANS_DATA', array(5,6));//5 et 6 sont les indicateurs de pilotage, qui nécessitent des valeurs simples, pas des tableaux csv
define('_TYPES_INDICATEURS_EXPORTABLES', array(1,2,3,4,5));
/* Couleurs par défaut pour les représentations graphiques, issues de la palette graphique */
define('_COULEURS_DEFAUT', array(
	1=>'#E24C6A',
	2=>'#3F9FD2',
	3=>'#F4C84E',
	4=>'#A0B948',
	5=>'#905c92',
	6=>'#43AAAD',
	7=>'#2B3C45',
	8=>'#6B777E',
));
define('_COULEURS_INF_DEFAUT', array(
	1=>'#ec7d9d',
	2=>'#4EADE0',
	3=>'#fed25f',
	4=>'#b0cb4f',
	5=>'#A269A4',
	6=>'#48babe',
	7=>'#5b6870',
	8=>'#bbc0c5',
));
define('_PALETTE',array(
	'#A1D1D2','#82C3C4','#64B6B8','#43AAAD','#3D9496','#377E80','#2E6466','#244748',
	'#A4CDB5','#86BD9E','#62A983','#40996D','#39845E','#326D4F','#28523C','#1A2E23',
	'#D4DDA7','#C4D28A','#B3C56A','#A0B948','#85993E','#697833','#4E5828','#363D1E',
	'#FFE3A8','#FCDA8B','#F9D06C','#F4C84E','#DEB444','#BA9534','#8E6F20','#6F5412',
	'#FFBEA6','#FDA989','#F9956F','#F4855B','#DC6F47','#C45A34','#AC4521','#94300D',
	'#FBBBC0','#F598A3','#ED7486','#E24C6A','#C43C58','#A72D46','#8A1D35','#6F0D25',
	'#DAC1DA','#C8A4C8','#B586B6','#A269A4','#86538A','#6A3E71','#502A59','#371742',
	'#B6C3DF','#8FA5CE','#7190C2','#4876B3','#40669A','#355078','#2B3E5B','#212D40',
	'#BCD8ED','#98C4E4','#71B1DB','#3F9FD2','#3785AF','#2F6C8D','#27546D','#1E3D4E',
	'#CCD0D4','#ABB2B7','#8A949A','#6B777E','#5A686F','#4A5961','#3A4A53','#2B3C45'
));

?>
