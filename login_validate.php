<?php
  //iniciar sesiones
  session_start ();
  //conexion a base de server
  $conec = mysqli_connect('localhost', 'root','','test');
  /* comprobar la conexión */
  if (mysqli_connect_errno()) {
      printf("Falló la conexión: %s\n", mysqli_connect_error());
      exit();
  }
  //pedir el usuario
  $user = strip_tags ( $_POST ['user']);
  //pedir y encriptar el password
  $password = sha1(strip_tags($_POST['password']));
  //buscar en base de datos si existe el usuario
  $query = @mysqli_query ($conec, "SELECT * FROM `users` WHERE `user` ='" . mysqli_real_escape_string($conec,$user) . "' AND `password` = '" . mysqli_real_escape_string($conec,$password) . "'");
  //Si el objeto puede ser creado el usuario existe
  if($existe = @mysqli_fetch_object ( $query)) {
    //Determinar la fecha
    $hoy = date ("Y-m-d H:i:s");
    //Registrar en la tabla la fecha de ingreso
    //$query = mysqli_query($conec, "UPDATE `users` SET `ultimo_ingreso` = '$hoy' WHERE `user` = '$users'");
    //Primera variable de sesión (servira para manejar el loguin entre screens que requieran logueo)
    $_SESSION ['logged'] = 'yes';
    //extraer todo los datos [columnas] de ese usuario en particular
    $query = mysqli_query($conec, "SELECT * FROM `users`");
    $row = mysqli_fetch_array ($query);

    $id = $row [0];
    $fecha = $row [1];
    $user = $row[2];
    $mail = $row[4];

    //mantener los datos del usuario
    $_SESSION ['user'] = $user;
    $_SESSION ['user_id'] = $id;
    $_SESSION ['mail'] = $mail;

    mysqli_close($conec);
    echo '<meta http-equiv="Refresh" content="3;url=http://mokuzaru.com/">';
  } else {
    $_SESSION ['logged'] ='no';
    echo "false";
    mysqli_close($conec);
  }
?>
