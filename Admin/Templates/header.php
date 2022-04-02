<?php 
  session_start();
  if(!isset($_SESSION["usuario"])){
    header('location:../index.php');
  }else{
    if($_SESSION["usuario"] == "ok"){
      $nombreUsuario = $_SESSION["nombreUsuario"];
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/6fc7def821.js' crossorigin='anonymous'></script>
  </head>
  <body>

  <?php 
    $url = "http://".$_SERVER['HTTP_HOST']."/webpage_ShopBook"
  ?>

  <nav class="navbar navbar-expand navbar-light bg-light">
      <div class="nav navbar-nav">
          <a class="nav-item nav-link active" href="#">Administrador</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/admin/inicio.php">Inicio</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/productos.php">Productos</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>">Ver Página Web</a>
          <a class="nav-item nav-link" href="<?php echo $url;?>/admin/seccion/cerrarSesion.php">Cerrar Sesión</a>
      </div>
  </nav>
      
  <div class="container">
      <div class="row pt-3">