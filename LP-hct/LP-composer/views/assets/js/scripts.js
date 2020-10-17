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
  }
};

formetMoney = (value) => {
  console.log(value);
  var formatoMoney = {
    minimumFractionDigits: 2,
    style: "currency",
    currency: "BRL",
  };
  console.log(value.toLocaleString("pt-BR", formatoMoney));
  return value.toLocaleString("pt-BR", formatoMoney);
};
