<?php 

class ProdutoDao {

	private $conexao;

	function __construct($conexao) {
		$this->conexao = $conexao;
	}

	function listaProdutos() {

		$produtos = array();
		$resultado = mysqli_query($this->conexao, "select p.*,c.nome as categoria_nome 
			from produtos as p join categorias as c on c.id=p.categoria_id");

		while($produto_array = mysqli_fetch_assoc($resultado)) {

			$categoria = new Categoria();
			$categoria->setNome($produto_array['categoria_nome']);

			$nome = $produto_array['nome'];
			$descricao = $produto_array['descricao'];
			$preco = $produto_array['preco'];
			$usado = $produto_array['usado'];
			$isbn = $produto_array['isbn'];
			$tipoProduto = $produto_array['tipoProduto'];

			if ($tipoProduto == "Livro") {
				$produto = new Livro($nome, $preco, $descricao, $categoria, $usado);
				$produto->setIsbn($isbn);
			} else {
				$produto = new Produto($nome, $preco, $descricao, $categoria, $usado);
			}

			$produto->setId($produto_array['id']);

			array_push($produtos, $produto);
		}

		return $produtos;
	}

	function insereProduto(Produto $produto) {

		$isbn = "";
		if ($produto->temIsbn()) {
			$isbn = $produto->getIsbn();
		}

		$tipoProduto = get_class($produto);

		$query = "insert into produtos (nome, preco, descricao, categoria_id, 
			usado, isbn, tipoProduto) values ('{$produto->getNome()}', 
				{$produto->getPreco()}, '{$produto->getDescricao()}', 
					{$produto->getCategoria()->getId()}, {$produto->isUsado()}, 
						'{$isbn}', '{$tipoProduto}')";

		return mysqli_query($this->conexao, $query);
	}

	function alteraProduto(Produto $produto) {

		$isbn = "";
		if ($produto->temIsbn()) {
			$isbn = $produto->getIsbn();
		}

		$tipoProduto = get_class($produto);

		$query = "update produtos set nome = '{$produto->getNome()}', 
			preco = {$produto->getPreco()}, descricao = '{$produto->getDescricao()}', 
				categoria_id= {$produto->getCategoria()->getId()}, 
					usado = {$produto->isUsado()}, isbn = '{$isbn}', 
						tipoProduto = '{$tipoProduto}' 
							where id = '{$produto->getId()}'";

		return mysqli_query($this->conexao, $query);
	}

	function buscaProduto($id) {

		$query = "select * from produtos where id = {$id}";
		$resultado = mysqli_query($this->conexao, $query);
		$produto_buscado = mysqli_fetch_assoc($resultado);

		$categoria = new Categoria();
		$categoria->setId($produto_buscado['categoria_id']);

		$nome = $produto_buscado['nome'];
		$descricao = $produto_buscado['descricao'];
		$preco = $produto_buscado['preco'];
		$usado = $produto_buscado['usado'];
		$isbn = $produto_buscado['isbn'];
		$tipoProduto = $produto_buscado['tipoProduto'];

		if ($tipoProduto == "Livro") {
			$produto = new Livro($nome, $preco, $descricao, $categoria, $usado);
			$produto->setIsbn($isbn);
		} else {
			$produto = new Produto($nome, $preco, $descricao, $categoria, $usado);
		}

		$produto->setId($produto_buscado['id']);

		return $produto;
	}

	function removeProduto($id) {

		$query = "delete from produtos where id = {$id}";

		return mysqli_query($this->conexao, $query);
	}
}

?>
