$(document).ready(function() {
  $("form").submit(function(event) {
    $("#formulario").addClass("loading");
    $("#formulario").append('<div class="spinner"></div>');
    $(".form-group").removeClass("has-error");
    $(".help-block").remove();

    if ($("input[name=parada]").val() == "Q") {
      $("input[name=parada]").val("N2894");
      $("#linea option:selected").text("17");
    }

    var formData = {
      parada: $("input[name=parada]").val(),
      linea: $("#linea option:selected").text()
    };

    $.ajax({
      type: "POST",
      url: "soap.php",
      data: formData,
      dataType: "json",
      encode: true
    })
    .done(function(data) {
      $("#formulario").removeClass("loading");
      $(".spinner").remove();

      // log data to the console so we can see
      console.log(data);

      if (data.success) {
        if (!data.result.RecuperarProximosArribosResult) {
          $("#resultado").append(
            '<div class="alert alert-this sharp help-block">' +
              "Sin resultados (¿Esta llegando?)" +
              "</div>"
          );
        } else {
          $("#resultado").append(
            '<div class="alert alert-this sharp help-block">' +
              data.result.RecuperarProximosArribosResult.ProximoArribo.arribo +
              "</div>"
          );
        }
      } else {
        // linea ---------------
        if (data.errors.linea) {
          $("#linea-group").addClass("has-error"); // add the error class to show red input
          $("#linea-group").append(
            '<div class="help-block">' + data.errors.linea + "</div>"
          ); // add the actual error message under our input
        }

        // parada ---------------
        if (data.errors.parada) {
          $("#parada-group").addClass("has-error"); // add the error class to show red input
          $("#parada-group").append(
            '<div class="help-block">' + data.errors.parada + "</div>"
          ); // add the actual error message under our input
        }
      }
    });

    event.preventDefault();
  });
});
