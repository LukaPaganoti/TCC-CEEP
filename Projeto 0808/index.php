<?php
session_start();
require_once "conexao.php";

$pdo = conectar();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Adicionando estilo extra para o QR Code -->
    <style>
        #qrcode {
            margin-top: 20px;
            max-width: 100%;
        }
    </style>

    <title>Código PIX</title>
</head>
<body>
    <div class="container">
        <h1>Código PIX</h1>

        <?php
        // Função para gerar o código PIX
        function gerarCodigoPix($valor, $chavePix, $nomeBeneficiario, $infoAdicional = '')
        {
            // Lógica para gerar o código PIX (use a biblioteca que preferir)
            // Aqui, estou usando um exemplo simples para fins de demonstração
            $payload = '00020126580014br.gov.bcb.pix0112' . $chavePix . '520400005303986540410.00';

            // Use uma biblioteca apropriada para gerar o QR Code
            // Aqui, estou usando a biblioteca BaconQrCode (instalada via Composer)
            require 'vendor/autoload.php';

            // Crie um objeto QR Code
            $qrCode = new Endroid\QrCode\QrCode($payload);

            // Exiba o QR Code
            echo '<img id="qrcode" src="' . $qrCode->getDataUri() . '" alt="Código PIX">';
        }

        // Dados para o PIX
        $valor = ''; // Valor da transação
        $chavePix = 'bendrownedstudios@gmail.com'; // Chave PIX do recebedor
        $nomeBeneficiario = 'Luiza Maria Paganoti Farias'; // Nome do recebedor
        $infoAdicional = 'Pagamento da sua compra em STUDIOSBEN'; // Informação Adicional

        // Chame a função para gerar o código PIX
        gerarCodigoPix($valor, $chavePix, $nomeBeneficiario, $infoAdicional);
        ?>
    </div>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>