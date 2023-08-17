<?php
function conectar()
{

    $host = 'localhost';
    $db = 'studiosbentcc';
    $user = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    return $pdo;
}

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produto</title>
</head>
<body>
    <form action="./home.html">
        <p>Nome do produto</p>
        <input type="produtonome">
        <p>Preço do produto </p>
        <input type="preçoprod">
        <p>Tamanho do produto</p>
        <input type="tamanhoprod">
        <p>Peso do produto</p>
        <input type="pesoprod">
        <p>Descrição do produto</p>
        <input type="descricaoprod">
        <p>Selecione a categoria</p>
        <select name="categoriaprod">
            <optgroup label="Categorias">
             <option value="valor1">Quadros coloridos grandes</option>
            <option value="valor2">Quadros coloridos médio</option>
            <option value="valor3">Quadros coloridos pequenos</option>
            <option value="valor4">Quadros preto e branco grandes</option>
            <option value="valor5">Quadros preto e branco médio</option>
            <option value="valor6">Quadros preto e branco pequenos</option>
            <option value="valor7">Marca páginas coloridos</option>
            <option value="valor8">Marca páginas preto e branco</option>
            <option value="valor9">Chaveiros coloridos</option>
            <option value="valor10">Chaveiros preto e branco</option>
            </optgroup>
          </select>  
          <p>Imagens do produto</p>
          <input type="imagemprod">
        <p><input type="submit" value="Salvar"></p>
    </form>
</body>
</html>