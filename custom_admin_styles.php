<?php

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
