<?php

	require "class/Produto.php";

	$produto = new Produto();
	$produto->setPreco(59.9);
	$produto->setNome("Livro da Casa do Codigo");

	$outroProduto = new Produto();
	$outroProduto->setPreco(59.9);
	$outroProduto->setNome("Livro da Casa do Codigo");

	$outroProduto = $produto;

	if ($produto === $outroProduto) {
		echo "sao iguais";
	} else {
		echo "sao diferentes";
	}

?>