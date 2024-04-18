<?php

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
