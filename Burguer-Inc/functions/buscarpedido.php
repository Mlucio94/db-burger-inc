<?php
    $nro = $_POST['nropedido'];

    include('connection.php');

    $consult="SELECT e.estadotiponombre as estado FROM pedido p inner join estadopedido e on p.estadopedidoid = e.estadopedidoid where p.pedidoid = $nro";
    $result=mysqli_query($conn,$consult);
    $filas = mysqli_num_rows($result);

    if($filas){
        header("location:../verpedido.php?nropedido=$nro");

    }else{
      
         header("location:../index.php?fail=1");
    }

    mysqli_free_result($result);
    mysqli_close($conn);
?>