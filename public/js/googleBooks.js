document.addEventListener("DOMContentLoaded", function () {
  // Seletores atualizados conforme as IDs do seu dashboard.php
  const btnBuscar = document.getElementById("btn-api-search");
  const inputPesquisa = document.getElementById("pesquisa-api");

  if (!btnBuscar || !inputPesquisa) return;

  btnBuscar.addEventListener("click", function () {
    const busca = inputPesquisa.value.trim();

    if (busca === "") {
      M.toast({
        html: "Por favor, digite o título ou autor!",
        classes: "rounded red darken-4",
      });
      return;
    }

    // Feedback visual de carregamento no botão
    const textoOriginal = btnBuscar.innerHTML;
    btnBuscar.disabled = true;
    btnBuscar.innerHTML =
      '<i class="material-icons spinning-icon" style="animation: spin 1.2s infinite linear; display: inline-block;">sync</i>';

    // Rota relativa correta para o Controller a partir da pasta /public/js/
    const urlController = `../CONTROLLER/GoogleBooksController.php?busca=${encodeURIComponent(busca)}`;

    // Faz a chamada ao Controller PHP
    fetch(urlController)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Erro do servidor: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        // Restaura o estado original do botão
        btnBuscar.disabled = false;
        btnBuscar.innerHTML = textoOriginal;

        if (data.erro) {
          M.toast({ html: data.erro, classes: "rounded red darken-4" });
          return;
        }

        // Preenche dinamicamente os campos do formulário (com verificação de segurança)
        const inputTitulo = document.getElementById("titulo");
        const inputAutor = document.getElementById("autor");
        const inputPaginas = document.getElementById("paginas_total"); // Alinhado com o name/id do HTML

        if (inputTitulo) inputTitulo.value = data.titulo || "";
        if (inputAutor) inputAutor.value = data.autor || "";
        if (inputPaginas) inputPaginas.value = data.paginas || "";

        // Atualiza a imagem da capa do livro no preview
        const imgCapa = document.getElementById("api-preview-capa");
        if (imgCapa) {
          imgCapa.src =
            data.capa || "https://via.placeholder.com/120x170?text=Sem+Capa";
        }

        // Atualiza as labels flutuantes do Materialize CSS
        M.updateTextFields();

        M.toast({
          html: "Dados importados com sucesso! 🎉",
          classes: "rounded deep-purple darken-2",
        });
      })
      .catch((error) => {
        btnBuscar.disabled = false;
        btnBuscar.innerHTML = textoOriginal;
        console.error("Erro na busca de livros:", error);
        M.toast({
          html: "Ocorreu um erro ao buscar o livro.",
          classes: "rounded red darken-4",
        });
      });
  });
});
