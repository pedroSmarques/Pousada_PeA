<?php
$dbHost='localhost';
$dbUsername='root';
$dbPassword='';
$dbName='pousada';
$conexao=new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

if ($conexao->connect_errno) {
    die("Erro na conexão: " . $conexao->connect_error);
}
?>