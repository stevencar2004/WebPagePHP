<?php
    include('Templates/header.php');
?>

<?php 

  include("Admin/config/connection_bd.php");

  $query_sql = $connection->prepare("SELECT * FROM libros");
  $query_sql->execute();
  $listaProductos = $query_sql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php foreach($listaProductos as $libro) { ?>     
  <div class="col-md-4">
    <div class="card">
      <img class="card-img-top" src="Assets/<?php echo $libro["imagen"]  ?>" alt="">
      <div class="card-body">
        <h4 class="card-title">
          <?php echo $libro["nombre"]?>
        </h4>
        <a name="" id="" class="btn btn-primary" href="" role="button">Ver mas</a>
      </div>
    </div>
  </div>
<?php } ?>


<?php
    include('Templates/footer.php');
?>
