<?php

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
