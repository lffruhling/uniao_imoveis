<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>União Imóveis</title>

    <!-- Estilos -->
    <?php include("base/estilos.php"); ?>

    <style type="text/css">
        .form-signin {
            margin: auto;
            width: 400px;
            padding: 15px;
            margin-top: 12%;
        }
    </style>
</head>

<body>

        <?php 
            require 'conecta.php';
            
            if (isset($_POST['entrar'])) {
                if (isset($_COOKIE['usuario']) && isset($_POST['senha'])){
                    $login = $_COOKIE['usuario'];
                    $senha = $_POST['senha'];
                    $acesso=0;
                        
                    //Consulta tabela de usuários
                    $result = pg_query($db, "select nome from usuario where usuario = '$login' and senha = '$senha'");

                    if (pg_num_rows($result)>0) {
                        while ($linha = pg_fetch_array($result)) {
                            setCookie('usuario',$login);
                            session_start();
                            $_SESSION['login'] = $linha['nome'];
                            // $_SESSION['senha'] = $linha['senha'];
                            // $_SESSION['tipo'] = $linha['nivel_acesso']   ;
                            // $_SESSION['link'] = $linha['foto'];
                            header('Location:listaAlugados.php');
                        }

                    }else{
                        header('Location:index.php?erro=erro');
                    }
                }
                
                if (isset($_POST['login']) && isset($_POST['senha'])){
                    $login = $_POST['login'];
                    $senha = $_POST['senha'];
                    $acesso=0;
                        
                    //Consulta tabela de usuários
                    $result = pg_query($db, "select * from usuario where usuario = '$login' and senha = '$senha'");

                    if (pg_num_rows($result)>0) {
                        while ($linha = pg_fetch_array($result)) {
                            setCookie('usuario',$login);
                            session_start();
                            $_SESSION['login'] = $linha['nome'];
                            // $_SESSION['senha'] = $linha['senha'];
                            // $_SESSION['tipo'] = $linha['nivel_acesso']   ;
                            // $_SESSION['link'] = $linha['foto'];
                            header('Location:listaAlugados.php');
                        }

                    }else{
                        header('Location:index.php?erro=erro');
                    }
                }
            }
         ?>


    <div class='container'>
        <form class="form-signin" method="post">
            <h2 class="form-signin-heading text-center text-primary">Realize seu Login</h2>
            <br>
            <label for="inputLogin" class="sr-only">Login</label>
            <?php 
                if(isset($_GET['user'])){
                    setCookie('usuario');
                    echo '<input type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus name="login">';
                }else{
                
                    if(isset($_COOKIE['usuario']) && ($_COOKIE['usuario'] != "")){
                        $user = $_COOKIE['usuario'];
                        echo "<input type='text' id='inputLogin' class='form-control' placeholder='Login' name='login' value='".$user."' disabled>";
                    }else{
                        echo '<input type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus name="login">';
                    }
                }
            ?>
            
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required="" name='senha'>
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me"> Lembre-se de mim
              </label>
              
              <a class="btn btn-primary pull-right" href="index.php?user=user"> Alterar Usuário</a>
              <br>
              <br>
            </div>
            
            <?php
            if(isset($_GET['erro'])){
                echo '<div class="alert alert-danger alert-dismissable"><a href="index.php" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Cuidado!</strong> Senha e/ou Login incorretos.</div>';
            }
            ?>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="entrar">Entrar</button>
          </form>
 

    <!-- Scripts -->
    <?php include("base/scripts.php"); ?>

</body>

</html>