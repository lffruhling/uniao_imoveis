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

  <div id="wrapper">
    <?php include('../base/menu.php') ?>
    <?php
    require '../conecta.php';

    if(!$_SESSION['login']){
      header('Location:index.php');
    }
    if(isset($_GET['sair'])){
      session_unset();
      session_destroy();
      header('Location:index.php');
    }
    
    ?>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">


          <div class="container lista">
            <h2 class="text-center">Proprietários Cadastrados</h2>
            <hr>
            <div class="row">
              <div class="col-lg-10 col-lg-push-1 col-md-10 col-md-push-1">
                <div class="col-lg-6 col-md-5 pull-right">
                  <form method="post" accept-charset="utf-8">
                    <div class="input-group">
                      <input type="text" name="cpoBusca" class="form-control" placeholder="Pesquisar...">
                      <span class="input-group-btn">
                        <button class="btn btn-default" name="buscar" type="submit">Buscar</button>
                      </span>
                    </div><!-- /input-group -->
                  </form>
                </div>
                <br>
                <a href="novoprop.php" class="btn btn-primary">Novo Proprietário</a>
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>CPF</th>
                      <th>Telefone</th>
                      <th>email</th>
                      <th>Imóveis</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

              //Deletar Dados
                    if (isset($_GET['deleta'])) {
                      $id = $_GET['deleta'];

                      pg_query($db, "delete from proprietario_imovel where id_proprietario = $id");
                      pg_query($db, "delete from proprietario where id = $id");
                    }

              //Consulta tabela de usuários
                    if ((isset($_REQUEST['buscar'])) && (trim($_POST["cpoBusca"]) != "")) {
                      $busca = ($_POST["cpoBusca"]);

                      $result = pg_query($db, "select id, nome, cpf, fone, email from proprietario where nome like '%$busca%' or cpf like '%$busca%' or fone like '%$busca%' or email like '%$busca%'");
                    }else{
                      $result = pg_query($db, "select id, nome, cpf, fone, email from proprietario");
                    }

                    if (pg_num_rows($result)>0) {
                      while ($linha = pg_fetch_array($result)) {
                        echo  "<tr>".
                        "<td>".$linha['id'] ."</td>".
                        "<td>".$linha['nome']."</td>".
                        "<td>".$linha['cpf']."</td>".
                        "<td>".$linha['nome']."</td>".
                        "<td>".$linha['email']."</td>".
                        "<td><a href='adicionarimovel.php?proprietario=".$linha['id']."' title=''><span class='btn btn-primary glyphicon glyphicon-plus'></span></a></td>".
                        "<td><a href='listaprop.php?deleta=".$linha['id']."' title=''><span class='btn btn-danger glyphicon glyphicon-trash'></span></a> &nbsp; &nbsp; <a href='alterarprop.php?id=".$linha['id']."' title=''><span class='btn btn-warning glyphicon glyphicon-pencil'></span></a></td>".
                        "</tr>";
                      }
                    }else{
                      echo  "<tr>".
                      "<td colspan='5' class='text-center text-danger'>Sem Proprietários!</td>".
                      "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <?php include("../base/scriptsinterno.php"); ?>
</body>
</html>