document.addEventListener('DOMContentLoaded', function() {
    eventListener();
    darkMode();
})

function darkMode() {
    const preferenciaDeUsuario = window.matchMedia('(prefers-color-scheme: dark)'); // Devuelve true o false

    preferenciaDeUsuario.addEventListener('change', () => {
        if(preferenciaDeUsuario.matches) {
            document.body.classList.add("dark-mode")
        } else {
            document.body.classList.remove("dark-mode")
        }
    });

    const darkMode = document.querySelector(".dark-mode-boton");

    darkMode.addEventListener('click', () => {
        document.body.classList.toggle("dark-mode");
    });
};

function eventListener() {
    const mobileMenu = document.querySelector(".mobile-menu");
    const nav = document.querySelector(".navegacion");

    mobileMenu.addEventListener('click', () => {
        // Con toggle podemos agg una class si no la tiene y si la tiene la quita.
        nav.classList.toggle("mostrar");
    })
};