<?php
    
    session_start();

    if(isset($_POST['confirmar'])){header("location: ./functions/terminar.php");}
    if(isset($_POST['editarbebida'])){header("location: extras.php?bebidas");}
    if(isset($_POST['editarextra'])){header("location: extras.php?extras");}
    if(isset($_GET['eliminar'])){
        $id=$_GET['eliminar'];
        if(isset($_SESSION['item'])){
            $control = 0;
            $new = array();
            foreach($_SESSION['item'] as $x => $hamburguesa){
                if($x == $id && $control == 0){
                    $control=1;
                }else{array_push($new,$hamburguesa);}
            } 
            $_SESSION['item']=$new;           
        }
        header("location: carrito.php");
    }


    function buscar_producto($nro){
        include('./functions/connection.php');
        $sql="SELECT IngredienteNombre, IngredientePrecio from Ingrediente where IngredienteID = $nro ";
        $resu = mysqli_query($conn,$sql);
        return $resu;
    }

?>
<!doctype html>
<html lang="en">
  <!-- Head -->
  <?php include("component/head.php");?>
  
  <body class="bg-secondary">
    <div class="container-sm text-center bg-meal main-card mt-4 p-4">
      <img src="./images/name-w.png" alt="...">
      <form class="text-end" method="POST"><button type="submit" class="btn btn-light btn-sm" name="confirmar" >Terminar pedido</button></form>
      <p> Monto Total = $ <? echo $_SESSION['monto']; ?></p>
    
    <?php if(isset($_SESSION['item'])){?>
        <p>Hamburguesas</p>
        <?php
        foreach($_SESSION['item'] as $x => $hamburguesa){ $precio=0;?>
         <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio por unidad</th>
                <th scope="col"></th>
                <th scope="col"><form class="text-end" method="GET"><button type="submit" class="btn btn-light btn-sm" name="eliminar" value="<?php echo $x; ?>" >Quitar</button></form></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($hamburguesa as $id){ $ingredientes =  mysqli_fetch_array(buscar_producto($id));?>
                <tr>
                <td><p><?php echo $ingredientes['IngredienteNombre']; ?> </p></td>
                <td><p>$<?php echo $ingredientes['IngredientePrecio']; ?> </p></td>
                </tr>
            <?php $precio= $precio + $ingredientes['IngredientePrecio'];           
            }?>
                <td></td>
                <td></td>
                <td><p>$ <?php echo $precio; $_SESSION['monto']=$_SESSION['monto']+$precio;?> </p></td>  
            </tbody>
            </table>
            <?php
        }
    } ?>
    <?php if(isset($_SESSION['extra'])){$precio=0;?>
        <p>Extras</p>
         <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio por unidad</th>
                <th scope="col"></th>
                <th scope="col"><form class="text-end" method="post"><button type="submit" class="btn btn-light btn-sm" name="editarextra" >Editar</button></form></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($_SESSION['extra'] as $id){ $ingredientes =  mysqli_fetch_array(buscar_producto($id));?>
                <tr>
                <td><p><?php echo $ingredientes['IngredienteNombre']; ?> </p></td>
                <td><p>$<?php echo $ingredientes['IngredientePrecio']; ?> </p></td>
                </tr>
            <?php $precio= $precio + $ingredientes['IngredientePrecio'];           
            }?>
                <td></td>
                <td></td>
                <td><p>$ <?php echo $precio; $_SESSION['monto']=$_SESSION['monto']+$precio;?> </p></td>  
            </tbody>
            </table>
            <?php
    } ?>
    <?php if(isset($_SESSION['bebida'])){$precio=0;?>
        <p>Bebidas</p>
         <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio por unidad</th>
                <th scope="col"></th>
                <th scope="col"><form class="text-end" method="post"><button type="submit" class="btn btn-light btn-sm" name="editarbebida" >Editar</button></form></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($_SESSION['bebida'] as $id){ $ingredientes =  mysqli_fetch_array(buscar_producto($id));?>
                <tr>
                <td><p><?php echo $ingredientes['IngredienteNombre']; ?> </p></td>
                <td><p>$<?php echo $ingredientes['IngredientePrecio']; ?> </p></td>
                </tr>
            <?php $precio= $precio + $ingredientes['IngredientePrecio'];           
            }?>
                <td></td>
                <td></td>
                <td><p>$ <?php echo $precio; $_SESSION['monto']=$_SESSION['monto']+$precio;?> </p></td>  
            </tbody>
            </table>
            <?php
    } ?>
    <p> Monto Total = $ <? echo $_SESSION['monto']; ?></p>
    </div>
  </body>
</html>