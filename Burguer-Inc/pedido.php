<?php
  if(isset($_GET['bebidas'])){header("location: extras.php?bebidas");}
  if(isset($_GET['hamburguesa'])){header("location: hamburguesas.php");}
  if(isset($_GET['extras'])){header("location: extras.php?extras");}
  if(isset($_POST['carrito'])){header("location: carrito.php");}
?>

<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-secondary">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
      <img src="./images/name-w.png" alt="...">
      <form class="text-end" method="post"><button type="submit" class="btn btn-light btn-sm" name="carrito" >Ver Carrito</button></form>
      <div class="row justify-content-md-center p-4">
        <form class= "col-md-auto m-3" metohd="get">
          <button class="card  p-3 bg-dark" type="submit" name="bebidas" style="width: 18rem;">
    
              <img src="./images/bebida.png" class="card-img-top" alt="...">
              <div class="card-body m-auto">
                <p class="card-text  ">Bebidas</p>
              </div>
            
          </button>
        </form>
        <form class= "col-md-auto m-3" metohd="get">
          <button class="card  p-3 bg-dark" type="submit" name="hamburguesa" style="width: 18rem;">
    
              <img src="./images/icon.png" class="card-img-top" alt="...">
              <div class="card-body m-auto">
                <p class="card-text  ">Arma tu hamburguesa</p>
              </div>
            
          </button>
        </form>
        <form class= "col-md-auto m-3" metohd="get">
          <button class="card  p-3 bg-dark" type="submit" name="extras" style="width: 18rem;">
    
              <img src="./images/papa.png" class="card-img-top" alt="...">
              <div class="card-body m-auto">
                <p class="card-text  ">Extras</p>
              </div>
            
          </button>
        </form>

        

    </div>  

  </body>
</html>