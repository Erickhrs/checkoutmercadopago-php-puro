<?php
include('./config/conexao.php');
include('./config/configApi.php'); // Se precisar, senão remova

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexao, $_POST['email'] ?? '');
    $id_user = (int)($_POST['id_user'] ?? 0);
    $total = 29.90;      // Ou pegue de $_POST['total'] se quiser
    $desconto = 0;       // Ou pegue de $_POST['desconto']

    // Verificar se email e id_user existem na tabela acsq_users
    $queryUser = "SELECT * FROM acsq_users WHERE email = '$email' AND id = $id_user LIMIT 1";
    $resultUser = mysqli_query($conexao, $queryUser);

    if (mysqli_num_rows($resultUser) > 0) {
        // Usuário existe, inserir pedido
        $sql = "INSERT INTO pedido(valor, desconto, status, id_user, email_user) VALUES('$total', '$desconto', 'pendente', $id_user, '$email')";

        if (mysqli_query($conexao, $sql)) {
            $id_pedido = mysqli_insert_id($conexao);
            // Redirecionar para página de pagamento
            header("Location: https://".$host_dir."/pagamento.php?id=".$id_pedido);
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
