<?php
include('config/conexao.php');
include('config/configApi.php');
//ATENCAO ESSE ARQUIVO É SÓMENTE PARA TESTES, NÃO É NECESSARIO USAR ELE EM SUA ARQUITETURA.
$total      = $_POST['total'];
$desconto   = $_POST['desconto'];

$sql="INSERT INTO pedido(valor, desconto, status) VALUES('".$total."', '".$desconto."', 'pendente')";
mysqli_query($conexao, $sql);
$id = mysqli_insert_id($conexao);
echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=https://".$host_dir."/pagamento.php?id=".$id."'>";
?>