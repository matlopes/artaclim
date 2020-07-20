#Plugin artaclim

Ce plugin pour le [CMS SPIP](https://www.spip.net) contient l'ensemble des fonctionnalités du projet Assistant.

Il doit être installé dans le répertoire plugins de SPIP en version >= 3.2.7.


##Modification des fichiers css du projet

Les différentes variables issus du travail de graphisme sont stockées et modifiables dans le fichier variables.scss

Il faut ensuite générer les fichiers artaclim.css et bootstrap-artaclim.css gràce aux commandes suivantes:

'''bash
sass scss/bootstrap-artaclim.scss css/bootstrap-artaclim.css
sass scss/artaclim.scss css/artaclim.css
'''

##Licences

Ce plugin est placé sous licence [GPL 3](https://www.gnu.org/licenses/gpl-3.0.html)

Il utilise :
- [Jquery](https://jquery.com/) et [Jquery UI](https://jqueryui.com/), distribués avec SPIP, sous licence MIT, @Copyright JS Foundation.
- [Chart.js](https://www.chartjs.org/), sous licence MIT, avec les plugins :
 - [chartjs-plugin-trendline](https://github.com/Makanz/chartjs-plugin-trendline) (licence MIT)
 - [chartjs-plugin-annotation.js](https://github.com/chartjs/chartjs-plugin-annotation) (licence MIT)
 - [chartjs-gauge](https://github.com/haiiaaa/chartjs-gauge/) (licence MIT)
 - [chartjs-plugin-datalabels](https://github.com/chartjs/chartjs-plugin-datalabels) (licence MIT)
- [chroma.js](https://gka.github.io/chroma.js/) (licence BSD-3-Clause)
- [Huebee](https://huebee.buzz/) (GPL 3)
- [Moment.js](https://momentjs.com/) (licence MIT)
- [Leaflet.js](https://leafletjs.com/) (©Copyright Vladimir Agafonkin), avec les plugins :
 - [leaflet-providers](https://github.com/leaflet-extras/leaflet-providers) (©Copyright (c) 2013 Leaflet Providers contributors )
 - [leaflet-ajax](https://github.com/calvinmetcalf/leaflet-ajax) (Copyright (c) 2012-2015 Calvin Metcalf)
 - [leaflet-image](https://github.com/mapbox/leaflet-image) (BSD 2-Clause)
- [Bootstrap](https://getbootstrap.com/) (Licence MIT)
