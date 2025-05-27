<?php
include('conexao.php');
include('configApi.php');
$json       = file_get_contents('php://input');
$result_request  = json_decode($json);
$caracteres = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
$filtrado   = str_shuffle($caracteres);
$codigoKey  = substr($filtrado, 0, 5).'-'.substr($filtrado, 0, 8).'-'.substr($filtrado, 0, 4);
$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
         "transaction_amount": '.floatval($total).',
         "token": "'.$result_request->token.'",
         "description": "'.$result_request->description.'",
         "installments": '.$result_request->installments.',
         "payment_method_id": "'.$result_request->payment_method_id.'",
         "issuer_id": '.$result_request->issuer_id.',
         "payer": {
           "email": "'.$result_request->payer->email.'"
         }
   }',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'content-type: application/json',
        'X-Idempotency-Key: '.$codigoKey,
        'Authorization: Bearer '.$access_token
    ),
    ));
    $response = curl_exec($curl);
    $resultado = json_decode($response);
    //var_dump($response);
    if($resultado->id <> ''){
        if($resultado->status == 'approved'){
            echo 'Pagamento Aprovado<br>';
            
            $update = "UPDATE pedido SET
                status          = 'aprovado',
                id_transacao    = '".$resultado->id."'
            WHERE id='".$_GET['id']."'";
            mysqli_query($conexao, $update);
        }
        if($resultado->status == 'rejected'){
            echo 'Pagamento Reprovado, tentar novamente <a href=""><b>Clicando aqui</b></a>.<br><br>';
            
            $update = "UPDATE pedido SET
                status          = 'rejeitado',
                id_transacao    = '".$resultado->id."'
            WHERE id='".$_GET['id']."'";
            mysqli_query($conexao, $update);
        }
        if($resultado->status == 'cancelled'){
            echo 'Pagamento Cancelado<br>';
            
            $update = "UPDATE pedido SET
                status          = 'cancelado',
                id_transacao    = '".$resultado->id."'
            WHERE id='".$_GET['id']."'";
            mysqli_query($conexao, $update);
        }
    } else {
        echo '<h4>Erro ao gerar transação, tente novamente!</h4><br>';
    }
curl_close($curl);
?>