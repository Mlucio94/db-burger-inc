
<?php
    include('./functions/connection.php');
    
    $id=$_GET['id'];
    $sql= "SELECT  IngredienteID,  IngredienteNombre,i.IngredienteTipoID, i.IngredienteTipoNombre ,  IngredienteTAC ,  IngredienteVeg,  IngredienteDescripcion,  IngredienteImage, IngredienteBaja,  IngredienteVisible from ingrediente i1 inner join ingredientetipo i on i.IngredienteTipoID = i1.IngredienteTipoID where  IngredienteID='$id' ";
    $resu = mysqli_query($conn,$sql);
    
    $options = array();
    $sql = "SELECT IngredienteTipoID, IngredienteTipoNombre FROM ingredientetipo";
    $resu1 = mysqli_query($conn,$sql);
    while($row = $resu1 -> fetch_assoc()){
        array_push($options,$row);
    }
?>
<div class="container p-3 bg-white">
    <?php while($f = mysqli_fetch_array($resu)){ ?>
        <div class=" d-flex justify-content-center" >
        <div class="m-2 p-2 border border-primary rounded"> 
                <p class="">MODIFICAR DATOS</P>
                <form   method="GET">
                    <div class="form-group m-2">
                        <label for="Nombre" class="mb-1">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="Name" placeholder="Nombre" value="<?php echo $f['IngredienteNombre']; ?>">
                    </div>
                    <div class="form-group m-2">
                        <label for="Estado1 " class="mb-1">Tipo de ingrediente</label>
                        <select id="TipoIng" name="TipoIng" class="form-control form-control-sm">
                        <option value="<?php echo $f['IngredienteTipoID']; ?>"><?php echo $f['IngredienteTipoNombre']; ?></option>
                        <?php foreach($options as $option){?>
                                <option value="<?php echo $option['IngredienteTipoID']; ?>"><?php echo $option['IngredienteTipoNombre']; ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group row m-2">
                        <div class="col-sm-6">Contiene TAC</div>
                        <div class="col-sm-2">
                        <div class="form-check">
                            <?php if($f['IngredienteTAC']==1){ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="Tac" checked>

                            <?php }else{ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="Tac">
                            <?php } ?>
                            <label class="form-check-label" for="gridCheck1">
                            SI
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row m-2">
                        <div class="col-sm-6">Apto Vegetariano</div>
                        <div class="col-sm-2">
                        <div class="form-check">
                            <?php if($f['IngredienteVeg']==1){ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="veg" checked>

                            <?php }else{ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="veg">
                            <?php } ?>
                            <label class="form-check-label" for="gridCheck1">
                            SI
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group m-2">
                        <label for="Descripcion">Descripcion</label>
                        <input type="text" class="form-control" id="Descripcion" name="Desc" placeholder="Descripcion" value="<?php echo $f['IngredienteDescripcion']; ?>">
                    </div>
                    <div class="form-group m-2">
                        <label for="Imagen" class="mb-1"><img src= "<?php echo $f['IngredienteImage']; ?>" width="300"></label>
                        <input type="text" class="form-control" id="Imagen" name="Img" placeholder="Link Imagen" value="<?php echo $f['IngredienteImage']; ?>">
                    </div>
                    <div class="form-group row m-2">
                        <div class="col-sm-6">Visible en el sistema</div>
                        <div class="col-sm-2">
                        <div class="form-check">
                            <?php if($f['IngredienteVisible']==true){ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="vis" checked>

                            <?php }else{ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="vis">
                            <?php } ?>
                            <label class="form-check-label" for="gridCheck1">
                            SI
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="form-group row m-2">
                        <div class="col-sm-6">ELIMINAR INGREDIENTE</div>
                        <div class="col-sm-2">
                        <div class="form-check">
                            <?php if($f['IngredienteBaja']==true){ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="del" checked>

                            <?php }else{ ?>
                                <input class="form-check-input" type="checkbox" id="gridCheck1" name="del">
                            <?php } ?>
                            <label class="form-check-label" for="gridCheck1">
                            SI
                            </label>
                        </div>
                        </div>
                    </div>
                   
                    <input type="text"  id="id" name="id" value="<?php echo $f['IngredienteID'];?>" style="display:none;">
                    <input type="text"  id="entorno" name="entorno" value="Ajustes" style="display:none;">
                    <input type="text"  id="EstadoNombre" name="aju" value="Ingredientes" style="display:none;">
                    <div class="text-end m-2">
                        <button type="submit" class="btn btn-outline-success btn-sm" name="modificar">Modificar</button>
                    </div>
                </form>
                <div class="text-end m-2">
                    <form   method="GET">
                        <input type="text"  id="entorno" name="entorno" value="Ajustes" style="display:none;">
                        <input type="text"  id="EstadoNombre" name="aju" value="Ingredientes" style="display:none;">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Cancelar</button>
                    </form>
                </div>
            </div>     
        </div>
    <?php
    }
    ?>
<div>

