<?php
    session_start();
    include('connection.php');

    $sql="SELECT estadopedidoid from parmstepestados where id=1";
    $select= mysqli_query($conn,$sql);
    if ($row = mysqli_fetch_row($select)) { $estado = trim($row[0]); }


    $sql="INSERT into pedido values (null,now(),0,0,$estado,null,null)";
    $insert= mysqli_query($conn,$sql);
    $sql="SELECT max(PedidoID) as id from pedido";
    $select= mysqli_query($conn,$sql);
    if ($row = mysqli_fetch_row($select)) { $idVenta = trim($row[0]); }
    $total=0;
    $PedidoItemID = 1;
    $PedidoItemNro=1;

    if(isset($_SESSION['item'])){
        foreach($_SESSION['item'] as $x => $hamburguesa){
            $sql="INSERT into pedidoitem values ($PedidoItemID,$idVenta,$PedidoItemNro,0)";
            $insert= mysqli_query($conn,$sql);
           
            $orden=1;
            $monto=0;
            foreach($hamburguesa as $id){
                $ingredientes =  mysqli_fetch_array(buscar_producto($id));
                $monto = $monto + $ingredientes['IngredientePrecio'];
                $sql="INSERT into itemingrediente values ($PedidoItemID,$idVenta,$id,$orden)";
                $insert= mysqli_query($conn,$sql);
                actualiza_stock($id);
                $orden ++;
            }
            $sql="UPDATE pedidoitem SET pedidoitemmonto = $monto where  pedidoitemid = $PedidoItemID and pedidoid = $idVenta";
            $update= mysqli_query($conn,$sql);
            $total = $total + $monto;
            $PedidoItemID ++;
            $PedidoItemNro ++;
        }
    }
    
    if(isset($_SESSION['bebida'])){
        $sql="INSERT into pedidoitem values ($PedidoItemID,$idVenta,$PedidoItemNro,0)";
        $insert= mysqli_query($conn,$sql);
        $orden=1;
        $monto=0;
        foreach($_SESSION['bebida'] as $id){
            $ingredientes =  mysqli_fetch_array(buscar_producto($id));
            $monto = $monto + $ingredientes['IngredientePrecio'];
            $sql="INSERT into itemingrediente values ($PedidoItemID,$idVenta,$id,$orden)";
            $insert= mysqli_query($conn,$sql);
            actualiza_stock($id);
            $orden=$orden + 1;
        }
        $sql="UPDATE pedidoitem SET pedidoitemmonto = $monto where  pedidoitemid = $PedidoItemID and pedidoid = $idVenta";
        $update= mysqli_query($conn,$sql);
        $total = $total + $monto;
        $PedidoItemID ++;
        $PedidoItemNro ++;   
    }

    if(isset($_SESSION['extra'])){
        $sql="INSERT into pedidoitem values ($PedidoItemID,$idVenta,$PedidoItemNro,0)";
        $insert= mysqli_query($conn,$sql);
        $orden=1;
        $monto=0;
        foreach($_SESSION['extra'] as $id){
            $ingredientes =  mysqli_fetch_array(buscar_producto($id));
            $monto = $monto + $ingredientes['IngredientePrecio'];
            $sql="INSERT into itemingrediente values ($PedidoItemID,$idVenta,$id,$orden)";
            $insert= mysqli_query($conn,$sql);
            actualiza_stock($id);
            $orden=$orden + 1;
        }
        $sql="UPDATE pedidoitem SET pedidoitemmonto = $monto where  pedidoitemid = $PedidoItemID and pedidoid = $idVenta";
        $update= mysqli_query($conn,$sql);
        $total = $total + $monto;
        $PedidoItemID ++;
        $PedidoItemNro ++;   
    }
    $sql="UPDATE pedido SET pedidomontototal = $total where pedidoid = $idVenta";
    $update= mysqli_query($conn,$sql);


    function actualiza_stock($id){
        include('connection.php');
        $sql="UPDATE ingrediente set ingredientestock = ingredientestock - 1 where IngredienteID= $id";
        $update = mysqli_query($conn,$sql);
    }
    function buscar_producto($nro){
        include('connection.php');
        $sql="SELECT IngredienteStock, IngredientePrecio from Ingrediente where IngredienteID = $nro ";
        $resu = mysqli_query($conn,$sql);
        return $resu;
    }

    header("location: ../pedidoterminado.php?venta=$idVenta");
?>
