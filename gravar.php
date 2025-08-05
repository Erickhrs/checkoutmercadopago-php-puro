<?php
include('./config/conexao.php');
include('./config/configApi.php'); // Se não usar, pode remover

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexao, $_POST['email'] ?? '');
    $id_user = (int)($_POST['id_user'] ?? 0);
    $total = 29.90; // Ou pegue $_POST['total'] se quiser
    $desconto = floatval($_POST['desconto'] ?? 0);
    $cupom_code = trim($_POST['cupom'] ?? '');

    // Verificar se email e id_user existem na tabela acsq_users
    $queryUser = "SELECT * FROM acsq_users WHERE email = '$email' AND id = $id_user LIMIT 1";
    $resultUser = mysqli_query($conexao, $queryUser);

    if (mysqli_num_rows($resultUser) > 0) {
        // Inserir pedido
        $sql = "INSERT INTO pedido(valor, desconto, status, id_user, email_user) VALUES('$total', '$desconto', 'pendente', $id_user, '$email')";

        if (mysqli_query($conexao, $sql)) {
            $id_pedido = mysqli_insert_id($conexao);

            // Se cupom informado, registrar o uso do cupom via API
            if (!empty($cupom_code)) {
                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.futuroacs.com.br/api/cupom/use',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode(['code' => $cupom_code]),
                    CURLOPT_HTTPHEADER => [
                        'Content-Type: application/json',
                        'Authorization: Bearer SEU_TOKEN_AQUI', // Troque pelo token válido
                    ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err) {
                    error_log("Erro ao registrar uso do cupom: $err");
                }
                // Pode tratar resposta se quiser
            }

            // Redirecionar para página de pagamento
            header("Location: https://" . $host_dir . "/pagamento.php?id=" . $id_pedido);
            exit;
        } else {
            echo "Erro ao criar pedido: " . mysqli_error($conexao);
        }
    } else {
        // Usuário não encontrado
        echo "<div style='color:red; font-weight:bold; text-align:center; margin-top:50px;'>";
        echo "Erro: Usuário não encontrado na base de dados.";
        echo "</div>";
    }
} else {
    echo "Método inválido.";
}
?>
