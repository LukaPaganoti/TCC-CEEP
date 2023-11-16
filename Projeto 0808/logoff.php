<?php
//session_start();
include_once("conexao.php");

$pdo = conectar();
session_destroy();

header("Location: telainicial.php"); 
exit();
?>