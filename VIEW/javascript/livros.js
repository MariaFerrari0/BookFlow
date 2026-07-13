document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formCadastrarLivro");

  if (form) {
    form.addEventListener("submit", function (event) {
      const paginasInput = document.getElementById("paginas");
      const paginasValue = parseInt(paginasInput.value, 10);

      if (isNaN(paginasValue) || paginasValue <= 0) {
        alert(
          "Por favor, introduza um número válido de páginas (maior que 0).",
        );
        event.preventDefault();
      }
    });
  }
});
