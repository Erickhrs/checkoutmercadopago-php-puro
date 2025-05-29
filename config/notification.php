<?php
include('conexao.php');
include('configApi.php');

$collector_id = $resultado_pedido['id_transacao'];

$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mercadopago.com/v1/payments/'.$collector_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'content-type: application/json',
        'Authorization: Bearer '.$access_token
    ),
    ));
    $response = curl_exec($curl);
    $resultado = json_decode($response);
    //var_dump($resultado);
curl_close($curl);

//TRATANDO O STATUS, GRAVE DA FORMA QUE ACHAR MELHOR
if($resultado->status == 'rejected'){
    $update = "UPDATE pedido SET
        status  = 'cancelado'
    WHERE id_transacao = '".$collector_id."'";
    mysqli_query($conexao, $update);
}
if($resultado->status == 'approved'){
    $update = "UPDATE pedido SET
        status  = 'aprovado'
    WHERE id_transacao = '".$collector_id."'";
    mysqli_query($conexao, $update);
}
?>