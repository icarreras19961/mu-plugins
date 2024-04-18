<?php

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
