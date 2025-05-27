<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout Mercado Pago</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <p>Atenção dev, essa pagina é apenas para teste. Você deverá colocar o checkout do pix dentro da sua arquitetura, puxando os dado de dentro da sua tabela de pedidos.</p>
    <div class="container">
    <form action="gravar.php" method="POST">
        <br>
        <b>Gerar venda</b>
        <input type="text" class="form-control" name="total" placeholder="Valor total">
        <br>
        <input type="text" class="form-control" name="desconto" placeholder="Desconto">
        <br>
        <input type="submit" class="btn btn-success" name="btngerar" value="Gerar venda">
    </form>
    </div>
</body>
</html>