<!doctype html>
<html lang="en">
<?php
  session_start();
  date_default_timezone_set('America/Argentina/Buenos_Aires');
  include("component/head.php");
?> 
 <body class="bg-dark">
  <?php
    
    if(isset($_SESSION['usuario'])){
      
      include("component/navbar.php");
  
      if(empty($_GET['entorno'])){
        include("component/pedidos.php");
      }else{
        $Entorno=$_GET['entorno'];
      
        switch($Entorno){
          case "Pedidos":
            include("component/pedidos.php");
            break;
          case "Stock":
            include("component/stockprecios.php");
            break;
          case "Precios":
            echo "Precios";
            break;
          case "Ajustes":
            include("component/ajustes.php");
              break;
          case "Logout":
            include("./functions/logout.php");
            break;
        }
      }
    }else{
      header("location:./login.php");
    }
    
  ?>

  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
 </body>

</html>