<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>União Imóveis</title>

    <!-- Estilos -->
    <?php include("../base/estilosinterno.php"); ?>
</head>

<body>
  <?php include('../base/menu.php') ?>

  <?php
    require '../conecta.php';
    $sucesso = false;

    if(!$_SESSION['login']){
      header('Location:index.php');
    }
    if(isset($_GET['sair'])){
      session_unset();
      session_destroy();
      header('Location:index.php');
    }

    if (isset($_GET['proprietario'])) {
    	$id = $_GET['proprietario'];
	}
  
    //Cadastrar Dados
    if (isset($_REQUEST['cadastrar'])) {

      $id_imovel = (Integer)$_POST['imovel'];
      $id_prop  = $_POST['id_prop'];
      
      
      // Retorno da operação;
    $retorno = pg_query($db, "INSERT INTO proprietario_imovel (id_proprietario, id_imovel) VALUES ($id_prop, $id_imovel)");
      if ($retorno) {
        $sucesso = true;
      }else{
          $sucesso = false;
      }

    }

   ?>

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2 class="text-center">Cadastrar Imóvel</h2>
        <hr>
        <div class="row">
          <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1">
            <form method="post">
            <div class="form-group">
                <label for="tipo_imovel">Tipo de Imóvel*:</label>
                <select class="form-control" name="tipo_imovel" id="tipo_imovel" required>
                  <option selected disabled >Selecione um Tipo de Imóvel ...</option>";
                  <?php 
                    $result = pg_query($db, "select * from tipo_imovel");

                    if (pg_num_rows($result)>0) {
                      while ($linha = pg_fetch_array($result)) {
                        echo  "<option value='".$linha['id'] ."'>".$linha['descricao'] ."</option>";
                      }
                    }
                   ?>
                </select>
              </div>

            <div class="form-group">
                <label for="imovel">Imóvel*:</label>
                <select class="form-control" name="imovel" id="imovel" required>
                  <option selected disabled >Selecione um Imóvel ...</option>";
                  <!-- <?php 
                    $result = pg_query($db, "select * from imovel where locado = 'false'");

                    if (pg_num_rows($result)>0) {
                      while ($linha = pg_fetch_array($result)) {
                        echo  "<option value='".$linha['id'] ."'>".$linha['titulo_imovel'] ."</option>";
                      }
                    }
                   ?> -->
                </select>
              </div>

              <input type="text" name="id_prop" value="<?php echo $id ?>" style="display: none;">
              <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
              <a class="btn btn-warning" href="listaprop.php">Voltar</a>
            </form>

            <br>

            <?php 
              if ($sucesso) {
                echo '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Sucesso!</strong> Imóvel cadastrado com sucesso!
                      </div>';
              }else{
                echo '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Erro!</strong> Erro Cadastrar Imóvel!'.$retorno.'
                      </div>' ;
              }
             ?>
          </div>
        </div>
      </div>
    </div>

</body>
  <?php include("../base/scriptsinterno.php"); ?>
  <script type="text/javascript">
    $(function(){
      $('#tipo_imovel').change(function(){

        if( $(this).val() ) {
          $('#imovel').hide();
          $('.carregando').show();
          $.getJSON('../ajax/imoveis_prop.ajax.php?search=',{tipo_imovel: $(this).val(), ajax: 'true'}, function(j){
            var options = '<option value="">Selecione um Imóvel...</option>'; 

            for (var i = 0; i < j.length; i++) {
              options += '<option value="' + j[i].id + '">' + j[i].titulo_imovel + '</option>';
            } 
            $('#imovel').html(options).show();
            $('.carregando').hide();
          });
        } else {
          $('#imovel').html('<option value="">Selecione um Imóvel...</option>');
        }
      });
    });
  </script>
</html>