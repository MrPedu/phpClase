<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
      <?php
        session_start();
        $link = mysql_connect('localhost', 'MrPedu', 'asdfg,1234')or die('Intentando Conectar por favor recarga: ' . mysql_error());
				mysql_select_db('eventos') or die('No se pudo seleccionar la base de datos');
        echo "¡Bienvenido ". $_POST['nombre']. "!<br><a href='altaUsuario.php'><-- VOLVER AL LOGIN</a>";
       ?>
    <title>Panel de Administrador</title>
  </head>
  <body>
    <?php

     ?>
     <form name="formulario" action="panelAdmin.php" method="post">
           <fieldset>
             <legend>CREACION DE EVENTOS</legend>
               <legend>Nombre</legend>
                 <input type="text" name="nombreEven">
               <legend>Lugar</legend>
                 <input type="text" name="lugar">
               <legend>Fecha</legend>
                 <input type="text" name="fecha">
               <legend>Numero de Plazas</legend>
                 <input type="number" name="numPlazas">
            <input type="submit" value="Crear Evento" name="Enviar">
           </fieldset>
  </body>
</html>
