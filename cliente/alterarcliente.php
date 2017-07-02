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

      $nome  	= $_POST['nome'];
      $cpf		= $_POST['cpf'];
      $fone		= $_POST['fone'];
      $email	= $_POST['email'];
      $id       = $_POST['id_cli'];
      // Retorno da operação;
      
      $retorno = pg_query($db, "update cliente set nome = '$nome', cpf = '$cpf', fone = '$fone', email = '$email' where id = $id");
      if ($retorno) {
        $sucesso = true;
      }else{
          echo '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Erro!</strong> Problema ao editar cliente!'.$retorno.'
                      </div>' ;
      }

    }

//Busca os dados
    if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $nome = "";
    $cpf = "";
    $email = "";
    $fone = "";

    $result = pg_query($db, "select nome, cpf, fone, email from cliente where id = $id");

    if (pg_num_rows($result)>0) {
      while ($linha = pg_fetch_array($result)) {
        $nome  = $linha['nome'] ;
        $cpf   = $linha['cpf'] ;
        $fone  = $linha['fone'] ;
        $email = $linha['email'] ;
      }
    }
  }

   ?>
   

    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h2 class="text-center">Alterar Cliente</h2>
        <hr>
        <div class="row">
          <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1">
            <form method="post">
              <div class="form-group">
                <label for="nome">Nome*:</label>
                <input name="nome" value="<?php echo $nome ?>" type="text" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="cpf">CPF*:</label>
                <input name="cpf" value="<?php echo $cpf ?>" type="text" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="fone">Telefone*:</label>
                <input name="fone" value="<?php echo $fone ?>" type="text" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="email">E-mail*:</label>
                <input name="email" value="<?php echo $email ?>" type="text" class="form-control" required>
              </div>
              
              <input type="text" name="id_cli" value="<?php echo $id ?>" style="display: none;">
              <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
              <a class="btn btn-warning" href="listacliente.php">Voltar</a>
            </form>

            <br>

            <?php 
              if ($sucesso) {
                echo '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Sucesso!</strong> Cliente cadastrado com sucesso!
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