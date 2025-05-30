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
            color:rgb(235, 57, 57);
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
            display: flex!important;
            flex-direction: column!important;
        }

        .btn-success {
            background-color:rgb(190, 54, 54);
            border-color:rgb(255, 255, 255);
        }

        .btn-success:hover {
            background-color:rgb(255, 255, 255);
            border-color:rgb(255, 44, 44);
            color:red;
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
        <form action="gravar.php" method="POST">
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="total" value="19.99" placeholder="Valor total">
            </div>
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="desconto" value="0" placeholder="Desconto">
            </div>
            <div class="mb-3 hide">
                <input type="text" class="form-control" name="email" value="<?php echo $_GET['email'] ?? ''; ?>"
                    placeholder="Email">
            </div>

            <div class="mb-3 hide">
                <input type="text" class="form-control" name="id_user" value="<?php echo $_GET['id_user'] ?? ''; ?>"
                    placeholder="ID do Usuário">
            </div>

            <div class="mb-3" style="padding-bottom:15px;">
                <input type="text" class="form-control" name="cupom" placeholder="Insira seu cupom de Desconto">
            </div>
            <div class="d-grid">
                <input type="submit" class="btn btn-success" name="btngerar" value="Iniciar">
            </div>
        </form>
    </div>
</body>

</html>