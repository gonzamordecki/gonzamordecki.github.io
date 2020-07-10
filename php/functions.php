<?php

	function saveFormData() {
		global $link;
		global $leAppName;


		if (isset($_POST['leNombre']) AND isset($_POST['leApellido']) AND isset($_POST['leCedula']) AND isset($_POST['leEmail']) AND isset($_POST['leTelefono'])) {

			$leNombre = $_POST['leNombre'];
			$leApellido = $_POST['leApellido'];
			$leCedula = $_POST['leCedula'];
			$leEmail = $_POST['leEmail'];
			$leTelefono = $_POST['leTelefono'];

			$query = $link->query("SET time_zone='-3:00'");

			$query = $link->query("INSERT INTO Registros (Nombre, Apellido, Cedula, Email, Telefono, Fecha) VALUES ('{$leNombre}', '{$leApellido}', '{$leCedula}', '{$leEmail}', '{$leTelefono}', NOW())");
			if (!$query) throw new Exception($link->error);

			$link->close();

			$JSON['status'] = "ok";

			return $JSON;
		} else {
			throw new Exception('error');
		}
	}

	function mandaMail() {
		if (isset($_POST['leNombre']) AND isset($_POST['leApellido']) AND isset($_POST['leCedula']) AND isset($_POST['leEmail']) AND isset($_POST['leTelefono'])) {
			
			$leNombre = $_POST['leNombre'];
			$leApellido = $_POST['leApellido'];
			$leCedula = $_POST['leCedula'];
			$leEmail = $_POST['leEmail'];
			$leTelefono = $_POST['leTelefono'];
			$mailSend = 'soyeldos@gmail.com';

			require('phpmailer.php');

			$mail = new PHPMailer();
			
			$mail->CharSet = 'UTF-8';
			$mail->Host = "localhost";
			
			// Remitente
			$mail->From = $leEmail;
			// Nombre del remitente
			$mail->FromName = $leNombre . ' ' . $leApellido;
			// Tema o Asunto (Subject)
			$mail->Subject = "Nueva solicitud Online - OCA";
			// Email y Nombre de Destino		
			$mail->AddAddress($mailSend);

			$mail->WordWrap = 50;
			$mail->IsSMTP();
			$mail->IsHTML(true);
		
			ob_start();
?>
			<html>
				<head></head>

				<body style="">
					<table width="450" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-bottom: 30px; margin:30px auto 0 auto; font-family: tahoma; background: #DFD7D5; border-radius: 10px">
						<tbody>
							<tr>
								<td style="text-align:center;">
									<br />
									<span style="text-align:center; font-weight:bold; font-size: 22px; color: #000;">NUEVA SOLICITUD</span><br/>
									<span style="text-align:center; font-weight:normal; font-size: 18px; color: #D52B1E; ">Datos de contacto:</span>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center; padding: 10px 0;">
									<span style="text-align:center; font-weight:normal; font-size:20px; color: #555;">Nombre:</span><br>
									<span style="text-align:center; font-weight:normal; font-size:22px; color: #000; text-decoration: none;"><?php echo $leNombre . ' ' . $leApellido ?></span>
								</td>
							</tr>

							<tr>
								<td style="text-align:center; padding: 10px 0;">
									<span style="text-align:center; font-weight:normal; font-size:20px; color: #555;">Cédula:</span><br>
									<span style="text-align:center; font-weight:normal; font-size:22px; color: #000; text-decoration: none;"><?php echo $leCedula ?></span>
								</td>
							</tr>
							
							<tr>
								<td style="text-align:center; padding: 10px 0;">
									<span style="text-align:center; font-weight:normal; font-size:20px; color: #555;">Email:</span><br>
									<span style="text-align:center; font-weight:normal; font-size:22px; color: #000; text-decoration: none;"><?php echo $leEmail ?></span>
								</td>
							</tr>

							<tr>
								<td style="text-align:center; padding: 10px 0;">
									<span style="text-align:center; font-weight:normal; font-size:20px; color: #555;">Teléfono:</span><br>
									<span style="text-align:center; font-weight:normal; font-size:22px; color: #000; text-decoration: none;"><?php echo $leTelefono ?></span>
								</td>
							</tr>
						</tbody>
					</table>
				</body>
			</html>
<?php
			$body = ob_get_contents();
		
			$mail->Body = $body;

			if(!$mail->Send()) {
				$recipient = 'snunez@notable.com.uy';
				$subject = 'Error email - OCA - Site';
				$content = $body;
				mail($recipient, $subject, $content, 'From: '. $_POST['form_email'] .'\r\nReply-To: $email\r\nX-Mailer: DT_formmail');
			}
		} else {
			throw new Exception('error');
		}
	}
?>