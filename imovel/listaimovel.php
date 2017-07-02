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
            <h2 class="text-center">Imóveis Cadastrados</h2>
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
                <a href="novoimovel.php" class="btn btn-primary">Novo Imovel</a>
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Titulo Imovel</th>
                      <th>Vagas Garagem</th>
                      <th>Número de Quartos</th>
                      <th>Valor Aluguel</th>
                      <th>Locado</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

              //Deletar Dados
                    if (isset($_GET['deleta'])) {
                      $id = $_GET['deleta'];

                      pg_query($db, "delete from proprietario_imovel where id_imovel = $id ");
                      pg_query($db, "delete from alugados where id_imovel = $id ");
                      pg_query($db, "delete from imovel where id = $id");

                    }

              //Consulta tabela de usuários
                    if ((isset($_REQUEST['buscar'])) && (trim($_POST["cpoBusca"]) != "")) {
                      $busca = ($_POST["cpoBusca"]);

                      $result = pg_query($db, "select id, titulo_imovel, nro_vagas_garagem, nro_dormitorios, valor_aluguel, locado from imovel where titulo_imovel like '%$busca%'");
                    }else{
                      $result = pg_query($db, "select id, titulo_imovel, nro_vagas_garagem, nro_dormitorios, valor_aluguel, locado from imovel");
                    }

                    if (pg_num_rows($result)>0) {
                      while ($linha = pg_fetch_array($result)) {
                        
                        if (!$linha['locado']) {
                          $locado = "<span class='label label-success'>Sim</span>";
                        }else{
                          $locado = "<span class='label label-danger'>Não</span>";
                        }
                        echo  "<tr>".
                        "<td>".$linha['id'] ."</td>".
                        "<td>".$linha['titulo_imovel']."</td>".
                        "<td>".$linha['nro_vagas_garagem']."</td>".
                        "<td>".$linha['nro_dormitorios']."</td>".
                        "<td>".$linha['valor_aluguel']."</td>".
                        "<td>".$locado."</td>".
                        "<td><a href='listaimovel.php?deleta=".$linha['id']."' title=''><span class='btn btn-danger glyphicon glyphicon-trash'></span></a> &nbsp; &nbsp; <a href='alterarimovel.php?id=".$linha['id']."' title=''><span class='btn btn-warning glyphicon glyphicon-pencil'></span></a></td>".
                        "</tr>";
                      }
                    }else{
                      echo  "<tr>".
                      "<td colspan='5' class='text-center text-danger'>Sem Imoveis!</td>".
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

      <!-- Scripts -->
      <?php include("../base/scriptsinterno.php"); ?>
    </body>

    </html>