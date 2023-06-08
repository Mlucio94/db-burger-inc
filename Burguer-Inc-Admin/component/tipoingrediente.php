<?php
    include('./functions/connection.php');
    

    if(isset($_GET['insertar'])){
        if(empty($_GET['TipName'])){
            echo '<script language="javascript">alert("ERROR: El nombre del tipo no puede estar vacio");</script>';  
        }else{
            $TipNam=$_GET['TipName'];
            $sql= "INSERT INTO ingredientetipo (ingredientetipoid, ingredienteTipoNombre) VALUES (NULL,UPPER('$TipNam'))";
            $insert = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        }   
    }

    if(isset($_GET['delete'])){
        $del=$_GET['delete'];
        $sql = "SELECT IngredienteID from ingrediente where ingredientetipoid = '$del'";
        $control = mysqli_query($conn,$sql);
        if(mysqli_num_rows($control) == 0){
            $sql="DELETE FROM ingredientetipo WHERE ingredientetipoid = '$del'";
                if ($conn->query($sql) === TRUE) {
                  } else {
                    echo '<script language="javascript">alert(<?php Error deleting record: " . $conn->error ?> );</script>';
                }
        }else{echo '<script language="javascript">alert("ERROR: No se puede eliminar el tipo de ingrediente, esta siendo utilizado por uno o varios ingredientes");</script>'; }
    }
    if(isset($_GET['edit'])){    
        if( empty($_GET['name'])){
            echo '<script language="javascript">alert("ERROR: El Tipo de ingrediente no puede estar vacio");</script>';   
        }else{
            $NewName=$_GET['name'];
            $nid=$_GET['id'];
            $sql= "UPDATE ingredientetipo SET ingredienteTipoNombre = UPPER('$NewName') where ingredientetipoid = '$nid'";
            $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        }   
        
    }
    
    $sql = "SELECT * from ingredientetipo";
    $resu = mysqli_query($conn,$sql);  
?>


<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        <div class= "border border-primary rounded p-3 m-2">
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Tipo Nombre</th>
                <th scope="col">Modificar</th>
                <th scope="col">Eliminar</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($f = mysqli_fetch_array($resu))
            {
                ?>
                <tr>
                    <form method="get">
                    <td scope="row"><input name="id" value="<?php echo $f['IngredienteTipoID']; ?>" placeholder="<?php echo $f['IngredienteTipoID']; ?>" class="form-control-plaintext" readonly/></td>
                    <td><input name="name" type="text" placeholder="<?php echo $f['IngredienteTipoNombre']; ?>" ></td>
                    <input type="text"  id="TipoNombre" name="entorno" value="Ajustes" style="display:none;">
                    <input type="text"  id="EstadoNombre" name="aju" value="Tipos" style="display:none;">
                    <td><button type="submit" class="btn btn-light btn-sm" name="edit"><img src="./images/edit.png" class="img-fluid" alt="boton editar" style="width: 18px;"></button></td>
                    </form>
                    <td><form method="get">
                    <input type="text"  id="TipoNombre" name="entorno" value="Ajustes"  style="display:none;">
                    <input type="text"  id="EstadoNombre" name="aju" value="Tipos" style="display:none;">
                    <button type="submit" class="btn btn-light btn-sm"  name="delete" value="<?php echo $f['IngredienteTipoID'];  ?>"><img src="./images/delete.png" class="img-fluid" alt="boton elminiar" style="width: 18px;"></button></form></td>
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
                <label for="TipoNombre">Insertar tipo de ingrediente</label>
                <input type="text" class="form-control" id="TipoNombre" name="TipName" placeholder="Nuevo Tipo">
                <small id="Help" class="form-text text-muted">Recuerde, el nombre del nuevo tipo debe ser unico y representativo.</small>
                </div>
                <input type="text"  id="entorno" name="entorno" value="Ajustes" style="display:none;">
                <input type="text"  id="EstadoNombre" name="aju" value="Tipos" style="display:none;">
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success btn-sm" name="insertar">Añadir</button>
                </div>
            </form>
        </div>     
    </div>
<div>
