document.getElementById("menu-toggle").addEventListener("click", function () {
    let menu = document.getElementById("menu-items");
    menu.classList.toggle("hidden");
});

const perfilDropdown = document.querySelector(".relative.group");
const dropdownMenu = perfilDropdown.querySelector(".absolute");

perfilDropdown.addEventListener("click", function () {
    dropdownMenu.classList.toggle("hidden");
});
