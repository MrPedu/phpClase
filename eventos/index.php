<?php 
session_start();
?>
<html>
<head>
<?php
if(isset($_GET['logout'])) {session_destroy();
header("location: index.php");
}
?>
</head>
<body>

<?php


$mysqli = new mysqli('localhost', 'root', '', 'profe');

if ($mysqli->connect_errno) {
    echo "Lo sentimos, este sitio web está experimentando problemas.";
    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}

if(!empty($_POST['apuntar'])){

// Por POST recibimos ID de Evento y por SESSION el de usuario
$sql = "INSERT INTO apuntados VALUES ('','".$_POST['id']."','".$_SESSION['id']."')";
echo $_SESSION['id'];
$resultado = $mysqli->query($sql);
}

if(!empty($_POST['boton'])) {

if($_POST['boton']=="Dar de alta"){

	if($_POST["pass"]==$_POST['pass_2']){
		$sql = "SELECT id from usuarios where user='".$_POST['usuario']."' 			OR correo='".$_POST['correo']."'";
		$resultado = $mysqli->query($sql);
		if (!$fila = $resultado->fetch_row()) {
			$sql = "INSERT INTO usuarios VALUES ('','".$_POST['usuario']."','".$_POST['pass']."','".$_POST['nombre']."','".$_POST['correo']."',0)";
			if (!$resultado = $mysqli->query($sql))
			{ echo "error".$sql;}
		}
		else echo "Ya existe un usuario con este correo o con este nombre de usuario".$sql;
}
}

else { //hacer login
if (!empty($_POST['usuario']) && !empty($_POST['pass'])){
$sql = "SELECT * from usuarios where user='".$_POST['usuario']."'"; 
		$resultado = $mysqli->query($sql);
		if (!$fila = $resultado->fetch_array()) {
			echo "No existe este usuario<br/>
<a href='index.php?crear=1'>Quiero crear una cuenta de usuario nueva</a>";
		}
		else {
		if($_POST['pass']==$fila['pass']){
			$_SESSION['login']=true;
			$_SESSION['nombre']=$fila['nombre'];
			$_SESSION['correo']=$fila['correo'];
			$_SESSION['id']=$fila['id'];
			if($fila['rol']==1) $_SESSION['soyAdmin']=true;
			echo "Hola ".$_SESSION['nombre']."!";
			}
		
		}

}

}

}//final if boton


if(!empty($_GET['crear'])) {
?>

<form name="formulario_alta" action="index.php" method="post">
Nombre de usuario <input type="text" name="usuario" required/><br/>
Contraseña <input type="password" name="pass"  required/><br/>
Repite contraseña <input type="password" name="pass_2"  required/><br/>
Nombre <input type="text" name="nombre"  required/><br/>
Correo-e <input type="email" name="correo"  required/><br/>
<input type="submit" name="boton" value="Dar de alta"/>
</form>

<?php } 

else
{
if(isset($_SESSION['soyAdmin'])){
//contenido de la web para el usuario ADMIN
echo '<a href="control.php">Ir al panel de control</a><br/>';
}

if(isset($_SESSION['login'])){
//contenido de la web para el usuario normal

echo "mostraremos los eventos.<br/>";

//sacar a que cursos esta apuntado
$sql = "SELECT id_evento from apuntarse where id_usuario='".$_SESSION['id']."'";
$resultado = $mysqli->query($sql);

int i=0;

while ($row = $resultado->fetch_row()) {
$cursos[i] = $row[0];
i++;
}

// esta incompleto! EL LUNES TERMINAMOS

$sql = "SELECT * from evento";
$resultado = $mysqli->query($sql);
echo "<br/><table width='500'>";
while ($fila = $resultado->fetch_array()) {
echo "<tr><td>".$fila['nombre']."</td><td rowspan='4'>".$fila['plazas']." plazas<br/><br/><form action='index.php' method='post'> <input type='submit' value='Apuntate!' name='apuntar'/><input type='hidden' name='id' value='".$fila['id']."'/></form></td></tr>".
	"<tr><td>".$fila['lugar']." - ".$fila['fecha']."</td></tr>".
	"<tr><td>".$fila['descripcion']."</td></tr><tr bgcolor='red'><td>&nbsp;</td></tr>";

}
echo "</table>";

}
else {
?>
<form name="formulario_login" action="index.php" method="post">
Nombre de usuario <input type="text" name="usuario" /><br/>
Contraseña <input type="password" name="pass" /><br/>
<input type="submit" name="boton" value="Iniciar sesion"/>
</form>
<a href="index.php?crear=1">Quiero crear una cuenta de usuario nueva</a>

<?php }
} ?>
</body>
</html>
