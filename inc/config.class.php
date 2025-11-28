<?php
/**
 * @file viz/inc/config.class.php
 * @brief Configuration class for the viz plugin
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginVizConfig extends CommonDBTM {
   
   static $rightname = 'config';
   
   /**
    * Get the singleton configuration
    * @return PluginVizConfig|false
    */
   static function getConfig() {
      global $DB;
      
      $config = new self();
      if ($config->getFromDB(1)) {
         return $config;
      }
      return false;
   }
   
   /**
    * Get the configured iframe URL
    * @return string
    */
   static function getIframeUrl() {
      $config = self::getConfig();
      if ($config) {
         return $config->fields['iframe_url'];
      }
      return '';
   }
   
   /**
    * Update the iframe URL
    * @param string $url
    * @return bool
    */
   static function setIframeUrl($url) {
      global $DB;
      
      $config = new self();
      if ($config->getFromDB(1)) {
         return $config->update([
            'id' => 1,
            'iframe_url' => $url
         ]);
      }
      return false;
   }
   
   /**
    * Display the configuration form
    */
   function showConfigForm() {
      global $CFG_GLPI;
      
      if (!Session::haveRight('config', UPDATE)) {
         return false;
      }
      
      $config = self::getConfig();
      $iframe_url = $config ? $config->fields['iframe_url'] : '';
      
      echo "<div class='center'>";
      echo "<form method='post' action='" . $CFG_GLPI["root_doc"] . "/plugins/viz/front/config.form.php'>";
      
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr class='tab_bg_1'>";
      echo "<th colspan='2'>" . __('Configuration du plugin Viz', 'viz') . "</th>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td style='width: 30%;'>";
      echo __('URL du site à intégrer', 'viz');
      echo "</td>";
      echo "<td>";
      echo "<input type='url' name='iframe_url' value='" . htmlspecialchars($iframe_url, ENT_QUOTES, 'UTF-8') . "' 
             size='80' placeholder='https://exemple.com' required>";
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_1'>";
      echo "<td colspan='2'>";
      echo "<div class='alert alert-warning'>";
      echo "<i class='fas fa-exclamation-triangle'></i> ";
      echo __('Attention : certains sites bloquent l\'affichage en iframe (X-Frame-Options header)', 'viz');
      echo "</div>";
      echo "</td>";
      echo "</tr>";
      
      echo "<tr class='tab_bg_2'>";
      echo "<td colspan='2' class='center'>";
      echo "<input type='submit' name='update' class='btn btn-primary' value='" . __('Sauvegarder', 'viz') . "'>";
      echo "</td>";
      echo "</tr>";
      
      echo "</table>";
      Html::closeForm();
      echo "</div>";
      
      return true;
   }
   
   /**
    * Get table name
    */
   static function getTable($classname = null) {
      return 'glpi_plugin_viz_configs';
   }
   
   /**
    * Get type name
    */
   static function getTypeName($nb = 0) {
      return __('Configuration Viz', 'viz');
   }
}
?>
