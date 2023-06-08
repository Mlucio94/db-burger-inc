<?php
    include('./functions/connection.php');

    if(isset($_GET['FechaDesde'])){$fechaDesde=date('Y-m-d H:i',strtotime($_GET['FechaDesde'].' '.$_GET['HoraDesde']));}else{$fechaDesde =  date('Y-m-d 00:01');}
    
    if(isset($_GET['FechaHasta'])){$fechaHasta=date('Y-m-d H:i',strtotime($_GET['FechaHasta'].' '.$_GET['HoraHasta']));}else{$fechaHasta =  date('Y-m-d 23:59');}
    $total= 0;
    $Cantidad = 0;
  
    if($fechaHasta<$fechaDesde){echo '<script language="javascript">alert("ERROR: La Fecha hasta  no puede ser menor a la Desde. Se colocara el valor por defecto.");</script>';
        $fechaDesde =  date('Y-m-d 00:00');
        $fechaHasta =  date('Y-m-d 23:59');
    }
   

    //$options = array();
    $sql= "select PedidoID , PedidoNombre , sec_to_time(PedidoFechaEntrega - PedidoFecha) as time, PedidoMontoTotal from pedido p inner join estadopedido e on p.estadopedidoid = e.EstadoPedidoID inner join parmstepestados p2 on e.EstadoPedidoID = p2.EstadoPedidoId where PedidoFechaEntrega between '$fechaDesde' and '$fechaHasta' and p2.id = 4";
    $resu = mysqli_query($conn,$sql);
    
?>    

<div class="container p-3 bg-white">
    <div class=" d-flex justify-content-center" >
        
        <div class="card text-white bg-secondary p-3 m-2" style="max-width: 18rem; max-height: 20rem">
        <form method="get">
            <div class="mb-3">
                <label for="FechaDesde" class="form-label">Desde</label>
                <input type="date" class="form-control" name="FechaDesde" max ="23:59" value=<?php echo date("Y-m-d",strtotime( $fechaDesde)); ?> >
                <input type="time" class="form-control" name="HoraDesde"  max ="23:59" value = <?php echo date("H:i", strtotime($fechaDesde)); ?>>
            </div>
            <div class="mb-3">
                <label for="FechaHasta" class="form-label">Hasta</label>
                <input type="date" class="form-control" name="FechaHasta" value=<?php echo date("Y-m-d",strtotime( $fechaHasta)); ?>>
                <input type="time" class="form-control" name="HoraHasta" value=<?php echo date("H:i", strtotime($fechaHasta)); ?>>
            </div>
            <input type="text"  name="entorno" value="Pedidos" style="display:none;">
            <input type="text"  name="aju" value="Entregados" style="display:none;">
            <button type="submit" class="btn btn-primary" name ="filtrar" >Filtrar</button>
        </form>
        </div>
       
        <div class= "border border-primary rounded p-3 m-2">
        
        <table class="table ">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nro Pedido</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Tiempo en espera</th>
                    <th scope="col">$</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($f = mysqli_fetch_array($resu) )
            {   $total =  $total + $f['PedidoMontoTotal'];
                $Cantidad = $Cantidad + 1;
                ?>
                
                <tr>
                        <td scope="row"><p><?php echo $f['PedidoID']; ?></p></td>

                        <td><p><?php echo $f['PedidoNombre']; ?></p></td>

                        <td><?php echo $f['time']; ?></td>

                        <td><p><?php echo $f['PedidoMontoTotal']; ?></p></td>

                </tr>
           
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
        <div class="card text-white bg-secondary p-3 m-2" style=" max-height: 8rem">
            <div class="card-header">Total</div>
            <div class="card-body">
                <h5 class="card-title">$<?php echo $total;?></h5>
            </div>
            
        </div>
        <div class="card text-white bg-secondary p-3 m-2" style=" max-height: 8rem">
            <div class="card-header">Cantidad</div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $Cantidad;?></h5>
            </div>
        </div>
        
<div>