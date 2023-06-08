<?php
    include('./functions/connection.php');
    if(isset($_POST['volver'])){header("location: index.php");}
    session_start();
    session_unset();
    session_destroy();


?>
<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-secondary">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
      <img src="./images/name-w.png" alt="...">
      <div class="row justify-content-md-center p-4">

        <p>Tu numero de pedido es: <?php echo $_GET['venta'];?></p> 
        <form method="post"><button type="submit" class="btn btn-light btn-sm" name="volver" >Volver</button></form>
        

    </div>  

  </body>
</html>