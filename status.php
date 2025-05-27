<?php 
include('config/conexao.php');
include('config/configApi.php');
$sql_pedido = mysqli_query($conexao,"SELECT * FROM pedido WHERE id = '".$_GET['id']."'") or die("Erro");
$resultado_pedido	= mysqli_fetch_assoc($sql_pedido);
if($resultado_pedido['status'] == 'aprovado'){
    echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=https://".$host_dir."/obrigado.php?id=".$resultado_pedido['id']."'>";
}
?>