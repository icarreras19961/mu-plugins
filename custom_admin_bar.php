<?php

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
