<?php
function conectar()
{

    $host = 'localhost';
    $db = 'studiosbentcc';
    $user = 'aluno';
    $password = 'ceep';

    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    return $pdo;
}