<?php
    include('./functions/connection.php');
    session_start();

    if(isset($_POST['volver'])){header("location: pedido.php"); }
   
   
    if(isset($_GET['bebidas'])){  
            if(isset($_GET['tac'])){$tac=1;}else{$tac="0,1";};
            if(isset($_GET['veg'])){$veg=1;}else{$veg="0,1";};
            if(isset($_GET['sin'])){$sin="SIN ALCOHOL";}else{$sin="BEBIDA";};

            $sql= "SELECT  IngredienteID,  IngredienteNombre, IngredienteStock ,  IngredientePrecio ,  IngredienteImage from ingrediente i inner join IngredienteTipo it on it.IngredienteTipoID=i.IngredienteTipoId where  IngredienteBaja <> true and it.IngredienteTipoNombre like '%$sin%' and i.IngredienteTAC in ($tac) and i.IngredienteVeg in ($veg) and i.IngredienteVisible = 1 and i.IngredienteBaja = 0";
            $resu = mysqli_query($conn,$sql);
            $var="bebida";
    }else{  
        if(isset($_GET['tac'])){$tac=1;}else{$tac="0,1";};
        if(isset($_GET['veg'])){$veg=1;}else{$veg="0,1";};
        

        $sql= "SELECT  IngredienteID,  IngredienteNombre, IngredienteStock ,  IngredientePrecio ,  IngredienteImage from ingrediente i inner join IngredienteTipo it on it.IngredienteTipoID=i.IngredienteTipoId where  IngredienteBaja <> true and it.IngredienteTipoNombre like '%EXTRAS%' and i.IngredienteTAC in ($tac) and i.IngredienteVeg in ($veg) and i.IngredienteVisible = 1 and i.IngredienteBaja = 0 and i.IngredienteStock > 0";
        $resu = mysqli_query($conn,$sql);
        $var="extra";
    }
    $MAX=5;
    if(isset($_GET['añadir'])){
        $id=$_GET['id'];

        if(!isset($_SESSION[$var])){
            
            $_SESSION[$var][0]=$id;

        }else{
            $nroproductos = count($_SESSION[$var]);
            if($nroproductos<=$MAX){
                $veces=veces_en_array($_SESSION[$var],$id);
                $sql="SELECT IngredienteStock from ingrediente where IngredienteID = '$id'";
                $verif = mysqli_query($conn,$sql);
                $v= mysqli_fetch_array($verif);
                
                if($veces<$v[0]){
                    $_SESSION[$var][$nroproductos]=$id;
                }else{
                    echo '<script language="javascript">alert("No existe suficiente stock del producto seleccionado");</script>';
                }

            }else{
                echo '<script language="javascript">alert("Solo de pueden agregar'. $MAX . $var .'por pedido");</script>'; 
            }
        }
        redireccionar();
    }
    if(isset($_GET['restar'])){
        $id=$_GET['id'];
        if(isset($_SESSION[$var])){
            $control = 0;
            $new = array();
            foreach($_SESSION[$var] as $x => $elemento){
                if($elemento == $id && $control == 0){
                    $control=1;
                }else{array_push($new,$elemento);}
            } 
            $_SESSION[$var]=$new;           
        }
        redireccionar();
    }
    function veces_en_array($arr,$elemento){
        $veces=0;
        foreach($arr as &$valor){
            if($valor==$elemento){$veces++;}
        }
        return $veces;
    }
    function redireccionar(){
        if(isset($_GET['bebidas'])){header("location: extras.php?bebidas");}else{header("location: extras.php?extras");}
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
      <div class= " p-3 m-2"> 
        <form method="get">
            <div class="form-group row m-2">
                <div class="col-sm-2">
                    <div class="form-check">
                        <?php if(isset($_GET['tac'])){ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="tac" checked>

                        <?php }else{ ?>
                            <input class="form-check-input" type="checkbox" id="gridCheck1" name="tac">
                        <?php } ?>
                        <label class="form-check-label" for="gridCheck1">Sin Tacc </label>
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
                <?php if(isset($_GET['bebidas'])){ ?>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <?php if(isset($_GET['sin'])){ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="sin" checked>

                            <?php }else{ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="sin">
                            <?php } ?>
                            <label class="form-check-label" for="gridCheck1">Sin alcohol</label>
                            <input type="text"  id="bebidas" name="bebidas" style="display:none;">
                        </div>
                    </div>
                <?php } else{ ?>
                    <input type="text"  id="extras" name="extras" style="display:none;">
                <?php } ?>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-light btn-sm" >Aplicar filtro</button>
                </div>           
            </div>

            
        <from>
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Imagen</th>
                <th scope="col">Precio por unidad</th>
                <th scope="col">Cantidad</th>
                
                </tr>
            </thead>
            <tbody>
            <?php
            while($f = mysqli_fetch_array($resu))
            {
                ?>
                <tr>

                    <td><p><?php echo $f['IngredienteNombre']; ?> </p></td>

                    <td><img src= "<?php echo $f['IngredienteImage']; ?>" width="100"></td>

                    <td><p>$ <?php echo $f['IngredientePrecio']; ?> </p></td>

                    <td><p> <?php if(!Empty($_SESSION[$var]) && isset($_SESSION[$var])){ echo veces_en_array($_SESSION[$var],$f['IngredienteID']);}else {
                        echo 0;
                    } ?></p></td>           

                    <form method="get">

                        <?php if(isset($_GET['bebidas'])){ ?>
                            <input type="text"  id="bebidas" name="bebidas" style="display:none;">
                        <?php } else{ ?>
                            <input type="text"  id="extras" name="extras" style="display:none;">
                        <?php } ?>
                        <input type="text"  id="id" name="id" value="<?php echo $f['IngredienteID'];?>" style="display:none;">
                        <td><button type="submit" class="btn btn-light btn-sm" name="añadir">Añadir</button></td>
                    </form>
                    <form method="get">
                        <?php if(isset($_GET['bebidas'])){ ?>
                            <input type="text"  id="bebidas" name="bebidas" style="display:none;">
                        <?php } else{ ?>
                            <input type="text"  id="extras" name="extras" style="display:none;">
                        <?php } ?>
                        <input type="text"  id="id" name="id" value="<?php echo $f['IngredienteID'];?>" style="display:none;">
                        <td><button type="submit" class="btn btn-light btn-sm" name="restar" >Quitar</button></td>
                    </form>
                </tr>
                <?php
            }
            ?>
            </tbody>
            
        </table>
        </div>
        
        <form method="post"><button type="submit" class="btn btn-light btn-sm" name="volver" >Volver</button></form>
    </div>  

  </body>
  
</html>