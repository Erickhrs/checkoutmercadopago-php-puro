<?php include('conexao.php');?>
<?php include('configApi.php');?>
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <h4>Pagamento via PIX</h4>
        <p>Total a pagar R$ <?php echo number_format($total, 2, ',', '.');?></p>
        <hr>
        <?php
        $curl = curl_init();
            //Essas 3 variaveis sao para gerar um "token" randomico
            $caracteres = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ';
            $filtrado   = str_shuffle($caracteres);
            $codigoKey  = substr($filtrado, 0, 5).'-'.substr($filtrado, 0, 8).'-'.substr($filtrado, 0, 4);
            
            $dados["transaction_amount"]                    = floatval($total);
            $dados["description"]                           = "Compra online";
            $dados["external_reference"]                    = "2";
            $dados["payment_method_id"]                     = "pix";
            $dados["notification_url"]                      = 'https://'.$host_dir.'/config/notification.php?id='.$_GET['id'];
            $dados["payer"]["email"]                        = "test@gmail.com";
            $dados["payer"]["first_name"]                   = "Test";
            $dados["payer"]["last_name"]                    = "User";
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'X-Idempotency-Key: '.$codigoKey, //aqui fica o token randomico
                'Authorization: Bearer '.$access_token
            ),
            ));
            $response = curl_exec($curl);
            $resultado = json_decode($response);
            //var_dump($resultado);
            if($resultado->id <> ''){
                $update = "UPDATE pedido SET 
                    id_transacao    = '".$resultado->id."'
                WHERE id='".$_GET['id']."'";
                mysqli_query($conexao, $update);
            }
        curl_close($curl);
        ?>
        <?php if($resultado->id <> ''){ ?>
        <center>
            <img style='display:block; width:80%;' src='data:image/jpeg;base64, <?php echo $resultado->point_of_interaction->transaction_data->qr_code_base64;?>' />
            <hr>
            <button id="copyButton" class="btn btn-primary">Copiar linha do pix</button>
        </center>
        <?php } else { ?>
            <b>Erro ao gerar QRCODE, tente novamente.</b>
            <p>Se o erro persistir entre em contato com o administrador do site.</p>
        <?php } ?>
    </div>
</div>
<script>
document.getElementById('copyButton').addEventListener('click', function() {
    // O texto que queremos copiar
    var textToCopy = '<?php echo $resultado->point_of_interaction->transaction_data->qr_code;?>';

    // Usa a API Clipboard para copiar o texto
    navigator.clipboard.writeText(textToCopy).then(function() {
        alert('Pix copiado: ' + textToCopy);
    }).catch(function(error) {
        console.error('Erro ao copiar: ', error);
    });
});
</script>