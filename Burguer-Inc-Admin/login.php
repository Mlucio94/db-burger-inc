<!doctype html>
<html lang="en">
<!-- Head -->
<?php include("component/head.php"); ?>

<body class="bg-dark">
    <div class="container mx-auto">

        <div class="card mx-auto mt-5" style="width: 18rem;">
            <div class="card-body">
                <div class="text-center">
                    <img src="./images/name-admin.png" class="card-img-top" alt="...">
                    <?php
                        if(isset($_GET['fail'])){
                            ?>
                                <div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
                                <div>
                                    Usuario o contraseña incorrecto
                                </div>
                                </div>
                             <?php    
                        }
                    ?>
                </div>
                <form action="./functions/validation.php" method="POST">
                    <div class="form-group">
                        <label for="user">Usuario</label>
                        <input type="text" class="form-control" id="user" name="usuario" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="contraseña" placeholder="Password">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary mt-2">Login</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JS Scripts -->

</body>

</html>

?> 
        