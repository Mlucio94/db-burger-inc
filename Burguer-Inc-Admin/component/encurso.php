<?php
    include('./functions/connection.php');

    $id = 0;
    $item= 0;
    if(isset($_GET['Detalle'])){  $id=$_GET['id']; unset($_GET['Detalle']); }
    if(isset($_GET['Terminar'])){  
        $idTerminado=$_GET['idTerminado'];
        $sql= "update pedido set PedidoFechaEntrega = now(), estadopedidoid = ( select e.EstadoPedidoID from estadopedido e inner join parmstepestados p on e.EstadoPedidoID = p.EstadoPedidoId where p.id = 3 ) where PedidoID = '$idTerminado'";
        $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));

        unset($_GET['Terminar']); 
    
    }

    $sql= "select PedidoID , PedidoNombre , PedidoFecha , sec_to_time(now() - PedidoFecha) as time from pedido p inner join estadopedido e on p.estadopedidoid = e.EstadoPedidoID inner join parmstepestados p2 on e.EstadoPedidoID = p2.EstadoPedidoId where p2.id = 2";
    $resu = mysqli_query($conn,$sql);

    $sql2= "select PedidoID,PedidoItemId,ItemIngredienteOrden,IngredienteNombre from itemingrediente i inner join ingrediente i2 on i.IngredienteID = i2.IngredienteID where i.PedidoID = '$id' order by i.PedidoItemID,i.ItemIngredienteOrden";
    $resu2 = mysqli_query($conn,$sql2);
?>    

<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        <div class= "border border-primary rounded p-3 m-2">
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nro Pedido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Ingreso</th>
                  
                    <th scope="col">Ver Datalle</th>
                
                </tr>
            </thead>
            <tbody>
            <?php
            while($f = mysqli_fetch_array($resu))
            {
                ?>
                
                <tr>
                    <form method="get">

                        <td scope="row"><p><?php echo $f['PedidoID']; ?></p></td>

                        <td><p><?php echo $f['PedidoNombre']; ?></p></td>

                        

                        <td><p><?php echo $f['time']; ?></p></td>

                        <input name="id" value="<?php echo $f['PedidoID']; ?>" style="display:none;"/>
                        <input type="text"  name="entorno" value="Pedidos" style="display:none;">
                        <input type="text"  name="aju" value="EnCurso" style="display:none;">
                        <td><button type="submit" class="btn btn-light btn-sm" name="Detalle"><img src="./images/edit.png" class="img-fluid" alt="boton editar" style="width: 18px;"></button></td>

                        
                    </form>
                </tr>
           
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <div class= "border border-primary rounded p-3 m-2">
        <form method="get">
                <label for="idTerminado" class="form-label">Nro Pedido</label>
                <input name="idTerminado" value="<?php echo $id; ?>" style= "border: 0;" readonly/>
                <input type="text"  name="entorno" value="Pedidos" style="display:none;">
                <input type="text"  name="aju" value="EnCurso" style="display:none;">
                <button type="submit" class="btn btn-success btn-sm" name="Terminar">Terminar</button>
            </form>
        <table class="table ">
            
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Orden</th>
                    <th scope="col">Ingrediente</th>
                
                </tr>
            </thead>
            <tbody>
            <?php
            while($s = mysqli_fetch_array($resu2)){
            ?>  <tr>
                    <td scope="row"><p><?php
                        if($item <> $s['PedidoItemId']){
                            $item = $s['PedidoItemId'];
                            echo $s['PedidoItemId']; 
                        }else{ }
                    
                    ?></p></td>
                
                
                    <td><p><?php echo $s['ItemIngredienteOrden']; ?></p></td>
                    <td><p><?php echo $s['IngredienteNombre']; ?></p></td>                    
                </tr>
           
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        
<div>