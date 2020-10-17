var room = 1;
function produtoMore() {
  room++;
  var objTo = document.getElementById("produtos_valor");
  var divtest = document.createElement("div");
  divtest.setAttribute("class", "form-group removeclass" + room);
  var rdiv = "removeclass" + room;
  divtest.innerHTML = `
            <div class="form-group">
                <label for="valorProduto${room}">Valor do produto</label>
                <div class="input-group">

                    <input  id="valorProduto${room}" type="text"  placeholder="R$" class="form-control required"
                    name="valorProduto[]">
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button" onclick="remove_produto( ${room} );"> <i class="fa fa-minus"></i> </button>
                    </div>
                </div>
            </div>
   
        <div class="clear"></div></row > `;

  objTo.appendChild(divtest);
  inputProdutoMask();
}

function remove_produto(rid) {
  $(".removeclass" + rid).remove();
}
