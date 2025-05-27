<?php
ini_set('log_errors', 'Off');
ini_set('display_errors', 'Off');

$servername = "localhost";
$username   = "";
$password   = "";
$db_name    = "";

$conexao = mysqli_connect($servername, $username, $password, $db_name);

//ESSA CONSULTA É PASSADA PARA VERIFICAR STATUS E ENVIAR O VALOR DA COMPRA PARA O PROCESSA.PHP
$sql_pedido = mysqli_query($conexao,"SELECT * FROM pedido WHERE id = '".$_GET['id']."'") or die("Erro");
$resultado_pedido	= mysqli_fetch_assoc($sql_pedido);

$valor      = number_format($resultado_pedido['valor'], 2, '.', '');
$desconto   = number_format($resultado_pedido['desconto'], 2, '.', '');
$total      = number_format($valor - $desconto, 2, '.', '');
?>