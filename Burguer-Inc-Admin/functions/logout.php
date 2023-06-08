<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(),'',-4200,'/');
        }
        session_unset();   // Destruimos las variables de sesión
        session_destroy();
    }
    header("location:./login.php");
?>