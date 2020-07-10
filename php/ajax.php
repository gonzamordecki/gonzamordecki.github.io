<?php

	if (!empty($_POST)) {
		$leType = isset($_POST['leType']) ? $_POST['leType'] : null;
		
		$Config_DBCon = 1; $Config_AppData = 1;
		include('./config.php');
		include('./functions.php');
		try {
			/*
				Lista de Casos:
					saveFormData
			*/

			$JSON = $leType();
		} catch (Exception $e) {
			$JSON['status'] = $e->getMessage();
		}

		echo json_encode($JSON);
	} else {
		echo "Qu&eacute; hac&eacute;s ac&aacute;?";	
	}
?>