
<div class="container-xl bg-light mt-2 rounded">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="?entorno=Ajustes&aju=Estados">Adm. Estados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?entorno=Ajustes&aju=Tipos">Adm. Tipo Ingrediente</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="?entorno=Ajustes&aju=Ingredientes">Adm. Ingredientes</a>
        </li>
    </ul>



<?php
    if(empty($_GET['aju'])){
        include("component/estados.php");
      }else{
        $Ajustes=$_GET['aju'];
      
        switch($Ajustes){
          case "Estados":
            include("component/estados.php");
            break;
          case "Tipos":
            include("component/tipoingrediente.php");
            break;
          case "Ingredientes":
            include("component/admingredientes.php");
            break;
          case "Ingredientesedit":
            include("component/modificaring.php");
            break;
        }
    }
?>
</div>