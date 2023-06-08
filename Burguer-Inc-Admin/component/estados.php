<?php
    include('./functions/connection.php');
    

    if(isset($_GET['insertar'])){
        if( empty($_GET['EstNam'])){
            echo '<script language="javascript">alert("ERROR: El nombre del estado no puede estar vacio");</script>';
            
        }else{
            $EstName=$_GET['EstNam'];
            $sql= "INSERT INTO estadopedido (EstadoPedidoID, EstadoTipoNombre) VALUES (NULL,UPPER('$EstName'))";
            $insert = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        }  
        unset($_GET['insertar']); 
    }
    if(isset($_GET['modificar'])){

        $s1=$_GET['Estado1'];
        $s2=$_GET['Estado2'];
        $s3=$_GET['Estado3'];
        $s4=$_GET['Estado4'];

        if($s1!=$s2 and $s1!=$s3 and $s1!=$s4 and $s2!=$s3 and $s2!=$s4 and $s3!=$s4 ){
            $sql= "UPDATE parmstepestados SET estadopedidoid = case when id = 1 then $s1 when id = 2 then $s2 when id = 3 then $s3 when id = 4 then $s4 end";
            $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));
        }else{
            echo '<script language="javascript">alert("ERROR: No pueden existir dos pasos con el mismo nombre");</script>';
        }   
        unset($_GET['modificar']);
    }
    if(isset($_GET['delete'])){
        $del=$_GET['delete'];
        $sql = "SELECT id, estadopedidoid from parmstepestados where estadopedidoid = '$del'";
        $control = mysqli_query($conn,$sql);
        if(mysqli_num_rows($control) == 0){
            $sql="DELETE FROM estadopedido WHERE EstadoPedidoID = '$del'";
                if ($conn->query($sql) === TRUE) {
                  } else {
                    echo '<script language="javascript">alert(<?php Error deleting record: " . $conn->error ?> );</script>';
                }
        }else{echo '<script language="javascript">alert("ERROR: No se puede elminar un nombre de estado que este siendo utilizado por los pasos actuales");</script>'; }
        unset($_GET['delete']);
    }

    if(isset($_GET['edit'])){    
        if( empty($_GET['name'])){
            echo '<script language="javascript">alert("ERROR: El nombre del estado no puede estar vacio");</script>';   
        }else{
            $NewName=$_GET['name'];
            $nid=$_GET['id'];
            $sql= "UPDATE estadopedido SET EstadoTipoNombre = UPPER('$NewName') where estadopedidoid = '$nid'";
            $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));  
        }   
        unset($_GET['edit']);
    }
    $options = array();
    $sql = "SELECT estadopedido.EstadoPedidoID, estadopedido.EstadoTipoNombre FROM estadopedido ORDER BY estadopedido.EstadoPedidoID ";
    $resu = mysqli_query($conn,$sql);
    $resu1 = mysqli_query($conn,$sql);
    while($row = $resu1 -> fetch_assoc()){
        array_push($options,$row);
    }

    $sql= "SELECT p.id, e.EstadoTipoNombre from estadopedido e inner join parmstepestados p on p.Estadopedidoid=e.EstadoPedidoID order by p.id";
    $dte = mysqli_query($conn,$sql);


    
?>


<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        <div class= "border border-primary rounded p-3 m-2">
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Estado Nombre</th>
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
                    <td scope="row"><input name="id" value="<?php echo $f['EstadoPedidoID']; ?>" placeholder="<?php echo $f['EstadoPedidoID']; ?>" class="form-control-plaintext" readonly/></td>
                    <td><input name="name" type="text" placeholder="<?php echo $f['EstadoTipoNombre']; ?>" ></td>
                    <input type="text"  id="EstadoNombre" name="entorno" value="Ajustes" placeholder="Nombre Estado" style="display:none;">
                    <td><button type="submit" class="btn btn-light btn-sm" name="edit"><img src="./images/edit.png" class="img-fluid" alt="boton editar" style="width: 18px;"></button></td>
                    </form>
                    <td><form method="get">
                    <input type="text"  id="EstadoNombre" name="entorno" value="Ajustes" placeholder="Nombre Estado" style="display:none;">
                    <button type="submit" class="btn btn-light btn-sm"  name="delete" value="<?php echo $f['EstadoPedidoID'];  ?>"><img src="./images/delete.png" class="img-fluid" alt="boton elminiar" style="width: 18px;"></button></form></td>
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
                <label for="EstadoNombre">Insertar nuevo estado</label>
                <input type="text" class="form-control" id="EstadoNombre" name="EstNam" placeholder="Nombre Estado">
                <small id="Help" class="form-text text-muted">Recuerde, el nombre del nuevo estado debe ser unico y representativo.</small>
                </div>
                <input type="text"  id="EstadoNombre" name="entorno" value="Ajustes" placeholder="Nombre Estado" style="display:none;">
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success btn-sm" name="insertar">Añadir</button>
                </div>
            </form>
            <form class="p-2 mt-2 border border-primary rounded" method="GET">
                <p class="font-weight-bold">Estados del pedido</p>
                <?php
                
                    while($step = mysqli_fetch_array($dte))
                    {//hacer una consulta con el id que traje
                        ?>
                        <p class="fst-italic ml-2 mb-0"> Paso <?php echo $step['id']?>: <?php echo $step['EstadoTipoNombre'];?> </p>
                        <?php
                    }
                ?>  
                <div class="form-group mt-2 mb-2">
                    <label for="Estado1">Paso 1:</label>
                    <select id="Estado1" name="Estado1" class="form-control form-control-sm">
                    <?php
                       foreach($options as $option){
                    ?>
                            <option value="<?php echo $option['EstadoPedidoID']; ?>"><?php echo $option['EstadoTipoNombre']; ?></option>
                    <?php  
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="Estado2">Paso 2:</label>
                    <select id="Estado2" name="Estado2" class="form-control form-control-sm">
                    <?php
                       foreach($options as $option){
                    ?>
                            <option value="<?php echo $option['EstadoPedidoID']; ?>"><?php echo $option['EstadoTipoNombre']; ?></option>
                    <?php  
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="Estado3">Paso 3:</label>
                    <select id="Estado3" name="Estado3" class="form-control form-control-sm">
                    <?php
                       foreach($options as $option){
                    ?>
                            <option value="<?php echo $option['EstadoPedidoID']; ?>"><?php echo $option['EstadoTipoNombre']; ?></option>
                    <?php  
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="Estado4">Paso 4:</label>
                    <select id="Estado4" name="Estado4" class="form-control form-control-sm">
                    <?php
                       foreach($options as $option){
                    ?>
                            <option value="<?php echo $option['EstadoPedidoID']; ?>"><?php echo $option['EstadoTipoNombre']; ?></option>
                    <?php  
                        }
                    ?>
                    </select>
                </div>
                <small id="emailHelp" class="form-text text-muted">Para alterar el estado de los pedidos debe dar a MODIFICAR.</small>
                <input type="text"  id="EstadoNombre" name="entorno" value="Ajustes" placeholder="Nombre Estado" style="display:none;">
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-danger btn-sm" name="modificar">Modificar</button>
                </div>
            </form>
        </div>     
    </div>
<div>
