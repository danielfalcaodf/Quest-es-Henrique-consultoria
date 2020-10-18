$(function () {
  inputProdutoMask();
});

inputProdutoMask = () => {
  $('input[name="valorProduto[]"]').mask("###0,00", {
    reverse: true,
  });
};

tableTroco = (data) => {
  if (data.cod == 1) {
    var view = "";

    $("#tabelaTroco").removeClass("d-none");

    $.each(data.result.contNotas, function (indexInArray, valueOfElement) {
      view += ` <tr>
          <td scope="row">${formetMoney(Number(indexInArray))}</td>
          <td>${valueOfElement}</td>
      </tr>
      `;
    });
    $("#tabelaTroco tbody").html(view);
    $("#result").html(` 
    <h4>Valor da Compra: <span class="font-weight-bold">${data.result.valorCompra}</span></h4>
    <h4>Entrada do cliente: <span class="font-weight-bold">${data.result.dinheiroCliente}</span></h4>
    <h4>Troco: <span class="font-weight-bold">${data.result.troco}</span></h4>`);
    $("html,body").animate(
      {
        scrollTop: $("#tabelaTroco").offset().top - 150,
      },
      "slow"
    );
  }
};

formetMoney = (value) => {
  var formatoMoney = {
    minimumFractionDigits: 2,
    style: "currency",
    currency: "BRL",
  };

  return value.toLocaleString("pt-BR", formatoMoney);
};
