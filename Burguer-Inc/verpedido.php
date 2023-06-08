<?php
    if(isset($_POST['volver'])){header("location: index.php"); }

    $nro = $_GET['nropedido'];

    include('./functions/connection.php');

    $consult="SELECT e.estadotiponombre as estado FROM pedido p inner join estadopedido e on p.estadopedidoid = e.estadopedidoid where p.pedidoid = $nro";
    $result=mysqli_query($conn,$consult);
    if ($row = mysqli_fetch_row($result)) { $estado = trim($row[0]); }
?>
<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-secondary">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
      <img src="./images/name-w.png" alt="...">
      <div class="row justify-content-md-center p-4">

        <p>El estado de tu pedido es <?php echo $estado;?></p> 
        <form method="post"><button type="submit" class="btn btn-light btn-sm" name="volver" >Volver</button></form>
        

    </div>  

  </body>
</html>