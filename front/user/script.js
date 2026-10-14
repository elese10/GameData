
// Datos de ejemplo: reemplazalos por los que vengan de tu backend (PHP / base de datos).
const perfil = {
    nombre: "Usuario",
    desde: "05-07-2026",
    bio: "Soy un jugador que registra sus juegos, comparte listas y busca recomendaciones con un toque personal. Me gusta explorar mundos oscuros, seguir historias densas y completar colecciones con cuidado.",
    listas: {
        favoritos: [
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" },
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" }
        ],
        deseados: [
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" },
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" }
        ],
        posesion: [
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" },
            { nombre: "Dark Souls", portada: "../img/dark-souls.jpg" }
        ]
    }
};

const iconos = {
    estrella: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"><path d="M12 3l2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1L3.2 9.5l6.1-.9z"/></svg>',
    mas: '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>',
    libro: '<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M6 3h12a2 2 0 0 1 2 2v16H8a2 2 0 0 1-2-2V3zm2 14v2h10V5H8v12z"/></svg>'
};

const configuracion = [
    { clave: "favoritos", titulo: "Favoritos", icono: "estrella", etiqueta: "Favorito" },
    { clave: "deseados", titulo: "Deseados", icono: "mas", etiqueta: "Deseado" },
    { clave: "posesion", titulo: "En posesión", icono: "libro", etiqueta: "En posesión" }
];

function escapar(texto) {
    const div = document.createElement("div");
    div.textContent = texto;
    return div.innerHTML;
}

function mostrarPerfil() {
    document.getElementById("nombre").textContent = perfil.nombre;
    document.getElementById("desde").textContent = perfil.desde;
    document.getElementById("bio").textContent = perfil.bio;
}

function mostrarListas() {
    const contenedor = document.getElementById("listas");
    contenedor.innerHTML = configuracion.map(({ clave, titulo, icono, etiqueta }) => {
        const juegos = perfil.listas[clave] || [];
        const items = juegos.length
            ? juegos.map((juego, i) => `
                <li class="juego">
                    <img class="portada" src="${escapar(juego.portada)}" alt="" onerror="this.removeAttribute('src')">
                    <div class="juego-info">
                        <div class="juego-nombre">${escapar(juego.nombre)}</div>
                        <div class="juego-etiqueta">${etiqueta} ${i + 1}</div>
                    </div>
                    <span class="posicion">${i + 1}</span>
                </li>`).join("")
            : '<li class="vacio">Todavía no hay juegos en esta lista.</li>';
        return `
            <article class="lista">
                <div class="lista-cabecera">
                    <h3 class="lista-titulo">${iconos[icono]}${titulo}</h3>
                    <span class="contador">${juegos.length} ${juegos.length === 1 ? "juego" : "juegos"}</span>
                </div>
                <ul class="juegos">${items}</ul>
            </article>`;
    }).join("");
}

document.getElementById("btn-volver").addEventListener("click", () => history.back());
document.getElementById("btn-modificar").addEventListener("click", () => {
    // TODO: ir a la pantalla de edición, ej: location.href = "editar_perfil.php";
});
document.getElementById("btn-logout").addEventListener("click", () => {
    // TODO: cerrar sesión, ej: location.href = "../../back/cerrar_sesion.php";
});

mostrarPerfil();
mostrarListas();