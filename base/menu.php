<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Navegação</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/uniao_imoveis"><img src="/uniao_imoveis/assets/img/logo_hor.png" style="height: 46px; margin-top: -12px"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>
                        <?php 
                          session_start();
                          echo $_SESSION['login']; 
                        ?>
                         <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li style="height: 35px" class="text-center"> <h4>Navegação</h4></li>

                        <li>
                            <a href="teste"><i class="fa fa-credit-card-alt fa-fw"></i> Aluguéis<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/uniao_imoveis/aluguel/cadastrar.php">Cadastrar Aluguel</a>
                                    <a href="/uniao_imoveis/listaAlugados.php">Listar Aluguéis</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="imoveis"><i class="fa fa-home fa-fw"></i> Imóveis<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/uniao_imoveis/imovel/novoimovel.php">Cadastrar Imóvel</a>
                                    <a href="/uniao_imoveis/imovel/listaimovel.php">Listar Imóveis</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="imoveis"><i class="fa fa-users fa-fw"></i> Clientes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/uniao_imoveis/cliente/novocliente.php">Cadastrar Cliente</a>
                                    <a href="/uniao_imoveis/cliente/listacliente.php">Listar Clientes</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="imoveis"><i class="fa fa-users fa-fw"></i> Proprietários<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/uniao_imoveis/proprietario/novoprop.php">Cadastrar Proprietário</a>
                                    <a href="/uniao_imoveis/proprietario/listaprop.php">Listar Proprietários</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="index.html"><i class="fa fa-user fa-fw"></i> Usuários</a>
                        </li>

                        <li>
                            <a href="tipoimovel"><i class="fa fa-list fa-fw"></i> Tipos de Imóveis<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/uniao_imoveis/tipoimovel/novotipo.php">Cadastrar Tipo</a>
                                    <a href="/uniao_imoveis/tipoimovel/listatipos.php">Listar Tipos</a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>