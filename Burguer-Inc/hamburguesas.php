<?php
    include('./functions/connection.php');
    session_start();
    $MAX = 5;
    if(isset($_POST['volver'])){header("location: pedido.php"); }

    if(isset($_GET['añadir'])){
        
        if(!isset($_SESSION['item'])){

            $hamburguesa=array();
            if(!empty($_GET['Pan'])){array_push($hamburguesa,$_GET['Pan']);}
            if(!empty($_GET['ing1'])){array_push($hamburguesa,$_GET['ing1']);}
            if(!empty($_GET['ing2'])){array_push($hamburguesa,$_GET['ing2']);}
            if(!empty($_GET['ing3'])){array_push($hamburguesa,$_GET['ing3']);}
            if(!empty($_GET['ing4'])){array_push($hamburguesa,$_GET['ing4']);}
            if(count($hamburguesa)<2){echo '<script language="javascript">alert("No elegiste suficientes ingredientes para tu hamburguesa");</script>';}else{$_SESSION['item'][0]=$hamburguesa;}

        }else{
            $nroproductos = count($_SESSION['item']);
            if($nroproductos<$MAX){
                $hamburguesa=array();
                if(!empty($_GET['Pan'])){array_push($hamburguesa,$_GET['Pan']);}
                if(!empty($_GET['ing1'])){array_push($hamburguesa,$_GET['ing1']);}
                if(!empty($_GET['ing2'])){array_push($hamburguesa,$_GET['ing2']);}
                if(!empty($_GET['ing3'])){array_push($hamburguesa,$_GET['ing3']);}
                if(!empty($_GET['ing4'])){array_push($hamburguesa,$_GET['ing4']);}
                if(count($hamburguesa)<2){echo '<script language="javascript">alert("No elegiste suficientes ingredientes para tu hamburguesa");</script>';}else{$_SESSION['item'][$nroproductos]=$hamburguesa;}
               
                 

            }else{
                echo '<script language="javascript">alert("Solo de pueden agregar'. $MAX .'hamburguesas por pedido");</script>'; 
            }
        }
        header("location: hamburguesas.php");
       
        
    }

 
    if(isset($_GET['tac'])){$tac=1;}else{$tac="0,1";};
    if(isset($_GET['veg'])){$veg=1;}else{$veg="0,1";};


    $panes = array();
    $sql="SELECT IngredienteID,  IngredienteNombre, IngredienteStock ,  IngredientePrecio ,  IngredienteImage from ingrediente i inner join IngredienteTipo it on it.IngredienteTipoID=i.IngredienteTipoId where  IngredienteBaja <> true and it.IngredienteTipoNombre = 'PAN' and i.IngredienteTAC in ($tac) and i.IngredienteVeg in ($veg) and i.IngredienteVisible = 1 and IngredienteStock > 0";
    $resu1 = mysqli_query($conn,$sql);
    while($row = $resu1 -> fetch_assoc()){
        array_push($panes,$row);
    }
    $opciones = array();
    $sql="SELECT IngredienteID, IngredienteNombre, IngredienteStock , IngredientePrecio , IngredienteImage from ingrediente i inner join IngredienteTipo it on it.IngredienteTipoID = i.IngredienteTipoId where IngredienteBaja <> true and(it.IngredienteTipoNombre <> 'PAN' and it.IngredienteTipoNombre not like 'BEBIDA%' and it.IngredienteTipoNombre not like 'EXTR%') and i.IngredienteTAC in ($tac) and i.IngredienteVeg in ($veg) and i.IngredienteVisible = 1 and IngredienteStock > 0";
    $resu = mysqli_query($conn,$sql);
    while($row = $resu -> fetch_assoc()){
        array_push($opciones,$row);
    }


?>
<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-secondary">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
      <img src="./images/name-w.png" alt="...">
      <div class="row justify-content-md-center p-4">
        <form  method="get">
            <div class="form-group row m-2">
                <div class="col-sm-2">
                    <div class="form-check">
                        <?php if(isset($_GET['tac'])){ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="tac" checked>

                        <?php }else{ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="tac">
                        <?php } ?>
                        <label class="form-check-label" for="gridCheck1">Sin Tac </label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-check">
                        <?php if(isset($_GET['veg'])){ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="veg" checked>

                        <?php }else{ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="veg">
                        <?php } ?>
                        <label class="form-check-label" for="gridCheck1">Vegetariano</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-light btn-sm" >Aplicar filtro</button>
                </div> 
                <div class="col-sm-6">
                    <p>Hamburguesas en tu pedido : <?php if(isset($_SESSION['item'])){ echo count($_SESSION['item']);}else{ echo 0;} ?></p>
                </div> 
                          
            </div>   
        <from>
        <form  calss="container" action="post">
            <div calss=" row justify-content-md-center">
                <div calss="col-md-auto">
                    <div class="form-group mt-2 mb-2">
                        <label for="Ingrediente 1">Paso 1: Elije tu tipo de Pan preferido</label>
                        <select id="Pan" name="Pan" class="form-control form-control-sm">
                        <?php
                            foreach($panes as $pan){
                        ?>
                                <option value="<?php echo $pan['IngredienteID']; ?>"><?php echo $pan['IngredienteNombre']; ?></option>
                        <?php  
                            }
                        ?>
                        </select>
                    </div>
                    <div>Paso 2: Elija los ingredientes</div>
                    <div class="form-group m-2">
                        <select id="ing1" name="ing1" class="form-control form-control-sm">
                        <option value="<?php echo null; ?>"></option>
                        <?php foreach($opciones as $option){?>
                                <option value="<?php echo $option['IngredienteID']; ?>"><p style="color:black;">
                                <?php echo $option['IngredienteNombre']; ?>
                                </p></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <select id="ing2" name="ing2" class="form-control form-control-sm">
                        <option value="<?php echo null; ?>"></option>
                        <?php foreach($opciones as $option){?>
                                <option value="<?php echo $option['IngredienteID']; ?>"><p style="color:black;">
                                <?php echo $option['IngredienteNombre']; ?>
                                </p></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <select id="ing3" name="ing3" class="form-control form-control-sm">
                        <option value="<?php echo null; ?>"></option>
                        <?php foreach($opciones as $option){?>
                                <option value="<?php echo $option['IngredienteID']; ?>"><p style="color:black;">
                                <?php echo $option['IngredienteNombre']; ?>
                                </p></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <select id="ing4" name="ing4" class="form-control form-control-sm">
                        <option value="<?php echo null; ?>"></option>
                        <?php foreach($opciones as $option){?>
                                <option value="<?php echo $option['IngredienteID']; ?>"><p style="color:black;">
                                <?php echo $option['IngredienteNombre']; ?>
                                </p></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div>Paso 3: Agregar a tu pedido</div>
                    <div class="m-2"><button type="submit" class="btn btn-light btn-sm" name="añadir">Añadir al pedido</button></div>
                </div>
            </div>
        </form>
        <form method="post"><button type="submit" class="btn btn-light btn-sm" name="volver" >Volver</button></form>
        

    </div>  

  </body>
</html>