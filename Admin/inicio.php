<?php
    include('Templates/header.php');
?>

<div class="col md-12">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3">Bienvenido <?php echo $nombreUsuario ?></h1>
            <hr class="my-2">
            <p>Vamos a administrar tu tienda de productos juntos!</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="seccion/productos.php">Administrar</a>
            </p>
        </div>
    </div>
</div>

<?php
    include('Templates/footer.php');
?>
