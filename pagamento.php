<?php include('config/conexao.php'); ?>
<?php include('config/configApi.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout de pagamento</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago("<?php echo $public_key; ?>");
    </script>
    <link href="config/css/style.css" rel="stylesheet">
    <link rel="icon" href="./assets/favicon3.svg" type="image/svg+xml">
</head>

<body>
    <div class="container">
        <br>
        <h1 class="h3 mb-5">Checkout de pagamento</h1>
        <div class="row">
            <div class="col-lg-3">
                <div class="card position-sticky top-0">
                    <div class="p-3 bg-light bg-opacity-10">
                        <h6 class="card-title mb-3">Detalhes do pedido</h6>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Subtotal</span>
                            <span>R$ <?php echo number_format($valor, 2, ',', '.'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>Descontos</span>
                            <span>R$ <?php echo number_format($desconto, 2, ',', '.'); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4 small">
                            <span>Total</span>
                            <strong class="text-dark">R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                        </div>
                        <div class="mb-1 small">
                            <p>O pagamento leva poucos segundos para ser liberado em nossa plataforma.</p>
                        </div>
                        <div class="mb-3 small">
                            <b style="color: green; font-size: 13px;">Você está em um ambiente seguro.</b>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <br>
            <div class="col-lg-9">
                <div class="accordion" id="accordionPayment">
                    <div class="accordion-item mb-3">
                        <?php include('config/blocos/cartao.php'); ?>
                    </div>
                    <div class="accordion-item mb-3 border">
                        <?php include('config/blocos/pix.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="status"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            var modal = $('#myModal');
            var closeModal = $('#closeModal');

            // When the user clicks the button, open the modal
            $('#openModal').click(function () {
                $.get('https://<?php echo $host_dir; ?>/config/gerar_pix.php?id=<?php echo $_GET['id']; ?>', function (data) {
                    $('#modalBody').html(data);
                    modal.show();

                    // Enable closing the modal after 1 minute
                    setTimeout(function () {
                        closeModal.show();
                    }, 5000); // 60000 milliseconds = 1 minute
                });
            });

            // Close the modal when the user clicks on <span> (x)
            closeModal.click(function () {
                modal.hide();
            });

            // Prevent modal from closing when clicking outside of it
            $(window).click(function (event) {
                if (event.target == modal[0]) {
                    event.stopPropagation();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var tempo = 4000; //Dois segundos

            (function selectNumUsuarios() {
                $.ajax({
                    url: "https://<?php echo $host_dir; ?>/status.php?id=<?php echo $_GET['id']; ?>",
                    success: function (n) {
                        //essa é a function success, será executada se a requisição obtiver exito
                        $("#status").html(n);
                    },
                    complete: function () {
                        setTimeout(selectNumUsuarios, tempo);
                    }
                });
            })();
        });
    </script>
</body>

</html>