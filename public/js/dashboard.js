document.addEventListener("DOMContentLoaded", function () {
  // Seletores conforme as IDs do seu dashboard.php
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

    // Injeta animação de rotação caso não exista no seu CSS global
    if (!document.getElementById("spin-animation-style")) {
      const style = document.createElement("style");
      style.id = "spin-animation-style";
      style.innerHTML =
        "@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }";
      document.head.appendChild(style);
    }

    btnBuscar.innerHTML =
      '<i class="material-icons" style="animation: spin 1s infinite linear; display: inline-block; vertical-align: middle;">sync</i>';

    // Rota relativa (tentaremos primeiro a pasta anterior, depois a raiz caso falhe)
    const urlController = `../CONTROLLER/GoogleBooksController.php?busca=${encodeURIComponent(busca)}`;

    // Função interna para processar o JSON recebido com segurança
    function processarDadosLivro(data) {
      btnBuscar.disabled = false;
      btnBuscar.innerHTML = textoOriginal;

      // Se o PHP retornou uma mensagem de erro em formato JSON
      if (data.erro) {
        M.toast({ html: data.erro, classes: "rounded red darken-4" });
        return;
      }

      // Preenche dinamicamente os campos do formulário (com fallbacks de IDs comuns)
      const inputTitulo =
        document.getElementById("titulo") ||
        document.querySelector("[name='titulo']");
      const inputAutor =
        document.getElementById("autor") ||
        document.querySelector("[name='autor']");

      const inputPaginas =
        document.getElementById("paginas_total") ||
        document.getElementById("paginas") ||
        document.getElementById("total_paginas") ||
        document.querySelector("[name='paginas']");

      if (inputTitulo) inputTitulo.value = data.titulo || "";
      if (inputAutor) inputAutor.value = data.autor || "";
      if (inputPaginas) inputPaginas.value = data.paginas || "";

      // Atualiza a imagem da capa do livro no preview
      const imgCapa =
        document.getElementById("api-preview-capa") ||
        document.querySelector(".modal img");
      if (imgCapa) {
        imgCapa.src =
          data.capa ||
          "https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=120&auto=format&fit=crop&q=60";
      }

      // Atualiza as labels flutuantes do Materialize CSS
      setTimeout(() => {
        if (typeof M !== "undefined" && M.updateTextFields) {
          M.updateTextFields();
        }
      }, 100);

      M.toast({
        html: "Dados importados com sucesso! 🎉",
        classes: "rounded deep-purple darken-2",
      });
    }

    // Faz a chamada ao Controller PHP com tratamento de erro de rota
    fetch(urlController)
      .then((response) => {
        const contentType = response.headers.get("content-type");
        if (
          !response.ok ||
          !contentType ||
          !contentType.includes("application/json")
        ) {
          // Se falhar a rota '../CONTROLLER/', tenta buscar sem o '../'
          const rotaAlternativa = `CONTROLLER/GoogleBooksController.php?busca=${encodeURIComponent(busca)}`;
          return fetch(rotaAlternativa).then((resAlt) => {
            const contentAlt = resAlt.headers.get("content-type");
            if (
              !resAlt.ok ||
              !contentAlt ||
              !contentAlt.includes("application/json")
            ) {
              throw new Error(
                "Não foi possível acessar o controller PHP em nenhuma das rotas.",
              );
            }
            return resAlt.json();
          });
        }
        return response.json();
      })
      .then((data) => {
        processarDadosLivro(data);
      })
      .catch((error) => {
        btnBuscar.disabled = false;
        btnBuscar.innerHTML = textoOriginal;
        console.error("Erro na busca de livros:", error);
        M.toast({
          html: "Ocorreu um erro ao processar os dados do servidor local.",
          classes: "rounded red darken-4",
        });
      });
  });
});
