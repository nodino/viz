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

    $PLUGIN_HOOKS['csrf_compliant']['viz'] = true;
    
    Plugin::registerClass('PluginVizConfig', [
        'classname' => 'PluginVizConfig'
    ]);

    // Hooks
    if (Session::haveRight('config', UPDATE)) {
        $PLUGIN_HOOKS['config_page']['viz'] = 'front/config.form.php';
    }
    
    $PLUGIN_HOOKS['menu_toadd']['viz'] = ['tools' => 'PluginVizMenu'];
}

function plugin_version_viz() {
    return [
        'name'           => 'Viz - iFrame Viewer',
        'version'        => '1.0.0',
        'author'         => 'Arnaud MANSAT',
        'license'        => 'GPLv2+',
        'homepage'       => 'https://votre-site.com',
        'requirements'   => [
            'glpi' => [
                'min' => '10.0.0',
                'max' => '10.0.99'
            ]
        ]
    ];
}

function plugin_viz_check_prerequisites() {
    if (version_compare(GLPI_VERSION, '10.0', 'lt')) {
        echo "Ce plugin nécessite GLPI >= 10.0";
        return false;
    }
    return true;
}

function plugin_viz_check_config() {
    return true;
}

function plugin_viz_install() {
    global $DB;
    
    // Crée la table de configuration
    $query = "CREATE TABLE IF NOT EXISTS `glpi_plugin_viz_configs` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `iframe_url` varchar(255) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $DB->query($query) or die($DB->error());
    
    // Insère une valeur par défaut
    $query = "INSERT INTO `glpi_plugin_viz_configs` (`id`, `iframe_url`) 
              VALUES (1, 'https://example.com')";
    $DB->query($query) or die($DB->error());
    
    return true;
}

function plugin_viz_uninstall() {
    global $DB;
    
    // Supprime la table de configuration
    $query = "DROP TABLE IF EXISTS `glpi_plugin_viz_configs`";
    $DB->query($query) or die($DB->error());
    
    return true;
}
?>
