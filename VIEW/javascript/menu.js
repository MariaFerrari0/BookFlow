document.addEventListener("DOMContentLoaded", function () {
  // Obtém o caminho atual da URL (ex: /BookFlow/views/dashboard.php)
  const currentPath = window.location.pathname;

  // Seleciona todos os links de itens do menu
  const menuItems = document.querySelectorAll(".menu-item");

  menuItems.forEach((item) => {
    const href = item.getAttribute("href");

    // Se o caminho atual terminar com o href do link, adiciona a classe "active"
    if (href && currentPath.endsWith(href)) {
      item.classList.add("active");
    }
  });
});
