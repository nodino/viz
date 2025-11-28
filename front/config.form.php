<?php
/**
 * @file viz/front/config.form.php
 * @brief Form handler for the plugin configuration
 */

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// Vérifie que l'utilisateur a les droits pour modifier la configuration
Session::checkRight('config', UPDATE);

$config = new PluginVizConfig();

// Traitement du formulaire
if (isset($_POST['update'])) {
   
   // Validation et nettoyage de l'URL
   $iframe_url = filter_var($_POST['iframe_url'], FILTER_VALIDATE_URL);
   
   if ($iframe_url === false) {
      Session::addMessageAfterRedirect(
         __('URL invalide. Veuillez saisir une URL valide.', 'viz'),
         false,
         ERROR
      );
   } else {
      // Sauvegarde de la configuration
      if (PluginVizConfig::setIframeUrl($iframe_url)) {
         Session::addMessageAfterRedirect(
            __('Configuration sauvegardée avec succès', 'viz'),
            false,
            INFO
         );
      } else {
         Session::addMessageAfterRedirect(
            __('Erreur lors de la sauvegarde de la configuration', 'viz'),
            false,
            ERROR
         );
      }
   }
   
   Html::back();
}

// Affichage de la page de configuration
Html::header(__('Configuration Viz', 'viz'), $_SERVER['PHP_SELF'], "config", "plugins");

$config->showConfigForm();

Html::footer();
?>
