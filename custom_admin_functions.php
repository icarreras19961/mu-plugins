<?php

//Cambiar items de menu

add_action("admin_menu", "bs_change_posts_menu_items");

function bs_change_posts_menu_items()
{
  global $menu;
  global $submenu;

  $menu[5][0] = "articulos";
  $submenu["edit.php"][5][0] = "Todos los articulos";
  $submenu["edit.php"][10][0] = "Nuevo articulo";
}

//Cambiar elementos del menu Entradas
add_action("init", "bs_change_post_menu_items");

function bs_change_post_menu_items()
{
  global $wp_post_types;
  $labels = $wp_post_types["post"]->labels;
  $labels->name = "Articulos";
  $labels->singular_name = "Articulo";
  $labels->add_new = "Anadir articulo";
  $labels->add_new_item = "Nuevo articulo";
  $labels->all_items = "Todos los articulos";
  $labels->edit_item = "Editar articulos";
  $labels->name_admin_bar = "Articulos";
}

/**
 * Pluguin Name: Pluguin de personalizacion de la barra de admin de wordPress
 * Descripcion: Perosnaliza la barra de admin
 * Version: 1.0
 * Author: Yo
 * License: GPL+2
 */

// Eliminar nodos

add_action('admin_bar_menu', 'bs_remove_nodes', 999);


function bs_remove_nodes()
{
  global $wp_admin_bar;

  $wp_admin_bar->remove_node('wp-logo');
  //  $wp_admin_bar->remove_node('site-name');
  $wp_admin_bar->remove_node('comments');
  $wp_admin_bar->remove_node('new-content');
  //    $wp_admin_bar->remove_node('my-account');
}

//anadir nodos

add_action("admin_bar_menu", "bs_add_nodes");

function bs_add_nodes($wp_admin_bar)
{
  $args = array(
    "id" => "Featured_links",
    "title" => "Enlaces destacados",
    "href" => "http://localhost/wordpress",
  );
  $wp_admin_bar->add_node($args);

  //anadir elementos hijo
  $args = array();
  array_push($args, array(
    "id" => "Boluda_com",
    "title" => "Boluda.com",
    "href" => "https://boluda.com",
    "parent" => "Featured_links",
  ));
  array_push($args, array(
    "id" => "WordPress",
    "title" => "WordPress.es",
    "href" => "https://wordpress.es",
    "parent" => "Featured_links",
  ));
  sort($args);
  foreach ($args as $each_arg) {
    $wp_admin_bar->add_node($each_arg);
  }
}

//Personalizar el admin de Footer

add_filter("admin_footer_text", "bs_custom_admin_footer_text");
function bs_custom_admin_footer_text()
{
  global $current_user;
  wp_get_current_user();

  echo $current_user->display_name . " Gracias por confiar en nosotros para crear tu sitio web";
}

//Personalizar el texto de la version de wordpress

add_filter("update_footer", "bs_custom_admin_footer_version", 999);

function bs_custom_admin_footer_version()
{
  $site_title = get_bloginfo("name");
  $wp_version = get_bloginfo("version");

  echo "El sitio " . $site_title . " funciona con WordPress en version " . $wp_version;
}

//Personalizar el headder del admin de wordpress

add_action("admin_head", "bs_custom_admin_head");

function bs_custom_admin_head()
{
?>
  <div id="bs-admin-head">
    <div class="bs_logo">
      <img width="40px" header="40px" src="https://previews.123rf.com/images/aprillrain/aprillrain2212/aprillrain221200638/196354278-imagen-de-caricatura-de-un-astronauta-sentado-en-una-luna-ilustraci%C3%B3n-de-alta-calidad.jpg" alt="">
      <div class="bs-text">
        <?php
        global $current_user;
        wp_get_current_user();
        echo "hola " . $current_user->display_name . "!";
        ?>
      </div>
    </div>
  </div>
  <?php
}

//Eliminar opciones de pantalla
add_filter("screen_options_show_screen", "__return_false");

//Eliminar perstana de ayuda
//add_action("admin_head", "bs_remove_contextual_help");

function bs_remove_contextual_help()
{
  $screen = get_current_screen();
  $screen->remove_help_tabs();
}

//Anadir pestanas de ayuda al escritorio de wordpress
add_action("load-index.php", "bs_dashboard_help_tabs");

function bs_dashboard_help_tabs()
{
  $screen = get_current_screen();
  $screen->add_help_tab(
    array(
      "id" => "bs_caracteristicas",
      "title" => "caracteristicas",
      "content" => "<p><strong>Caracteristicas del Escritorio personalizado de wordpress</strong><ul><li>Una caracteristica</li></p>",
    )
  );

  $screen->add_help_tab(
    array(
      "id" => "bs_facts",
      "title" => "Preguntas frecuentes",
      "content" => "<p><strong>Preguntas frecuentes</strong><ul><li>Una pregunta</li></p>",
    )
  );
}

// Anadir estilos al admin de wordpress

add_action("admin_enqueue_scripts", "bs_custom_admin_styles");

function bs_custom_admin_styles()
{
  wp_enqueue_style("custom-admin-styles", plugins_url("/css/custom_admin_style.css", __FILE__));
}

//anadir estilos al login de wordpress
add_action("login_enqueue_scripts", "bs_custom_login_styles");

function bs_custom_login_styles()
{
  wp_enqueue_style("custom-admin-styles", plugins_url("/css/custom_admin_style.css", __FILE__));
}

//anadir estilos al theme de wordpress
add_action("wp_enqueue_scripts", "bs_custom_theme_styles");

function bs_custom_theme_styles()
{
  wp_enqueue_style("custom-admin-styles", plugins_url("/css/custom_admin_style.css", __FILE__));
}

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

/**
 * Pluguin Name: Pluguin de personalizacion de Login de wordPress
 * Descripcion: Perosnaliza el Login
 * Version: 1.0
 * Author: Yo
 * License: GPL+2
 */

//Modificar el logo del WordPress
add_action("login_enqueue_scripts", "bs_login_logo");

function bs_login_logo()
{
  ?>

  <?php
}

//MODIFICAR LA URL DEL LOGO
add_filter("login_headerurl", "bs_login_logo_link");

function bs_login_logo_link($url)
{
  return home_url();
}

//Modificar titulo del logo
add_filter("login_headertitle", "bs_login_logo_title");

function bs_login_logo_title($message)
{
  $message = get_bloginfo("name");
  return $message;
}

/**
 * Pluguin Name: Pluguin de personalizacion de la barra de menu lateral de wordPress
 * Descripcion: Perosnaliza la barra de menu lateral
 * Version: 1.0
 * Author: Yo
 * License: GPL+2
 */

//anadir elemento al menu
add_action("admin_menu", "bs_add_menu_item");

function bs_add_menu_item()
{
  add_menu_page(
    "Pagina de datos",          //Titulo de la pagina
    "Datos",                    //Titulo del menu
    "administrator",            //Roll de usuario para poder acceder
    "pagina-de-datos",          //url
    "bs_data_page_content",     //La funcion
    "dashicons-list-view",      //icono
    "100"                       //posicion
  );

  //Contenido de la pagina de datos
  function bs_data_page_content()
  {

  ?>
    <div class="wrap">
      <!--el ahorcado de clase-->
      <style>
        body {
          background-color: #6599ff;
          color: white;
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
          flex-direction: column;
        }

        h1 {
          margin: 20px;
        }

        button {
          background-color: #4c71b9;
          border-radius: 5px;
          color: white;
          border-color: #3d5b96;
          padding: 5px;
        }

        img {
          width: 25%;
          height: auto;
          margin: 5px;
          border-radius: 15px;
          position: absolute;
          left: 10%;
          box-shadow: 1px 2px 5px 2px rgba(8, 19, 36, 0.2);
        }

        .contenedor-intentos {
          display: flex;
          align-items: center;
          background-color: #4c71b9;
          border-radius: 5px;
          width: 20%;
          height: 30px;
          padding: 5px;
        }

        .intentos {
          color: crimson;
        }

        .palabra-secreta {
          text-align: center;
        }

        #analfabeto {
          display: flex;
          flex-wrap: wrap;
          width: 25%;
          justify-content: center;
        }

        .letra {
          background-color: #4c71b9;
          border-radius: 5px;
          padding: 2px;
          margin: 5px;
          width: 20px;
          float: left;
        }

        .letra:hover {
          transform: scale(1.1);
          background-color: #3d5b96;
          box-shadow: 1px 2px 5px 2px rgba(8, 19, 36, 0.2);
          cursor: pointer;
        }

        .letra.error {
          background-color: crimson;
        }

        .letra.acierto {
          background-color: greenyellow;
          color: #3d5b96;
        }

        .letra.acierto,
        .error:hover {
          transform: scale(1);
          box-shadow: 0px 0px 0px 0px rgba(8, 19, 36, 0.2);
          cursor: default;
        }

        .cronometro {
          border: 5px solid #3d5b96;
          border-radius: 10px;
          padding: 5px;
          background-color: white;
          color: #3d5b96;
        }

        #lahora {
          border: 2px solid #3d5b96;
          background-color: lightgrey;
          border-radius: 10px;
        }

        hr {
          margin: 5px;
          border: 1.5px solid #4c71b9;
          border-radius: 10px;
        }

        .boton {
          background-color: #4c71b9;
          border: 2px solid #3d5b96;
          color: white;
          border-radius: 10px;
          padding: 2px;
        }

        .boton:hover {
          transform: scale(1.1);
          box-shadow: 1px 2px 5px 2px rgba(8, 19, 36, 0.2);
          background-color: #3d5b96;
          cursor: pointer;
        }

        /* POP_UP */
        .envoltorio-popup {
          background: rgba(0, 0, 0, 0.5);
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: none;
        }

        .popup {
          font-family: Arial, Helvetica, sans-serif;
          text-align: center;
          width: 100%;
          max-width: 300px;
          margin: 10% auto;
          background: #6599ff;
          border-radius: 5px;
          padding: 20px;
          position: relative;
        }

        .popup a {
          background: crimson;
          color: white;
          text-decoration: none;
          margin: 5px;
          display: block;
          padding: 6px 10px;
          border-radius: 5px;
        }

        #imagen-popup {
          box-shadow: 1px 2px 5px 2px rgba(8, 19, 36, 0.2);

          left: 5px;
        }

        .cerrar-popup {
          position: absolute;
          top: 5px;
          right: 8px;
          cursor: pointer;
        }

        /**popUp ganar*/
        .envoltorio-popup-ganar {
          background: rgba(0, 0, 0, 0.5);
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: none;
        }

        .cerrar-popup-ganar {
          position: absolute;
          top: 5px;
          right: 8px;
          cursor: pointer;
        }

        /** popUp Elegir tema*/
        .envoltorio-popup-eligeTema {
          background: rgba(0, 0, 0, 0.5);
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          display: none;
        }

        .cerrar-popup-eligeTema {
          position: absolute;
          top: 5px;
          right: 8px;
          cursor: pointer;
        }
      </style>
      <h1>Juego del ahorcado</h1>
      <button id="eligeTema">Elegir tematica</button>
      <div class="envoltorio-popup-eligeTema">
        <div class="popup">
          <div class="cerrar-popup-eligeTema">x</div>
          <div class="contenido-popup">
            <h2>Elige un tema</h2>
            <hr>
            <button id="comida">Comida</button>
            <hr>
            <button id="paises">Paises</button>
            <hr>
            <button id="animales">Animales</button>
            <hr>
            <button id="flora">Flora</button>
            <hr>
            <button id="TPeriodica">Tabla Periodica</button>
          </div>
        </div>
      </div>
      <br>
      <img id="imagen" src="img/fallo0.png" alt="" srcset="">
      <div class="contenedor-intentos">
        <p>
          Elije una letra, te quedan
          <span class="intentos">7</span>
        </p>
      </div>
      <div class="palabra-secreta"></div>

      <div id="analfabeto">
        <div class="letra">A</div>
        <div class="letra">B</div>
        <div class="letra">C</div>
        <div class="letra">D</div>
        <div class="letra">E</div>
        <div class="letra">F</div>
        <div class="letra">G</div>
        <div class="letra">H</div>
        <div class="letra">I</div>
        <div class="letra">J</div>
        <div class="letra">K</div>
        <div class="letra">L</div>
        <div class="letra">M</div>
        <div class="letra">N</div>
        <div class="letra">Ñ</div>
        <div class="letra">O</div>
        <div class="letra">P</div>
        <div class="letra">Q</div>
        <div class="letra">R</div>
        <div class="letra">S</div>
        <div class="letra">T</div>
        <div class="letra">U</div>
        <div class="letra">V</div>
        <div class="letra">W</div>
        <div class="letra">X</div>
        <div class="letra">Y</div>
        <div class="letra">Z</div>
      </div>


      <div class="cronometro">

        <div id="lahora">00:00:00</div>
        <hr>
        <button class="boton" id="start">Start</button>
        <button class="boton" id="stop">Stop</button>
        <button class="boton" id="reset">Reset</button>
      </div>
      <div class="envoltorio-popup">
        <div class="popup">
          <div class="cerrar-popup">x</div>
          <div class="contenido-popup">
            <h2>Has Perdido :C</h2>
            <img id="imagen-popup" src="img/hasPerdido.png" alt="" srcset="">
            <hr>
            <h3>La palabra era:</h3>
            <p id="pop-up-palabraSecreta"></p>
            <hr>
            <p id="record"></p>
            <hr>
            <p>¿Quieres volver a Jugar?</p>
            <a class="volver-a-jugar" href="#">Volver a Jugar</a>
          </div>
        </div>
      </div>

      <div class="envoltorio-popup-ganar">
        <div class="popup">
          <div class="cerrar-popup-ganar">x</div>
          <div class="contenido-popup">
            <h2>Has Ganado :D</h2>
            <hr>
            <p id="pRecord"></p>
            <hr>
            <p>¿Quieres volver a Jugar?</p>
            <a class="volver-a-jugar-ganar" href="#">Volver a Jugar</a>
          </div>
        </div>
      </div>
      <script>
        // VARIABLES
        let analfabeto = document.getElementById("analfabeto");
        let divSecreto = document.querySelector(".palabra-secreta");
        let intento = document.querySelector(".intentos");
        let imagen = document.getElementById("imagen");
        console.log(imagen);
        let ListaJSON;
        let listaPalabras = [
          "Hola",
          "adios",
          "patata",
          "zapato",
          "libro",
          "carta",
          "mesopotamia",
          "esdrujula",
          "lapiz",
          "agua",
          "estuche",
          "supercalifragilisticoespiralidoso",
        ];
        let palabraSecreta;
        let letrasCifradas;
        let cont = 0;
        let record = {
          IntentosRestantes: "",
          tiempoEmpleado: "",
        };
        let pRecord = document.getElementById("pRecord");
        //Pop up variables
        //Perder
        const envoltorio = document.getElementsByClassName("envoltorio-popup");
        const volverJugar = document.getElementsByClassName("volver-a-jugar");
        const cerrar = document.getElementsByClassName("cerrar-popup");
        let popUpPalabraSecreta = document.getElementById("pop-up-palabraSecreta");
        //Ganar
        const envoltorioGanar = document.getElementsByClassName(
          "envoltorio-popup-ganar"
        );
        const cerrarGanar = document.getElementsByClassName("cerrar-popup-ganar");
        const volverJugarGanar = document.getElementsByClassName(
          "volver-a-jugar-ganar"
        );

        const eligeTema = document.getElementById("eligeTema");
        const envoltorioElegirTema = document.getElementsByClassName(
          "envoltorio-popup-eligeTema"
        );
        const cerrarEligeTema = document.getElementsByClassName("cerrar-popup-ganar");
        let comida = document.getElementById("comida");
        let paises = document.getElementById("paises");
        let animales = document.getElementById("animales");
        let flora = document.getElementById("flora");
        let TPeriodica = document.getElementById("TPeriodica");

        //EVENTOS

        // Cuando elijes una letra
        analfabeto.addEventListener("click", (e) => {
          if (e.target.classList.contains("letra")) {
            cont++;
            console.log(cont);
            if (cont == 1) {
              elCrono = setInterval(crono, 1000);
              start.style.display = "none";
            }
            console.log(e.target.innerText);
            comprobador(e);
          }
        });

        //eventos del popup
        cerrar[0].addEventListener("click", () => {
          envoltorio[0].style.display = "none";
        });
        volverJugar[0].addEventListener("click", () => {
          envoltorio[0].style.display = "none";
          location.reload();
        });

        //Eventos ganar
        volverJugarGanar[0].addEventListener("click", () => {
          envoltorioGanar[0].style.display = "none";
          location.reload();
        });
        cerrarGanar[0].addEventListener("click", () => {
          envoltorioGanar[0].style.display = "none";
        });

        //Evento elegir tema
        eligeTema.addEventListener("click", (e) => {
          envoltorioElegirTema[0].style.display = "block";
          comida.addEventListener("click", (e) => {
            listaPalabras = ListaJSON[0];
            envoltorioElegirTema[0].style.display = "none";
            PalabraSecreta();
            escribidor();
          });
          paises.addEventListener("click", (e) => {
            listaPalabras = ListaJSON[1];
            envoltorioElegirTema[0].style.display = "none";
            PalabraSecreta();
            escribidor();
          });
          animales.addEventListener("click", (e) => {
            listaPalabras = ListaJSON[2];
            envoltorioElegirTema[0].style.display = "none";
            PalabraSecreta();
            escribidor();
          });
          flora.addEventListener("click", (e) => {
            listaPalabras = ListaJSON[3];
            envoltorioElegirTema[0].style.display = "none";
            PalabraSecreta();
            escribidor();
          });
          TPeriodica.addEventListener("click", (e) => {
            listaPalabras = ListaJSON[4];
            envoltorioElegirTema[0].style.display = "none";
            PalabraSecreta();
            escribidor();
          });
        });
        cerrarEligeTema[0].addEventListener("click", () => {
          envoltorioElegirTema[0].style.display = "none";
        });

        //FUNCIONES
        //Elije la palabra secreta que se va a utilizar
        function PalabraSecreta() {
          let indexPalabraSecreta = Math.floor(Math.random() * listaPalabras.length);
          //   console.log(indesPalabraSecreta);
          palabraSecreta = listaPalabras[indexPalabraSecreta];
          console.log(palabraSecreta);
          cifrador(palabraSecreta);
        }

        //Cifrador de la palabra
        function cifrador(palabraSecreta) {
          letrasCifradas = [palabraSecreta.length];
          for (let i = 0; i < palabraSecreta.length; i++) {
            letrasCifradas[i] = false;
          }
        }
        //Comprobador
        function comprobador(e) {
          let esIgual = true;
          let letrasGuardadas;
          let letra = e.target.innerText;

          //Recorre palabra
          letrasGuardadas = letrasCifradas.slice();
          for (let i = 0; i < palabraSecreta.length; i++) {
            fallo = false;
            console.log(fallo);
            //Alaniza si esta la letra o no
            if (letra.toLowerCase() == palabraSecreta.charAt(i).toLowerCase()) {
              letrasCifradas[i] = true;
              e.target.classList.add("acierto");
            }
          }

          //Saber si he fallado o no para restar
          for (let i = 0; i < palabraSecreta.length; i++) {
            if (letrasCifradas[i] == letrasGuardadas[i]) {
              esIgual = true;
            } else {
              esIgual = false;
              break;
            }
          }

          //Lo que pasa si fallo
          console.log("letras guardadas: " + letrasGuardadas);
          console.log("letras cifradas: " + letrasCifradas);
          console.log("son iguales: " + (letrasGuardadas === letrasCifradas));
          record.IntentosRestantes = intento.innerText;
          record.tiempoEmpleado = lahora.innerText;

          console.log(record);
          if (esIgual) {
            intento.innerText--;
            // console.log(`img/intento${intento.innerText}.png`);
            imagen.src = `img/fallo${intento.innerText}.png`;
            e.target.classList.add("error");
            console.log(intento.innerText);
            if (intento.innerText <= 0) {
              imagen.src = `img/hasPerdido.png.png`;
              console.log("has perdido");
              popUpPalabraSecreta.innerHTML = palabraSecreta;
              envoltorio[0].style.display = "block";
              parar();
              recordLocalStorage(record);
            }
          }
          escribidor();
          // console.log(divSecreto.innerHTML);
          if (divSecreto.innerHTML == palabraSecreta) {
            console.log("Has ganado");
            // console.log(envoltorio[0]);
            // console.log(envoltorioGanar[0]);
            envoltorioGanar[0].style.display = "block";
            parar();
            recordLocalStorage(record);
          }
        }
        //Lo que se introduce en el localstorage
        function recordLocalStorage(puntuacionActual) {
          // Las variables json
          let recordAnterior = JSON.parse(localStorage.getItem(palabraSecreta));
          let nuevoRecord = recordAnterior;
          console.log(recordAnterior);
          // Las condiciones para modificar los records
          if (recordAnterior != null) {
            if (recordAnterior.IntentosRestantes < puntuacionActual.IntentosRestantes) {
              nuevoRecord.IntentosRestantes = puntuacionActual.IntentosRestantes;
            }
            if (recordAnterior.tiempoEmpleado > puntuacionActual.tiempoEmpleado) {
              nuevoRecord.tiempoEmpleado = puntuacionActual.tiempoEmpleado;
            }
          } else {
            nuevoRecord = puntuacionActual;
          }
          console.log(nuevoRecord);
          let record =
            "El record es: <br/>Intentos:" +
            nuevoRecord.IntentosRestantes +
            " <br/>" +
            "tiempo usado: " +
            nuevoRecord.tiempoEmpleado;
          localStorage.setItem(palabraSecreta, JSON.stringify(nuevoRecord));
          console.log(record);
          pRecord.innerHTML = record;
        }

        function escribidor() {
          console.log(letrasCifradas);
          divSecreto.innerText = "";
          for (let i = 0; i < palabraSecreta.length; i++) {
            if (letrasCifradas[i]) {
              divSecreto.innerText += palabraSecreta[i];
            } else {
              divSecreto.innerText += "-";
            }
          }
        }

        // function cronometor() {
        //VARIABLES DEL CRONOMETRO
        let start = document.getElementById("start");

        let stop = document.getElementById("stop");

        let botonReset = document.getElementById("reset");
        let lahora = document.getElementById("lahora");
        let miFecha = new Date();
        miFecha.setHours(0, 0, 0, 0);
        let elCrono;
        lahora.innerHTML = "00" + ":" + "00" + ":" + "00";

        //EVENTOS DEL CRONOMETRO
        start.addEventListener("click", (e) => {
          let cont = 0;
          cont++;
          if (cont == 1) {
            elCrono = setInterval(crono, 1000);
            start.style.display = "none";
            stop.style.display = "inline-block";
          }
        });
        stop.addEventListener("click", (e) => {
          parar();
        });
        botonReset.addEventListener("click", (e) => {
          reset();
          start.style.display = "inline-block";
        });

        //FUNCIONES DEL CRONOMETRO
        function crono() {
          let horas = miFecha.getHours();
          let minutos = miFecha.getMinutes();
          let segundos = miFecha.getSeconds();

          segundos += 1;

          if (segundos == 60) {
            segundos = 0;
            minutos += 1;
            miFecha.setMinutes(minutos);
          }

          miFecha.setSeconds(segundos);

          if (horas < 10) {
            horas = "0" + horas;
          }
          if (minutos < 10) {
            minutos = "0" + minutos;
          }
          if (segundos < 10) {
            segundos = "0" + segundos;
          }
          lahora.innerHTML = horas + ":" + minutos + ":" + segundos;
          if (segundos % 10 == 0) {
            intento.innerText--;
            if (intento.innerText <= 0) {
              imagen.src = `img/hasPerdido.png.png`;
              console.log("has perdido");
              popUpPalabraSecreta.innerHTML = palabraSecreta;
              envoltorio[0].style.display = "block";
              parar();
            }
          }
        }

        function parar() {
          clearInterval(elCrono);
        }

        //Con esto puesto no va sin el si
        function reiniciarCrono() {
          miFecha.setHours(0, 0, 0, 0);
          lahora.innerHTML = "00:00:00";
        }

        function reset() {
          location.reload();
          setTimeout(reiniciarCrono);
        }
        // }
        // cronometor();

        //JOSN
        const obtenerTodos = (callback, source) => {
          const request = new XMLHttpRequest();

          request.addEventListener("readystatechange", () => {
            if (request.readyState === 4 && request.status === 200) {
              const respuesta = JSON.parse(request.responseText);
              callback(undefined, respuesta);
            } else if (request.readyState === 4) {
              // console.lg("no se han podido obtener los datos");
              callback("no se han podido obtener los datos", undefined);
            }
          });
          //open
          //p1: tipo de solicitud
          //p2: a quien le hacemos la solicitud (a que endpoint)

          request.open("GET", source);

          //send
          request.send();
        };
        obtenerTodos((error, datos) => {
          getionaRespuesta(error, datos);
        }, "tema.json");

        function getionaRespuesta(error, datos) {
          console.log("callback disparado");
          // console.log(error, datos);
          if (error) {
            console.log("error");
          } else {
            ListaJSON = datos;
            console.log(ListaJSON);
          }
        }
        PalabraSecreta();
        escribidor();
      </script>
      <!--<h2>Datos</h2>
            <?php
            global $current_user;
            wp_get_current_user();
            echo "Hola " . $current_user->display_name . ", estos son tus datos: " . "<br/>";
            echo '<li>' . 'Nombre de ususario: ' .  $current_user->user_login . "</li>";
            echo '<li>' . 'Correo electronico: ' .  $current_user->user_email . "</li>";
            echo '<li>' . 'Nombre: ' .  $current_user->user_firstname . "</li>";
            echo '<li>' . 'Apellido: ' .  $current_user->user_lastname . "</li>";
            echo '<li>' . 'id: ' .  $current_user->ID . "</li>";

            ?>-->

    </div>
<?php
  }
}

//Eliminar items del menu
add_action("admin_menu", "bs_remove_menu_items");

function bs_remove_menu_items()
{
  /*
  remove_menu_page("index.php");
  remove_menu_page("edit.php");
  remove_menu_page("upload.php");
  remove_menu_page("edit.php?post_type=page");
  remove_menu_page("edit-comments.php");

  remove_menu_page("themes.php");
  remove_menu_page("plugins.php");
  remove_menu_page("options-general.php");
  remove_menu_page("pagina-de-datos");
  */

  //Eliminar items del menu condicionalmente
  $user = wp_get_current_user();
  //si no tiene la capacidad de ver el manage_options entonces
  if (!$user->has_cap("manage_options")) {
    remove_menu_page("users.php");
    remove_menu_page("tools.php");
  }
}


