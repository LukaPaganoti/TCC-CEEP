<?php
/* carrinho de compra */
if ( session_status() !== PHP_SESSION_ACTIVE )
 {
    session_start();
}
include_once 'conexao.php';
include_once 'funcaoData.php';

$pdo = conectar();

if(!isset($_SESSION['carrinho'])){
	$_SESSION['carrinho'] = array();
} 

if(isset($_GET['acao'])){

	if($_GET['acao'] == 'add'){
		$id = intval($_GET['id']);
		if(!isset($_SESSION['carrinho'][$id])){
			$_SESSION['carrinho'][$id] = 1;
		} else {
			$_SESSION['carrinho'][$id] += 1;
		}
	}

	if($_GET['acao'] == 'del'){
		$id = intval($_GET['id']);
		if(isset($_SESSION['carrinho'][$id])){
			unset($_SESSION['carrinho'][$id]);
		}
	} 

	if($_GET['acao'] == 'up' && count($_SESSION['carrinho']) != 0){
		if(is_array($_POST['prod'])){
			foreach($_POST['prod'] as $id => $qtd){
				$id = intval($id);
				$qtd = intval($qtd);
				if(!empty($qtd) || $qtd <> 0){
					$_SESSION['carrinho'][$id] = $qtd;
				}else{
					unset($_SESSION['carrinho'][$id]);
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
	<h2>Carrinho de Compras</h2>
	<table>
		
		<thead>
			<tr>
				<th width="240">Produto</th>
				<th width="79">Quantidade</th>
				<th width="89">Pre&ccedil;o</th>
				<th width="100">SubTotal</th>
				<th width="64">Remover</th>
			</tr>
		</thead>
		<form action="?acao=up" method="post">
		<tfoot>
			<tr>
				<td colspan="5">
					<input type="submit" value="Atualizar Carrinho" class="btn btn-warning" />
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<a class="btn btn-primary" href="lista_produto.php">Continuar Comprando</a>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<input  class="btn btn-info" type="submit" name="finalizaVenda" value="Finaliza Venda" />
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if(count($_SESSION['carrinho']) == 0){
				echo '
				<tr>
					<td colspan="5">Não há produto no carrinho</td>
				</tr>
				
				';
			} else {
				$total = 0;
				$i = 0;
				foreach($_SESSION['carrinho'] as $id => $qtd){
					$sql = "SELECT * FROM tb_produto WHERE idproduto = :id";
					$stmt = $pdo->prepare($sql);
					$stmt->bindValue(":id", $id);
					$stmt->execute();
					$rp = $stmt->fetch(PDO::FETCH_ASSOC);
					$produto = $rp['descricao'];
					$estoque = $rp['estoque'];
					$preco = number_format($rp['preco'], 2, ',', '.');
					$sub = number_format($rp['preco'] * $qtd, 2, ',', '.');
					$total += $rp['preco'] * $qtd;
					$itens[$i] = array(
						"produto" => $rp['idproduto'],
						"quantidade" => $qtd,
						"preco_unitario" => $preco,
						"preco_total" => $sub);
					$_SESSION['valor_total'] = $total;
					$i++;
					echo '
					<tr>
						<td>'.$produto.'</td>
						<td>
							<input type="text" size="3" name="prod['.$id.']" value="'.$qtd.'" />
						</td>
						<td>R$ '.$preco.'</td>
						<td>R$ '.$sub.'</td>
						<td><a href="?acao=del&id='.$id.'"><img src="img/lixo.png" width="30px" heigth="30px"></a></td>
					</tr>';
				}
				$total = number_format($total, 2, ',', '.');

				echo '
				<tr>
					<td colspan="3">Total</td>
					<td>R$ '.$total.'</td>
				</tr>';
			} ?>
		</tbody>
	</form>
</table>
</body>
</html>
<?php 
if (isset($_POST['finalizaVenda'])){

	$cliente = $_SESSION['id'];
	$valor_total = $_SESSION['valor_total'];
	$dia = new DateTime(); 
	$data =  $dia->format('Y-m-d');
	$observacao = " Observação ";
	echo $cliente." - ". $valor_total." - ". $data." - ". $observacao;

	$sql = "INSERT INTO tb_vendas(data_v, valor_total, cliente, observacao) VALUES(:d, :v, :c, :o)";

	$stmip = $pdo->prepare($sql);
	$stmip->bindValue(":d", $data);
	$stmip->bindValue(":c", $cliente);
	$stmip->bindValue(":v", $valor_total);
	$stmip->bindValue(":o", $observacao);

	if($stmip->execute()){
		echo "Venda inserida com sucesso";
	}else{
		echo "Ocorreu um erro ao inserir";
	}

	$venda = $pdo->lastInsertId();

	foreach ($itens as $v) {

		$sqlit = "INSERT INTO tb_itens_venda VALUES (:v, :p, :q, :pp, :pt)";

		$stmit = $pdo->prepare($sqlit);
		$stmit->bindValue(":v", $venda);
		$stmit->bindValue(":p", $v['produto']);
		$stmit->bindValue(":q", $v['quantidade']);
		$stmit->bindValue(":pp", $v['preco_unitario']);
		$stmit->bindValue(":pt", $v['preco_total']);

		$stmit->execute();
	}

	//var_dump($_SESSION);
	// nas linhas abaixo escolha quais sessões vc quer excluir.
	unset($_SESSION['carrinho']); // apaga sessão do carrinho
	unset($_SESSION['valor_total']); // apaga o valor total da venda
	//unset($_SESSION['usuario']);  // apaga o usuario logado
	//unset($_SESSION['admin']);  // apaga se o usuario é admin ou não
}

?>