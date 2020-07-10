<?php
	/*

	*	Para llamar a los distintos datos es necesario usar la siguiente línea en el process o cualquier otro archivo PHP que lo precise:
	*	$Config_Header = 0; $Config_DBCon = 0; $Config_DBCon2 = 0; $Config_AppData = 0; $Config_FBConnect = 0; include('./config.php');
	*
	*	Donde colocamos igualamos a 1 si queremos usar alguno de los datos.
	*
	*	Leyenda:
	*	$Config_Header: Habilita el uso de Cookies en IE y Safari, a su también habilita el log de errores de PHP/SQL, siempre colocar en el incio de cualquier archivo PHP
	*	$Config_DBCon: Permite la conexión a la DB general de aplicaciones de Facebook, ya están los datos seteados.
	*	$Config_AppData: Datos variables de la APP - Nombre de la misma, ID, Secret, GA, URL de la página en Facebook y el lenguaje, IMPORTANTE editar estos datos.
	*	$Config_FBConnect: Si se va a guardar en la DB general, o si se precisan los datos obtenidos de los permisos, esto habilita las varibales con los datos ya cargados (siempre y cuando se hayan obtenido los permisos).
	*/

	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
	/*
		*************************************************
		Datos de la APP - IMPORTANTE EDITAR!
		*************************************************
	*/
	if ($Config_AppData == 1) {
		$leAppName = 'OCA en todo el mundo'; // Nombre de la App
		$leGA = 'UA-XXXXXXXX-X'; // Código GA
		$leLang = 'es'; // Idioma del tab, para armar el Script de Facebook en español o inglés - Usar "es" o "en"
		$leDebug = false; // Cambiar a false antes de subir el tab
	}

	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
	/* ---------------------------------------------------------------------------------------------------------------------------------------------------------- */
	/*
		**********************************************
		Datos que no precisan ser cambiados
		**********************************************
	*/

	// DB Connection
	if ($Config_DBCon == 1) {
		$elServer = "localhost";
		$elUser = "ocamundo";
		$elPass = "B+3]oHGHKO@,";
		$elDebe = "ocamundo";

		$link = new mysqli($elServer, $elUser, $elPass, $elDebe) or die(mysqli_connect_error());
		$query = $link->query("SET time_zone='-3:00'");
	}

	if ($Config_AppData == 1) {
		// Creación de URL del tab
		// if (substr($leFanPageURL, -1) != '/') {
		// 	$leFanPageURL = $leFanPageURL ."/";
		// }
		// $lePageTabURL = $leFanPageURL .'app_'. $leAppID;

		// Creación de un Path correcto
		// if (substr($lePath, -1) != '/') {
		// 	$lePath = $lePath ."/";
		// }
		// if (strpos($lePath,'/public_html/work/apps') !== false) {
		// 	$lePath = str_replace('/public_html/work/apps', '', $lePath);
		// }

		// Creación de idiomas para JS de Fb
		switch ($leLang) {
			case "es":
				$leTabLang = "es_LA";
			break;
			case "en":
				$leTabLang = "en_US";
			break;
		}
	}

?>
