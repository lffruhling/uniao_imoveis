<?php
	//Conexão com Base de Dados
	$db = pg_connect("host=localhost port=5432 dbname=uniao_imovel user=postgres password=1234");

	//Testa a conexão	
	if(!$db){
		echo "Erro ao conectar banco de dados";
		session_unset();
		session_destroy();
		die();
	}
?>
