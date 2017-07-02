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
  <?php include("../base/menu.php") ?>

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

      $id_tipo_imovel = (Integer)$_POST['tipo_imovel'];
      $titulo_imovel  = $_POST['titulo'];
      $descricao      = $_POST['descricao'];
      $vagas_garagem  = (Integer)$_POST['garagem'];
      $nro_quartos    = (Integer)$_POST['quartos'];
      $valor_aluguel  = (Float)$_POST['valor'];
      
      // Retorno da operação;
    $retorno = pg_query($db, "INSERT INTO imovel (id_tipo_imovel, titulo_imovel, descricao, nro_vagas_garagem, nro_dormitorios, valor_aluguel, locado) VALUES ($id_tipo_imovel, '$titulo_imovel', '$descricao', $vagas_garagem, $nro_quartos, $valor_aluguel, 'false')");
      if ($retorno) {
        $sucesso = true;
      }else{
          echo '<div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Erro!</strong> Erro Cadastrar Imóvel!'.$retorno.'
                      </div>' ;
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
                <label for="titulo">Título Imóvel*:</label>
                <input type="text" class="form-control" name="titulo" required>
              </div>

                <!-- depois fazer um text área -->
              <div class="form-group">
                <label for="descricao">Descricao:</label>
                <input type="text" class="form-control" name="descricao">
              </div>

              <div class="form-group">
                <label for="garagem">Vagas de Garagem:</label>
                <input type="number" class="form-control" name="garagem">
              </div>

              <div class="form-group">
                <label for="quartos">Número de Quartos:</label>
                <input type="number" class="form-control" name="quartos" >
              </div>

              <div class="form-group">
                <label for="valor">Valor do Aluguel:</label>
                <input type="number" class="form-control" name="valor" step="0.01" >
              </div>
              
              <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
            </form>

            <br>
            

            <?php 
              if ($sucesso) {
                echo '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Sucesso!</strong> Imóvel cadastrado com sucesso!
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