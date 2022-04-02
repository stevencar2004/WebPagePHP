<?php
    include('../Templates/header.php');
?>

<?php
    $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "" ;
    $txtNombre = (isset($_POST["txtNombre"])) ? $_POST["txtNombre"] : "" ;
    $txtFile = (isset($_FILES["txtFile"]["name"])) ? $_FILES["txtFile"]["name"] : "" ;
    $accion = (isset($_POST["action"])) ? $_POST["action"] : "" ;

    include('../config/connection_bd.php');

    switch ($accion) {
        case 'agregar':
            $query_sql = $connection->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
            $query_sql->bindParam(':nombre',$txtNombre);

            // Agregar el nombre de la imagen y guardarla en la carpeta en local
            $fecha = new DateTime();
            $nombreArchivo = ($txtFile != "") ? $fecha->getTimestamp()."_".$_FILES["txtFile"]["name"]:"imagen.jpg";
           
            $tmpImagen = $_FILES["txtFile"]["tmp_name"];

            if($tmpImagen != ""){
                move_uploaded_file($tmpImagen, "../../Assets/$nombreArchivo");
            }

            $query_sql->bindParam(':imagen',$nombreArchivo);
            $query_sql->execute();
            header("location:productos.php");
            break;

        //------NO ESTA FUNCIONANDO ACTUALIZAR, REVISARR!!!
        case 'actualizar':
        //------NO ESTA FUNCIONANDO, REVISARR!!!
            $query_sql = $connection->prepare("UPDATE libros SET nombre=:nombre WHERE libros.id=:id");
            $query_sql->bindParam(":nombre", $txtNombre);
            $query_sql->bindParam(":id", $txtID);
            $query_sql->execute();

            if($txtFile != ""){ 
                echo "Entre;";
                // BUSCAMOS Y ACTUALIZAMOS LA IMAGEN
                $fecha = new DateTime();
                $nombreArchivo = ($txtFile != "") ? $fecha->getTimestamp()."_".$_FILES["txtFile"]["name"]:"imagen.jpg";
                $tmpImagen = $_FILES["txtFile"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../../Assets/$nombreArchivo");
             
                $query_sql = $connection->prepare("SELECT imagen FROM libros WHERE id=:id");
                $query_sql->bindParam(":id", $txtID);
                $query_sql->execute();
                $producto = $query_sql->fetch(PDO::FETCH_LAZY);
    
                // Borramos la imagen de la carpeta local
                if(isset($producto["imagen"]) && ($producto["imagen"]!="imagen.jpg")){
                    echo "Entre 1";
                    if(file_exists("../../Assets/".$producto["imagen"])){
                        echo "Entre 2";
                        unlink("../../Assets/".$producto["imagen"]);
                    }
                }

                // BORRAMOS LA IMAGEN ANTERIOR
                $query_sql = $connection->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $query_sql->bindParam(":imagen", $txtFile);
                $query_sql->bindParam(":id", $txtID);
                $query_sql->execute();
                header("location:productos.php");
            }

            break;

        case 'cancelar':
            header("location:productos.php");
            break;

        case 'seleccionar':
            $query_sql = $connection->prepare("SELECT * FROM libros WHERE id=:id");
            $query_sql->bindParam(":id", $txtID);
            $query_sql->execute();
            $producto = $query_sql->fetch(PDO::FETCH_LAZY);
            
            $txtNombre = $producto['nombre'];
            $txtFile = $producto['imagen'] ;

            break;
      
        case 'eliminar':

            $query_sql = $connection->prepare("SELECT imagen FROM libros WHERE id=:id");
            $query_sql->bindParam(":id", $txtID);
            $query_sql->execute();
            $producto = $query_sql->fetch(PDO::FETCH_LAZY);

            // Borramos la imagen de la carpeta local
            if(isset($producto["imagen"]) && ($producto["imagen"]!="imagen.jpg")){
                if(file_exists("../../Assets/".$producto["imagen"])){
                    unlink("../../Assets/".$producto["imagen"]);
                }
            }

            // Borramos el registro de la base de datos
            $query_sql = $connection->prepare("DELETE FROM libros WHERE id=:id");
            $query_sql->bindParam(":id", $txtID);
            $query_sql->execute();
            header("location:productos.php");
            break;

    }

    $query_sql = $connection->prepare("SELECT * FROM libros");
    $query_sql->execute();
    $listaProductos = $query_sql->fetchAll(PDO::FETCH_ASSOC);


?>


<div class="col-md-5">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Agregar Producto</h3>
        <div class="form-group">
          <label for="idproduct">ID</label>
          <input type="text" name="txtID" id="idproduct" value="<?php echo $txtID; ?>"  class="form-control" placeholder="Id del producto..." disabled>
        </div>

        <div class="form-group">
          <label for="name">Nombre:</label>
          <input type="text" name="txtNombre" id="name" value="<?php echo $txtNombre; ?>" class="form-control" placeholder="Ingresa el nombre del producto..." require>
        </div>

        <div class="form-group">
            <label for="img">Imagen: <?php echo $txtFile ?> </br>
            <?php if($txtFile != "") { ?>
              <img src="../../Assets/<?php echo $txtFile ?> " alt="" width="100" class="img-thumbnail">
            <?php } ?>
          </label>

          <input type="file" name="txtFile" id="img" class="form-control" require>
        </div>

        <div class="btn-group mt-3">
            <button type="submit" name="action" value="agregar" class="btn btn-success" <?php echo ($accion == "seleccionar") ? "disabled": "" ?>>Agregar</button>
            <button type="submit" name="action" value="actualizar" class="btn btn-primary " <?php echo ($accion != "seleccionar") ? "disabled": "" ?>>Actualizar</button>
            <button type="submit" name="action" value="cancelar" class="btn btn-danger " <?php echo ($accion != "seleccionar") ? "disabled": "" ?>>Cancelar</button>
        </div>
    </form>
</div>

<div class="col-md-7">
   <table class="table table-bordered">
       <thead>
           <tr>
               <th>ID</th>
               <th>Nombre</th>
               <th>Imagen</th>
               <th>Acciones</th>
           </tr>
       </thead>

       <tbody>
           <?php foreach($listaProductos as $libro) { ?>     
                <tr>
                    <td scope="row"> <?php echo $libro['id'] ?></td>
                    <td> <?php echo $libro['nombre'] ?> </td>
                    <td> 
                        <img src="../../Assets/<?php echo $libro['imagen'] ?> " alt="" width="70">
                    </td>
                    <td>
                    <form method="POST" class="btn-group">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'] ?>">
                            <button type="submit" class="btn btn-primary" name="action" value="seleccionar">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button type="submit" class="btn btn-danger" name="action" value="eliminar">
                                <i class="fa-solid fa-trash-can"></i>     
                            </button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
       </tbody>
   </table>
</div>

<?php
    include('../Templates/footer.php');
?>
