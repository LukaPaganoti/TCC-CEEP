<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se a sessão do carrinho existe, se não, crie-a
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = array();
    }

    // Receba os dados do produto do formulário
    $codproduto = $_POST['codproduto'];
    $nomeprod = $_POST['nomeprod'];
    $precoprod = $_POST['precoprod'];

    // Adicione o produto ao carrinho
    $_SESSION['carrinho'][] = array(
        'codproduto' => $codproduto,
        'nomeprod' => $nomeprod,
        'precoprod' => $precoprod
    );

    // Redirecione de volta à página de produtos
    header("Location: produtos.php");
    exit();
}
?>