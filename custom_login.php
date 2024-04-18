<?php

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
