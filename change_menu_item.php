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
