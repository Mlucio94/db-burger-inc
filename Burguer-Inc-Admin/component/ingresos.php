<?php
    include('./functions/connection.php');

    if(isset($_GET['modificar'])){

        $id=$_GET['id'];
        

        $sql= "update pedido set estadopedidoid = ( select e.EstadoPedidoID from estadopedido e inner join parmstepestados p on e.EstadoPedidoID = p.EstadoPedidoId where p.id = 2 ) where PedidoID = '$id'";
        $update = mysqli_query($conn,$sql) or die ($sql . mysqli_error($conn));

        unset($_GET['modificar']); 
    }

    $sql= "select PedidoID , PedidoNombre , PedidoFecha , sec_to_time(now() - PedidoFecha) as time from pedido p inner join estadopedido e on p.estadopedidoid = e.EstadoPedidoID inner join parmstepestados p2 on e.EstadoPedidoID = p2.EstadoPedidoId where p2.id = 1";
    $resu = mysqli_query($conn,$sql);
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
                    <th scope="col">Tiempo en espera</th>
                    <th scope="col">Pasar a Cocina</th>
                
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

                        <td><?php echo $f['PedidoFecha']; ?></td>

                        <td><p><?php echo $f['time']; ?></p></td>

                        <input name="id" value="<?php echo $f['PedidoID']; ?>" style="display:none;"/>
                        <input type="text"  name="entorno" value="Pedidos" style="display:none;">
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