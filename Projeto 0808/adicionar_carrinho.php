<?php
// Exibir mensagens de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se a sessão do carrinho existe, se não, crie-a
    if (!isset($_SESSION['produto_prod'])) {
        $_SESSION['produto_prod'] = array();
    }

    // Receba os dados do produto do formulário
    $codproduto = $_POST['codproduto'];
    $nomeprod = $_POST['nomeprod'];
    $precoprod = $_POST['precoprod'];

    // Adicione o produto ao carrinho
    $_SESSION['produto_prod'][$codproduto] = array(
        'codproduto' => $codproduto,
        'nomeprod' => $nomeprod,
        'precoprod' => $precoprod,
        'quantidade' => 1 // Adicionei a quantidade como 1, você pode ajustar conforme necessário
    );

    // Mensagem de confirmação
    echo "Produto adicionado ao carrinho! <a href='carrinhodecompras.php'>Ir para o carrinho.</a>";
    exit();
}
?>