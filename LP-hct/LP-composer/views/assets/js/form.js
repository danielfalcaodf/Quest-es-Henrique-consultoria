$(function () {
  $("form").submit(function (e) {
    e.preventDefault();

    var form = $(this);
    var action = form.attr("action");
    var data = form.serialize();

    $.ajax({
      url: action,
      data: data,
      type: "post",
      dataType: "json",
      beforeSend: function (load) {
        ajax_load("open");
      },
      error: (error, status, erro) => {
        ajax_load("close");
        console.log(error);
        if (error.responseJSON.message) {
          var view =
            '<div class="message ' +
            error.responseJSON.message.type +
            '">' +
            error.responseJSON.message.message +
            "</div>";
          $(".form_callback").html(view);
          $(".message").effect("bounce");
          return;
        } else {
          var view = `<div class="message error">Erro: ${erro} ${error.status}</div>`;
          $(".form_callback").html(view);
          $(".message").effect("bounce");
          return;
        }
      },
      success: function (data) {
        ajax_load("close");

        if (data.message && !data.result) {
          var view =
            '<div class="message ' +
            data.message.type +
            '">' +
            data.message.message +
            "</div>";
          $(".form_callback").html(view);
          $(".message").effect("bounce");
          return;
        } else if (data.message && data.result) {
          var view =
            '<div class="message ' +
            data.message.type +
            '">' +
            data.message.message +
            "</div>";
          $(".form_callback").html(view);
          $(".message").effect("bounce");
          methodType(data);
          return;
        } else {
          methodType(data);
          return;
        }
      },
    });

    function ajax_load(action) {
      ajax_load_div = $(".ajax_load");

      if (action === "open") {
        ajax_load_div.fadeIn(200).css("display", "flex");
      }

      if (action === "close") {
        ajax_load_div.fadeOut(200);
      }
    }
  });

  methodType = (data) => {
    switch (data.methodType) {
      case "troco":
        tableTroco(data);
        break;

      default:
        break;
    }
  };
});
