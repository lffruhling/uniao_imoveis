<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>União Imóveis</title>

    <!-- Estilos -->
    <?php include("base/estilos.php"); ?>
</head>

<body>

    <div id="wrapper">
        <?php include('base/menu.php') ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                      require 'conecta.php';

                      if(!$_SESSION['login']){
                        header('Location:index.php');
                      }
                      if(isset($_GET['sair'])){
                        session_unset();
                        session_destroy();
                        header('Location:index.php');
                      }
                      
                    ?>

                      <div class="container" style="margin-left: 10px;     padding-top: 48px;">
                        <h2 class="text-center">Imóveis Alugados</h2>
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
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                <th>ID</th>
                                <th>Título Imóvel</th>
                                <th>Cliente</th>
                                <th>Proprietário</th>
                                <th>Termino da Locação</th>
                                <th>Valor Aluguel</th>
                                <th>Valor Adicional</th>
                                <th>Total Aluguel</th>
                                <th>Ação</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php 

                                //Deletar Dados
                                if (isset($_GET['deleta'])) {
                                  $id = $_GET['deleta'];
                                  $result = pg_query($db, "select id_imovel from alugados where id = $id");
                                  if (pg_num_rows($result)>0) {
                                    while ($linha = pg_fetch_array($result)) {
                                      $id_imovel = $linha['id_imovel'];
                                      pg_query($db, "update imovel set locado = 'false' where id = $id_imovel");

                                    }
                                  }

                                  pg_query($db, "delete from alugados where id = $id");
                                }

                                //Consulta tabela de usuários
                                if ((isset($_REQUEST['buscar'])) && (trim($_POST["cpoBusca"]) != "")) {
                                      $busca = ($_POST["cpoBusca"]);
                                      
                                      $result = pg_query($db, "select a.id, i.titulo_imovel, c.nome as cliente, p.nome as proprietario, a.tempo_locacao, i.valor_aluguel, a.valor_adicional".
                                                              " from alugados as a ".
                                                              "     left join imovel as i ".
                                                              "       on i.id = id_imovel ".
                                                              "     left join cliente as c ".
                                                              "       on c.id = id_cliente ".
                                                              "     left join proprietario_imovel as pi ".
                                                              "       on pi.id_imovel = i.id ".
                                                              "     left join proprietario as p ".
                                                              "       on p.id = pi.id_proprietario ".
                                                              " where i.titulo_imovel like '%$busca%' or c.nome like '%$busca%' or p.nome like '%$busca%'");
                                    }else{
                                      $result = pg_query($db, " select a.id, i.titulo_imovel, c.nome as cliente, p.nome as proprietario, a.tempo_locacao, i.valor_aluguel, a.valor_adicional".
                                                              " from alugados as a ".
                                                              "     left join imovel as i ".
                                                              "       on i.id = id_imovel ".
                                                              "     left join cliente as c ".
                                                              "       on c.id = id_cliente ".
                                                              "     left join proprietario_imovel as pi ".
                                                              "       on pi.id_imovel = i.id ".
                                                              "     left join proprietario as p ".
                                                              "       on p.id = pi.id_proprietario ");
                                    }

                                  if (pg_num_rows($result)>0) {
                                    while ($linha = pg_fetch_array($result)) {
                                      $total = $linha['valor_aluguel'] + $linha['valor_adicional'];
                                      echo  "<tr>".
                                            "<td>".$linha['id'] ."</td>".
                                            "<td>".$linha['titulo_imovel']."</td>".
                                            "<td>".$linha['cliente']."</td>".
                                            "<td>".$linha['proprietario']."</td>".
                                            "<td>".$linha['tempo_locacao']."</td>".
                                            "<td>".$linha['valor_aluguel']."</td>".
                                            "<td>".$linha['valor_adicional']."</td>".
                                            "<td>".$total."</td>".
                                            "<td><a href='listaAlugados.php?deleta=".$linha['id']."' title=''><span class='btn btn-danger glyphicon glyphicon-trash'></span></a></td>".
                                          "</tr>";
                                    }
                                  }else{
                                    echo  "<tr>".
                                            "<td colspan='5' class='text-center text-danger'>Sem Imóveis Alugados!</td>".
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
    </div>

 

    <!-- Scripts -->
    <?php include("base/scripts.php"); ?>

</body>

</html>