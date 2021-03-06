<?php 
header( 'Cache-Control: no-cache' );
header( 'Content-type: application/xml; charset="utf-8"', true );

require '../conecta.php';

$tipo_imovel = $_GET['tipo_imovel'];

$imoveis = array();

$result = pg_query($db, " select distinct".
						" i.id, ".
						" titulo_imovel ".
						" from imovel as i ".
						" inner join proprietario_imovel as pi ". //Somente lista os imóveis se tiver um proprietario
    					" on pi.id_imovel = i.id ".
						" where id_tipo_imovel = $tipo_imovel ". // E se não estiver locado
						" 		and locado = false");

if (pg_num_rows($result)>0) {
	while ($linha = pg_fetch_array($result)) {
		$imoveis[] = array(
			'id'			=> $linha['id'],
			'titulo_imovel'	=> $linha['titulo_imovel'],
		);
	}
}

echo( json_encode( $imoveis ) );

?>