<?php
/**
 * @file viz/hook.php
 * @brief Hook file for the viz plugin
 */

// Don't execute directly
if (!defined('GLPI_ROOT')) {
   die("Can't access directly to this file");
}

/**
 * Plugin install process
 * @return boolean
 */
function plugin_viz_install() {
    global $DB;
    
    // Crée la table de configuration
    $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_viz_configs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `iframe_url` varchar(500) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $DB->queryOrDie($query, $DB->error());
    
    // Insère une valeur par défaut
    $query = "INSERT INTO `glpi_plugin_viz_configs` (`id`, `iframe_url`) 
              VALUES (1, 'https://example.com')
              ON DUPLICATE KEY UPDATE `id`=1";
    $DB->queryOrDie($query, $DB->error());
    
    return true;
}

/**
 * Plugin uninstall process
 * @return boolean
 */
function plugin_viz_uninstall() {
    global $DB;
    
    // Supprime la table de configuration
    $query = "DROP TABLE IF EXISTS `glpi_plugin_viz_configs`";
    $DB->queryOrDie($query, $DB->error());
    
    return true;
}
?>
