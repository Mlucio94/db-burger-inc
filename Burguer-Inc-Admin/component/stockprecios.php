<?php
    include('./functions/connection.php');
    

    if(isset($_GET['insertar'])){
        if(empty($_GET['Name'])){
            echo '<script language="javascript">alert("ERROR: El nombre del ingrediente no puede estar vacio");</script>';  
        }else{
            $Nam=$_GET['Name'];
            $Tip=$_GET['TipoIng'];
            $Des=$_GET['Desc'];
            $Img=$_GET['Img'];
            if(isset($_GET['Tac'])){$Tac=1;}else{$Tac=0;}
            if(isset($_GET['veg'])){$Veg=1;}else{$Veg=0;}
            

            $sql= "INSERT INTO ingrediente (ingredienteid,ingredientenombre,ingredienteprecio,ingredientestock, ingredientetac,ingredienteveg,ingredientedescripcion,ingredienteimage,ingredienteTipoid,ingredientebaja,ingredientevisible) VALUES (NULL,UPPER('$Nam'),0,0,'$Tac','$Veg','$Des','$Img','$Tip',false,false)";
            $insert = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        }   
        unset($_GET['insertar']);
    }

    if(isset($_GET['modificar'])){
        if($_GET['precio']<0){
            echo '<script language="javascript">alert("ERROR: El Precio no puede ser menor a $0");</script>';  
        }else{
            $dif=($_GET['stock']+$_GET['var']);
            if($dif<0){
                echo '<script language="javascript">alert("ERROR: No se puede tener stock negativo");</script>';

            }else{
                $id=$_GET['id'];
                $precio=$_GET['precio'];

                $sql= "UPDATE ingrediente set ingredienteprecio='$precio',ingredientestock='$dif'  where ingredienteid='$id'";
                $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));

            } 
        }  
        unset($_GET['modificar']); 
    }

    
    $options = array();
    $sql= "SELECT  IngredienteID,  IngredienteNombre, IngredienteStock ,  IngredientePrecio ,  IngredienteImage from ingrediente where  IngredienteBaja <> true";
    $resu = mysqli_query($conn,$sql);
    
?>


<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        <div class= "border border-primary rounded p-3 m-2">
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Imagen</th>
                <th scope="col">Stock Cant.</th>
                <th scope="col">Modificar (+/-)</th>
                <th scope="col">Precio</th>
                <th scope="col">Modificar</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($f = mysqli_fetch_array($resu))
            {
                ?>
                <tr>
                    <form method="get">

                    <td scope="row"><p><?php echo $f['IngredienteID']; ?></p></td>

                    <td><p><?php echo $f['IngredienteNombre']; ?> </p></td>

                    <td><img src= "<?php echo $f['IngredienteImage']; ?>" width="100"></td>

                    <td><p><?php echo $f['IngredienteStock']; ?></p></td>

                    <td><input name="var" type="number" placeholder="Cant a modificar" value=0></td>

                    <td>$ <input step="any" name="precio" type="number" value="<?php echo $f['IngredientePrecio']; ?>" ></td>
                        
                    <input name="id" value="<?php echo $f['IngredienteID']; ?>" style="display:none;"/>
                    <input name="stock" value="<?php echo $f['IngredienteStock']; ?>" style="display:none;"/>
                    <input type="text"  id="TipoNombre" name="entorno" value="Stock" style="display:none;">
                    
                    <td><button type="submit" class="btn btn-light btn-sm" name="modificar"><img src="./images/edit.png" class="img-fluid" alt="boton editar" style="width: 18px;"></button></td>
                    </form>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        
<div>
