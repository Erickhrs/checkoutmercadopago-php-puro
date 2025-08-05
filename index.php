<?php
include('./config/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Checkout Mercado Pago</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" href="./assets/favicon3.svg" type="image/svg+xml">

    <!-- Custom Style -->
    <style>
        body {
            background-color: #f4fdf4;
            font-family: Arial, sans-serif;
            color: rgb(235, 57, 57);
        }

        .header {
            background-color: #ffffff;
            border-bottom: 2px solid #2e7d32;
            padding: 1rem;
            text-align: center;
        }

        .header img {
            height: 60px;
        }

        .container {
            margin-top: 40px;
            max-width: 500px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            display: flex !important;
            flex-direction: column !important;
        }

        .btn-success {
            background-color: rgb(190, 54, 54);
            border-color: rgb(255, 255, 255);
        }

        .btn-success:hover {
            background-color: rgb(255, 255, 255);
            border-color: rgb(255, 44, 44);
            color: red;
        }

        .note {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .hide {
            display: none !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="./assets/logo_blue_dark.svg" alt="Logo" style="width: 250px;margin:auto;padding-bottom:35px;">
        <h4 class="text-center mb-4" style="padding-bottom:15px;">Iniciar Processo de compra</h4>
        <form action="gravar.php" method="POST" id="checkoutForm">
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="total" value="19.99" placeholder="Valor total" readonly>
            </div>
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="desconto" value="0" placeholder="Desconto" readonly>
            </div>
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>" placeholder="Email" readonly>
            </div>

            <div class="mb-3 hide">
                <input type="text" class="form-control" name="id_user" value="<?php echo (int)($_GET['id_user'] ?? 0); ?>" placeholder="ID do Usuário" readonly>
            </div>

            <div class="mb-3" style="padding-bottom:15px;">
                <input type="text" class="form-control" name="cupom" placeholder="Insira seu cupom de Desconto" autocomplete="off">
            </div>
            <div class="d-grid">
                <input type="submit" class="btn btn-success" name="btngerar" value="Iniciar">
            </div>
        </form>
    </div>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevenir envio padrão

            const form = this;
            const cupomInput = form.querySelector('input[name="cupom"]');
            const descontoInput = form.querySelector('input[name="desconto"]');
            const totalInput = form.querySelector('input[name="total"]');

            const cupomCode = cupomInput.value.trim();

            if (cupomCode) {
                try {
                    const response = await fetch('https://api.futuroacs.com.br/api/cupom/validate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer SEU_TOKEN_AQUI' // Troque pelo token válido
                        },
                        body: JSON.stringify({ code: cupomCode }),
                    });

                    const data = await response.json();

                    if (!response.ok || !data.valid) {
                        alert(data.message || 'Cupom inválido');
                        return; // Cancela envio
                    }

                    // Calcular desconto
                    let desconto = 0;
                    if (data.cupom.discount_type === 'percent') {
                        desconto = (parseFloat(totalInput.value) * parseFloat(data.cupom.discount_value)) / 100;
                    } else if (data.cupom.discount_type === 'fixed') {
                        desconto = parseFloat(data.cupom.discount_value);
                    }
                    desconto = desconto.toFixed(2);

                    descontoInput.value = desconto;

                    // Opcional: ajustar total se quiser mostrar
                    // totalInput.value = (parseFloat(totalInput.value) - desconto).toFixed(2);

                    form.submit();

                } catch (error) {
                    alert('Erro ao validar o cupom. Tente novamente.');
                    console.error(error);
                }
            } else {
                // Sem cupom, enviar form normalmente
                form.submit();
            }
        });
    </script>

</body>

</html>
