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

          $imovel   = (Integer)$_POST['imovel'];
          
          $cliente   = (Integer)$_POST['cliente'];
          $data_loc   = $_POST['terminaLocacao'];
          $valor      = (Double)$_POST['valorAdicional'];

          // Retorno da operação;
        $retorno = pg_query($db, "INSERT INTO alugados (id_cliente, id_imovel, tempo_locacao, valor_adicional) VALUES ($cliente, $imovel,'$data_loc',$valor)");
          if ($retorno) {
            $sucesso = true;
            pg_query($db, "update imovel set locado = 'true' where id = $imovel");
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
            <h2 class="text-center">Alugar Imóvel</h2>
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

                  <div class="form-group">
                    <label for="cliente">Cliente*:</label>
                    <select class="form-control" name="cliente" required>
                      <option selected disabled >Selecione um cliente ...</option>";
                      <?php 
                        $result = pg_query($db, "select * from cliente");

                        if (pg_num_rows($result)>0) {
                          while ($linha = pg_fetch_array($result)) {
                            echo  "<option value='".$linha['id'] ."'>".$linha['nome'] ."</option>";
                          }
                        }
                       ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="terminaLocacao">Termino da Locação*:</label>
                    <input type="text" class="form-control" name="terminaLocacao" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="valorAdicional">Valor Adicional:</label>
                    <input type="number" class="form-control" name="valorAdicional" step="0.01">
                  </div>
                  
                  <button type="submit" name="cadastrar" class="btn btn-success">Salvar</button>
                </form>
                <br>

                <?php 
                  if ($sucesso) {
                    echo '<div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong>Sucesso!</strong> Imóvel alugado com sucesso!
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
<script type="text/javascript">
  $(function(){
    $('#tipo_imovel').change(function(){

      if( $(this).val() ) {
        $('#imovel').hide();
        $('.carregando').show();
        $.getJSON('../ajax/imoveis.ajax.php?search=',{tipo_imovel: $(this).val(), ajax: 'true'}, function(j){
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