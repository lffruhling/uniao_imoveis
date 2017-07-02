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
	
    //Cadastrar Dados
    if (isset($_REQUEST['cadastrar'])) {

      $descricao   = $_POST['tipo_imovel'];
      
      // Retorno da operação;
    $retorno = pg_query($db, "INSERT INTO tipo_imovel (descricao) VALUES ('$descricao')");
      if ($retorno) {
        $sucesso = true;
      }else{
          echo '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Erro!</strong> Problema ao Alugar Imóvel!'.$retorno.'
                      </div>' ;
      }

    }

   ?>

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2 class="text-center">Cadastrar Tipo do Imóvel</h2>
        <hr>
        <div class="row">
          <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1">
            <form method="post">
              <div class="form-group">
                <label for="tipo_imovel">Tipo de Imóvel*:</label>
                <input type="text" class="form-control" name="tipo_imovel" required>
              </div>
              
              <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
            </form>

            <br>

            <?php 
              if ($sucesso) {
                echo '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Sucesso!</strong> Tipo de Imóvel cadastrado com sucesso!
                      </div>';
              }
             ?>
          </div>
        </div>
      </div>
    </div>

  <?php include("../base/scriptsinterno.php"); ?>

</body>
</html>