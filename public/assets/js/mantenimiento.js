function agregarCarrera() {
  $("#form-carrera").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl, // Usa la variable baseUrl definida en la vista
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        // Actualizar la tabla con los nuevos datos
        $("#tabla-carreras tbody").html(response);
        // Limpiar el formulario
        $("#form-carrera")[0].reset();
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
      },
    });
  });
}
