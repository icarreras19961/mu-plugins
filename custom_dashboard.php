<?php

/**
 * Pluguin Name: Pluguin de personalizacion de admin de wordPress
 * Descripcion: Perosnaliza el Login
 * Version: 1.0
 * Author: Yo
 * License: GPL+2
 */

//Personalizar widgets del escritorio

add_action("wp_dashboard_setup", "bs_customize_dashboard_widgets");

function bs_customize_dashboard_widgets()
{
    //Eliminar widgets del escritorio
    remove_meta_box("dashboard_right_now", "dashboard", "normal");      // de un vistazo
    remove_meta_box("dashboard_quick_press", "dashboard", "side");      // borrado rapido
    remove_meta_box("dashboard_activity", "dashboard", "normal");       // actividad
    remove_meta_box("dashboard_primary", "dashboard", "side");          // eventos
    remove_action("welcome_panel", "wp_welcome_panel");                  // bienvenida

    //anadir nueva meta box
    add_meta_box(
        "bs_dashboard_first",   //nombre
        "Primera metabox",      //Titulo
        "bs_add_first_metabox", //Funcionalidad
        "dashboard",            //Pagina donde va
        "normal"                //posicion
    );
    add_meta_box("bs_dashboard_second", "Segunda metabox", "bs_add_second_metabox", "dashboard", "side");

    //definir contenido de la primera metabox
    function bs_add_first_metabox()
    {
        echo "hola"; ?>
        <button id="hola">
            patata
        </button>
        <span id="contador"></span>
        <script>
            let patata = document.getElementById("hola");
            let contador = document.getElementById("contador");
            let cuenta = 0;
            patata.addEventListener("click", (e) => {
                cuenta++;
                contador.innerHTML = cuenta;
            })
        </script>
<?php
    }
    //definir el contenid de la segunda metabox
    function bs_add_second_metabox()
    {
        echo "adios";
    }
}
