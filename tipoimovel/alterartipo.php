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

      $descricao  = $_POST['tipo_imovel'];
      $id         = $_POST['id_tipo'];
      // Retorno da operação;
      
      $retorno = pg_query($db, "update tipo_imovel set descricao = '$descricao' where id = $id");
      if ($retorno) {
        $sucesso = true;
      }else{
          echo '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Erro!</strong> Problema ao Alugar Imóvel!'.$retorno.'
                      </div>' ;
      }

    }

//Busca os dados
    if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $descricao = "";

    $result = pg_query($db, "select descricao from tipo_imovel where id = $id");

    if (pg_num_rows($result)>0) {
      while ($linha = pg_fetch_array($result)) {
        $descricao = $linha['descricao'] ;
      }
    }
  }

   ?>

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2 class="text-center">Alterar Tipo de Imóvel</h2>
        <hr>
        <div class="row">
          <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1">
            <form method="post">
              <div class="form-group">
                <label for="tipo_imovel">Tipo de Imóvel*:</label>
                <input type="text" class="form-control" name="tipo_imovel" value="<?php echo $descricao ?>" required>
                <input type="text" name="id_tipo" value="<?php echo $id ?>" style="display: none;">
              </div>
              
              <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
              <a class="btn btn-warning" href="listatipos.php">Voltar</a>
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

  <!-- Scripts -->
  <?php include("../base/scriptsinterno.php"); ?>
</body>
</html>