<?php
/**
 * @file viz/front/config.form.php
 * @brief Form handler for the plugin configuration
 */

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// S'assure que l'utilisateur a les droits pour modifier la configuration des plugins
Session::checkRight('config', UPDATE);

// Affiche la page de configuration et gère la soumission (voir hook.php)
plugin_viz_config_page();
?>