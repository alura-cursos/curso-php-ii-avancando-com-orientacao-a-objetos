<?php
require_once("cabecalho.php");

$produtoDao = new ProdutoDao($conexao);
$categoriaDao = new CategoriaDao($conexao);

$id = $_GET['id'];
$produto = $produtoDao->buscaProduto($id);
$categorias = $categoriaDao->listaCategorias();

$selecao_usado = $produto->isUsado() ? "checked='checked'" : "";
$produto->setUsado($selecao_usado);

?>

<h1>Alterando produto</h1>
<form action="altera-produto.php" method="post">
	<input type="hidden" name="id" value="<?=$produto->getId()?>">
	<table class="table">
		<?php include("produto-formulario-base.php"); ?>
		<tr>
			<td>
				<button class="btn btn-primary" type="submit">Alterar</button>
			</td>
		</tr>
	</table>
</form>

<?php include("rodape.php"); ?>