<?php
	include('../includeConstantes.php');
	$data['token'] = '2BF7D55F980F4B8FB73F489AA770AEAC';
	$data['email'] = 'leonardopessoa799@gmail.com';
	$data['currency'] = 'BRL';
	$data['notificationURL'] = "http://localhost/curso-web-master/back_end/projetos/projeto_01/retorno.php";
	$data['reference'] = uniqid();
	$index = 1;
	$itemsCarrinho = $_SESSION['carrinho'];

	foreach($itemsCarrinho as $key => $value){
		$idProduto = $key;
		$produto = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE `id` = $idProduto");
		$produto->execute();
		$produto = $produto->fetch();
		$valor = $produto['preco'];
		$data["itemId$index"] = $index;
		$data["itemQuantity$index"] = $value;
		$data["itemDescription$index"] = $produto['nome'];
		$data["itemAmount$index"] = number_format($produto['preco'], 2, '.', '');
		$index++;
	}

	$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout";
	$data = http_build_query($data);

	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($curl,CURLOPT_POST,true);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	curl_setopt($curl,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
	$xml = curl_exec($curl);
	
	curl_close($curl);
	$xml = simplexml_load_string($xml);

	echo $xml->code;
