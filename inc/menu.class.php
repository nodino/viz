<?php
/**
 * @file viz/inc/menu.class.php
 * @brief Menu class for the viz plugin
 */

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

class PluginVizMenu extends CommonGLPI {
   
   static $rightname = 'plugin_viz';
   
   /**
    * Get menu name
    */
   static function getMenuName() {
      return __('Viz - Site Web', 'viz');
   }
   
   /**
    * Get menu content
    */
   static function getMenuContent() {
      global $CFG_GLPI;
      
      $menu = [];
      
      // Vérifie qu'une URL est configurée
      $iframe_url = PluginVizConfig::getIframeUrl();
      
      if (empty($iframe_url)) {
         return $menu;
      }
      
      // Menu principal
      $menu['title'] = self::getMenuName();
      $menu['page']  = '/plugins/viz/front/viz.php';
      $menu['icon']  = 'fas fa-globe';
      
      // Options du menu
      $menu['options'] = [
         'view' => [
            'title' => __('Voir le site', 'viz'),
            'page'  => '/plugins/viz/front/viz.php',
            'icon'  => 'fas fa-eye',
         ]
      ];
      
      return $menu;
   }
   
   /**
    * Remove menu when URL is not configured
    */
   static function removeRightsFromSession() {
      // Cette méthode peut être utilisée pour gérer les droits dynamiquement
   }
}
?>
