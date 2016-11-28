<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Alta De Usuarios</title>
			<?php
				if(!session_id());

				$link = mysql_connect('localhost', 'MrPedu', 'asdfg,1234')or die('Intentando Conectar por favor recarga: ' . mysql_error());
				mysql_select_db('eventos') or die('No se pudo seleccionar la base de datos');
			 ?>
		</head>
		<body>
			<?php
				if(!empty($_POST['enviar'])){
					if($_POST['enviar'] == "Dar de alta"){
						if($_POST['pass'] == $_POST['pass2']){
							$query = "SELECT id FROM usuarios WHERE usuario ='".$_POST['user']."' OR correo ='".$_POST['email']."';";
							$resul = mysql_query($query);
							if(!$row = mysql_fetch_row($resul)){
								$query = "INSERT INTO usuarios VALUES('','".$_POST['nombre']."','".$_POST['user']."','".$_POST['pass']."','".$_POST['email']."')";
								mysql_query($query);
								echo "¡Bienvenido ". $_POST['nombre']. "!<br><a href='altaUsuario.php'><-- VOLVER AL LOGIN</a>";
							}
						}
					}
				}
				else{

					if(!empty($_GET['crear'])){
					?>
						<form name='formulario' action='altaUsuario.php' method='post'>
							<fieldset><legend>LOGIN</legend>
								<legend>Usuario</legend>
									<input type="text" name="user" required>
								<legend>Nombre</legend>
									<input type="text" name="nombre">
								<legend>Correo</legend>
									<input type="email" name="email" required>
								<legend>Contraseña</legend>
									<input type="password" name="pass">
								<legend>Repita su contraseña</legend>
									<input type="password" name="pass2" required></br><br>
								<input type="submit" value="Dar de alta" name="enviar">
							</fieldset>

						</form>
						<a href="altaUsuario.php">Acceder Con Mi Cuenta</a>
			<?php
					}
					else{
						if(!empty($_POST['usuario']) && !empty($_POST['contrasenia'])){

						$selector = mysql_query("SELECT * FROM usuarios WHERE usuario = '".$usuario."';")or die('Consulta fallida: ' . mysql_error());
						$lector= mysql_fetch_array($selector);
						$vale = false;

						if($_POST['usuario'] == $lector['usuario'] && $_POST['contrasenia'] == $lector['contrasenia']){
								$vale = true;

						}
						//GUARDA LA SESION DEL USUARIO
						if($vale == true){
							 $_SESSION['login'] = $_POST['usuario'];
							 if( $_SESSION['login'] == 'admin'){
								 header('Location = adminEvento.php;');
							 }

						}
					}
			?>
						<form name='formulario' action='altaUsuario.php' method='post'>
							<fieldset><legend>LOGIN</legend>
								<legend>--USUARIO---</legend>
									<input type="text" name="usuario">
								<legend>--CONTRASEÑA---</legend>
									<input type="password" name="contrasenia"></br></br>
								<input type="submit" value="Conectar" name="enviar">
							</fieldset>
						</form>
						<a href="altaUsuario.php?crear=1">Darme de Alta Como Usuario</a>
			<?php
					}
				}
			?>
		</body>
	</html>
