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
        if(empty($_GET['Name'])){
            echo '<script language="javascript">alert("ERROR: El nombre del ingrediente no puede estar vacio");</script>';  
        }else{
            $id=$_GET['id'];
            $Nam=$_GET['Name'];
            $Tip=$_GET['TipoIng'];
            $Des=$_GET['Desc'];
            $Img=$_GET['Img'];
            
            if(isset($_GET['Tac'])){$Tac=1;}else{$Tac=0;}
            if(isset($_GET['veg'])){$Veg=1;}else{$Veg=0;}
            if(isset($_GET['vis'])){$Vis=true;}else{$Vis=false;}
            if(isset($_GET['del'])){$Del=1;}else{$Del=0;}
         
            $sql= "UPDATE ingrediente set ingredientenombre = UPPER('$Nam'),ingredientetac = '$Tac',ingredienteveg = '$Veg',ingredientedescripcion = '$Des',ingredienteimage = '$Img' ,ingredienteTipoid = '$Tip', ingredientevisible = '$Vis', ingredientebaja = '$Del' where ingredienteid='$id'";
            $insert = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        } 
        unset($_GET['modificar']); 
    }

    
    $options = array();
    $sql= "SELECT  IngredienteID,  IngredienteNombre, i.IngredienteTipoNombre ,  IngredienteTAC ,  IngredienteVeg,  IngredienteDescripcion,  IngredienteImage,  IngredienteVisible from ingrediente i1 inner join ingredientetipo i on i.IngredienteTipoID =  i1.IngredienteTipoID where  i1.IngredienteBaja <> true";
    $resu = mysqli_query($conn,$sql);
    $sql = "SELECT IngredienteTipoID, IngredienteTipoNombre FROM ingredientetipo";
    $resu1 = mysqli_query($conn,$sql);
    while($row = $resu1 -> fetch_assoc()){
        array_push($options,$row);
    }
?>


<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        <div class= "border border-primary rounded p-3 m-2">
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">TACC</th>
                <th scope="col">VEG</th>
                <th scope="col">Desc</th>
                <th scope="col">Imagen</th>
                <th scope="col">Visible</th>
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

                    <td scope="row"><input name="id" value="<?php echo $f['IngredienteID']; ?>" placeholder="<?php echo $f['IngredienteID']; ?>" class="form-control-plaintext" readonly/></td>

                    <td><p><?php echo $f['IngredienteNombre']; ?> </p></td>

                    <td><p><?php echo $f['IngredienteTipoNombre']; ?> </p></td>
                        
                    <td><p><?php echo $f['IngredienteTAC']; ?> </p></td>

                    <td><p><?php echo $f['IngredienteVeg']; ?> </p></td>

                    <td><p><?php echo $f['IngredienteDescripcion']; ?> </p></td>

                    <td><img src= "<?php echo $f['IngredienteImage']; ?>" width="100"></td>
                    
                    <td><p><?php echo $f['IngredienteVisible']; ?> </p></td>


                    <input type="text"  id="TipoNombre" name="entorno" value="Ajustes" style="display:none;">
                    <input type="text"  id="EstadoNombre" name="aju" value="Ingredientesedit" style="display:none;">
                    <td><button type="submit" class="btn btn-light btn-sm"><img src="./images/edit.png" class="img-fluid" alt="boton editar" style="width: 18px;"></button></td>
                    </form>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <div class="m-2"> 
            <form  class="p-2 border border-primary rounded" method="GET">
                <div class="form-group mb-2">
                    <label for="Nombre">Insertar nuevo Ingrediente</label>
                    <input type="text" class="form-control" id="Nombre" name="Name" placeholder="Nombre">
                    <small id="Help" class="form-text text-muted">Recuerde, el nombre del nuevo ingrediente debe ser unico y representativo.</small>
                </div>
                <div class="form-group mt-2 mb-2">
                    <label for="Estado1">Tipo de ingrediente</label>
                    <select id="TipoIng" name="TipoIng" class="form-control form-control-sm">
                    <?php
                       foreach($options as $option){
                    ?>
                            <option value="<?php echo $option['IngredienteTipoID']; ?>"><?php echo $option['IngredienteTipoNombre']; ?></option>
                    <?php  
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">Apto TACC</div>
                    <div class="col-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="Tac">
                        <label class="form-check-label" for="gridCheck1">
                         SI
                        </label>
                    </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">Apto Vegetariano</div>
                    <div class="col-sm-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck1" name="veg">
                        <label class="form-check-label" for="gridCheck1">
                         SI
                        </label>
                    </div>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="Descripcion">Descripcion</label>
                    <input type="text" class="form-control" id="Descripcion" name="Desc" placeholder="Descripcion">
                </div>
                <div class="form-group mb-2">
                    <label for="Imagen">URL: Imagen ingrediente</label>
                    <input type="text" class="form-control" id="Imagen" name="Img" placeholder="Link Imagen">
                </div>
                <input type="text"  id="entorno" name="entorno" value="Ajustes" style="display:none;">
                <input type="text"  id="EstadoNombre" name="aju" value="Ingredientes" style="display:none;">
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success btn-sm" name="insertar">Añadir</button>
                </div>
            </form>
        </div>     
    </div>
<div>
