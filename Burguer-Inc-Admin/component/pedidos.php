<?php
    include('./functions/connection.php');

    $sql= "select e.EstadoTipoNombre  from parmstepestados p inner join estadopedido e on p.EstadoPedidoId = e.EstadoPedidoID order by id";
    $resu = mysqli_query($conn,$sql);
    $f1= mysqli_fetch_array($resu);
    $f2 = mysqli_fetch_array($resu);
    $f3 = mysqli_fetch_array($resu);
    $f4 = mysqli_fetch_array($resu);
?>    



<div class="container-xl bg-light mt-2 rounded">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="?entorno=Pedidos&aju=ingresos"><?php echo $f1[0]; ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?entorno=Pedidos&aju=EnCurso"><?php echo $f2[0]; ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?entorno=Pedidos&aju=Listos"><?php echo $f3[0]; ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?entorno=Pedidos&aju=Entregados"><?php echo $f4[0]; ?></a>
        </li>
        
</ul>

<?php
    if(empty($_GET['aju'])){
        include("component/ingresos.php");
      }else{
        $Ajustes=$_GET['aju'];
      
        switch($Ajustes){
          case "ingresos":
            include("component/ingresos.php");
            break;
          case "EnCurso":
            include("component/encurso.php");
            break;
          case "Listos":
            include("component/listos.php");
            break;
        case "Entregados":
            include("component/entregados.php");
            break;
         
        }
    }
?>
</div>