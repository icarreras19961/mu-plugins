<?php

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
