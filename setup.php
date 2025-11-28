<?php
/**
 * @file viz/setup.php
 * @brief Setup file for the viz plugin
 */

// Don't execute directly
if (!defined('GLPI_ROOT')) {
   die("Can't access directly to this file");
}

function plugin_init_viz() {
    global $PLUGIN_HOOKS;

    $plugin = new Plugin();
    $plugin->init(
        __DIR__,
        [
            'name'           => 'viz',
            'version'        => '1.0.0',
            'author'         => 'Arnaud MANSAT',
            'license'        => 'GPLv2+',
            'homepage'       => 'https://votre-site.com',
            'minGlpiVersion' => '10.0', // Adapter à votre version GLPI
            'canBeDisabled'  => true,
            'defaultState'   => 'notinstalled',
            'installcheck'   => 'plugin_viz_check_install',
        ]
    );

    // Hooks
    $PLUGIN_HOOKS['config_page']['viz'] = 'plugin_viz_config_page';
    $PLUGIN_HOOKS['menu_entry']['viz'] = 'plugin_viz_add_menu';
}

function plugin_viz_install() {
   $plugin = new Plugin();
   if ($plugin->isActivated('viz')) {
      // Clé 'iframe_url' pour stocker l'URL saisie par l'utilisateur
      $plugin->addDefaultValues([
         'iframe_url' => 'https://example.com', // URL par défaut
      ]);
   }
   return true;
}

function plugin_viz_uninstall() {
   $plugin = new Plugin();
   $plugin->removeDefaultValues();
   return true;
}

function plugin_viz_check_install() {
    return true;
}
?>