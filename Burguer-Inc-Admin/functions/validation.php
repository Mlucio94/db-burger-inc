<?php

    $user = $_POST['usuario'];
    $pass = $_POST['contraseña'];
    session_start();
    $_SESSION['usuario']=$user;

    include('connection.php');

    $consult="SELECT*FROM usuarios where usuario='$user'  and contrasena=md5('$pass')";
    $result=mysqli_query($conn,$consult);

    $filas = mysqli_num_rows($result);

    if($filas){
        header("location:../index.php");

    }else{
      
         header("location:../login.php?fail=1");
    }

    mysqli_free_result($result);
    mysqli_close($conn);
?>