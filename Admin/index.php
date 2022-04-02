<?php
    session_start();

    if($_POST){
        if(($_POST["user"] == "admin@123") && ($_POST["password"] == "root@123")){
            $_SESSION["usuario"] = "ok";
            $_SESSION["nombreUsuario"] = "admin@123";

            header("location:inicio.php");
        }else{
            $mensaje ="Error: usuario o contraseña incorrectos";
        }
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Iniciar Sesion | Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      
   <div class="container">
       <div class="row justify-content-center align-items-center" style="height:100vh">
           <div class="col-md-12">
                <form action="index.php" method="POST" class="border rounded p-4">
                    <div class="form-group">
                        <label for="user">Usuario</label>
                        <input type="text" name="user" id="user" class="form-control" placeholder="user_example123" aria-describedby="user">
                        <small id="user" class="text-muted">El nombre de usuario no puede contener espacios</small>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control" aria-describedby="password">
                        <small id="password" class="text-muted">Help text</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Entrar</button>

                    <?php if(isset($mensaje)) { ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                    <?php } ?>
                </form>
            </div>    
       </div>
   </div>
  </body>
</html>