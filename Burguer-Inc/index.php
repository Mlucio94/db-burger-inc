<?php
  if(isset($_GET['ir'])){header("location: pedido.php");}
  session_start();
  session_unset();
  session_destroy();
?>
<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-dark">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
        
        <img src="./images/name-w.png" class="img-fluid w-25 rounded mt-4" alt="Logo de Burguer Inc">
        <img src="./images/icon.png" class="img-fluid w-25 " alt="Logo de Burguer Inc">
        
        
        <h1>¡Gustos que dan Sustos!</h1>
        <div class="container-form">
            <form  method="get">
              <button name="ir" type="submit" class="btn btn-warning m-3">NUEVO PEDIDO</button>
            </form>
            <form action="./functions/buscarpedido.php" method="post">
              <?php
                        if(isset($_GET['fail'])){
                            ?>
                                <div class="alert alert-danger d-flex align-items-center mt-3 bg-danger " role="alert">
                                <div>
                                    El numero de pedido es incorrecto
                                </div>
                                </div>
                             <?php    
                        }
                        unset($_GET['fail']); 
                ?>
              <div class="input-group mb-3">
                  <input name="nropedido" type="number" class="form-control" placeholder="Numero de pedido" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <button class="input-group-text btn-success" id="basic-addon2">VER MI PEDIDO</button>
              </div>
            </form>
        </div>
    </div>
  
  </body>
</html>