<h2 class="h5 px-4 py-3 accordion-header d-flex justify-content-between align-items-center">
    <div class="form-check w-100 collapsed" for="payment1" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseCC" aria-expanded="false">
        <label class="form-check-label pt-1" style="cursor: pointer;" for="payment1">Cartão de Crédito</label>
    </div>
    <span>
        <svg width="34" height="25" xmlns="http://www.w3.org/2000/svg">
            <g fill-rule="nonzero" fill="#333840">
                <path d="M29.418 2.083c1.16 0 2.101.933 2.101 2.084v16.666c0 1.15-.94 2.084-2.1 2.084H4.202A2.092 2.092 0 0 1 2.1 20.833V4.167c0-1.15.941-2.084 2.102-2.084h25.215ZM4.203 0C1.882 0 0 1.865 0 4.167v16.666C0 23.135 1.882 25 4.203 25h25.215c2.321 0 4.203-1.865 4.203-4.167V4.167C33.62 1.865 31.739 0 29.418 0H4.203Z"></path>
                <path d="M4.203 7.292c0-.576.47-1.042 1.05-1.042h4.203c.58 0 1.05.466 1.05 1.042v2.083c0 .575-.47 1.042-1.05 1.042H5.253c-.58 0-1.05-.467-1.05-1.042V7.292Zm0 6.25c0-.576.47-1.042 1.05-1.042H15.76c.58 0 1.05.466 1.05 1.042 0 .575-.47 1.041-1.05 1.041H5.253c-.58 0-1.05-.466-1.05-1.041Zm0 4.166c0-.575.47-1.041 1.05-1.041h2.102c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042H5.253c-.58 0-1.05-.466-1.05-1.042Zm6.303 0c0-.575.47-1.041 1.051-1.041h2.101c.58 0 1.051.466 1.051 1.041 0 .576-.47 1.042-1.05 1.042h-2.102c-.58 0-1.05-.466-1.05-1.042Zm6.304 0c0-.575.47-1.041 1.051-1.041h2.101c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042h-2.101c-.58 0-1.05-.466-1.05-1.042Zm6.304 0c0-.575.47-1.041 1.05-1.041h2.102c.58 0 1.05.466 1.05 1.041 0 .576-.47 1.042-1.05 1.042h-2.101c-.58 0-1.05-.466-1.05-1.042Z"></path>
            </g>
        </svg>
    </span>
</h2>
<div id="collapseCC" class="accordion-collapse collapse show container" data-bs-parent="#accordionPayment">
    <br>
    <form id="form-checkout">
        <div class="row">
            <div class="col-lg-12">
                <input type="text" id="form-checkout__cardholderName" class="form-control"/>
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-6">
                <div id="form-checkout__cardNumber" class="form-control"></div>
                <br>
            </div>
            <div class="col-lg-3">
                <div id="form-checkout__expirationDate" class="form-control"></div>
                <br>
            </div>
            <div class="col-lg-3">
                <div id="form-checkout__securityCode" class="form-control"></div>
                <br>
            </div>
            <div class="col-lg-12">
                <select id="form-checkout__issuer" class="form-control"></select>
                <br>
            </div>
            <div class="col-lg-12">
                <select id="form-checkout__installments" class="form-control"></select>
                <br>
            </div>
            <div class="col-lg-2">
                <select id="form-checkout__identificationType" class="form-control"></select>
                <br>
            </div>
            <div class="col-lg-10">
                <input type="text" id="form-checkout__identificationNumber" class="form-control"/>
                <br>
            </div>
            <div class="col-lg-12">
                <input type="email" id="form-checkout__cardholderEmail" class="form-control"/>
            </div>
        </div>
        <br>
        <div id="resposta"></div>
        <button type="submit" id="form-checkout__submit" class="btn btn-primary">Efetuar pagamento</button>
        <progress value="0" class="progress-bar" style="visibility: hidden;">Carregando...</progress>
    </form>
    <br>
</div>
<script>
const cardForm = mp.cardForm({
  amount: "<?php echo $total;?>",
  iframe: true,
  form: {
    id: "form-checkout",
    cardNumber: {
      id: "form-checkout__cardNumber",
      placeholder: "Número do cartão",
    },
    expirationDate: {
      id: "form-checkout__expirationDate",
      placeholder: "MM/YY",
    },
    securityCode: {
      id: "form-checkout__securityCode",
      placeholder: "Código de segurança",
    },
    cardholderName: {
      id: "form-checkout__cardholderName",
      placeholder: "Titular do cartão",
    },
    issuer: {
      id: "form-checkout__issuer",
      placeholder: "Banco emissor",
    },
    installments: {
      id: "form-checkout__installments",
      placeholder: "Parcelas",
    },        
    identificationType: {
      id: "form-checkout__identificationType",
      placeholder: "Tipo de documento",
    },
    identificationNumber: {
      id: "form-checkout__identificationNumber",
      placeholder: "Número do documento",
    },
    cardholderEmail: {
      id: "form-checkout__cardholderEmail",
      placeholder: "E-mail",
    },
  },
  callbacks: {
    onFormMounted: error => {
      if (error) return console.warn("Form Mounted handling error: ", error);
      console.log("Form mounted");
    },
    onSubmit: event => {
      event.preventDefault();
      document.getElementById('resposta').innerHTML = "Processando...";
      const {
        paymentMethodId: payment_method_id,
        issuerId: issuer_id,
        cardholderEmail: email,
        amount,
        token,
        installments,
        identificationNumber,
        identificationType,
      } = cardForm.getCardFormData();

      fetch("https://<?php echo $host_dir;?>/config/processa.php?id=<?php echo $_GET['id'];?>", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          token,
          issuer_id,
          payment_method_id,
          transaction_amount: Number(amount),
          installments: Number(installments),
          description: "Descrição do produto",
          payer: {
            email,
            identification: {
              type: identificationType,
              number: identificationNumber,
            },
          },
        }),
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById('resposta').innerHTML = data;
      })
      .catch(error => console.error('Error:', error));
    },
    onFetching: (resource) => {
      console.log("Fetching resource: ", resource);

      // Animate progress bar
      const progressBar = document.querySelector(".progress-bar");
      progressBar.removeAttribute("value");

      return () => {
        progressBar.setAttribute("value", "0");
      };
    }
  },
});
</script>
<script>
$(document).ready(function() {
    var modal = $('#myModal');
    var closeModal = $('#closeModal');

    // When the user clicks the button, open the modal
    $('#openModal').click(function() {
        $.get('https://<?php echo $host_dir;?>/config/gerar_pix.php', function(data) {
            $('#modalBody').html(data);
            modal.show();
            
            // Enable closing the modal after 1 minute
            setTimeout(function() {
                closeModal.show();
            }, 5000); // 60000 milliseconds = 1 minute
        });
    });

    // Close the modal when the user clicks on <span> (x)
    closeModal.click(function() {
        modal.hide();
    });

    // Prevent modal from closing when clicking outside of it
    $(window).click(function(event) {
        if (event.target == modal[0]) {
            event.stopPropagation();
        }
    });
});
</script>