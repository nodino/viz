<?php
/**
 * @file viz/setup.php
 * @brief Setup file for the viz plugin
 */

// Don't execute directly
if (!defined('GLPI_ROOT')) {
   die("Can't access directly to this file");
}

/**
 * Init hooks of the plugin
 */
function plugin_init_viz() {
    global $PLUGIN_HOOKS;

    $PLUGIN_HOOKS['csrf_compliant']['viz'] = true;
    
    Plugin::registerClass('PluginVizConfig', [
        'classname' => 'PluginVizConfig'
    ]);

    // Hook de configuration (visible uniquement pour les admins)
    if (Session::haveRight('config', UPDATE)) {
        $PLUGIN_HOOKS['config_page']['viz'] = 'front/config.form.php';
    }
    
    // Hook de menu
    $PLUGIN_HOOKS['menu_toadd']['viz'] = ['tools' => 'PluginVizMenu'];
}

/**
 * Get plugin version and info
 * @return array
 */
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

/**
 * Check prerequisites before installation
 * @return boolean
 */
function plugin_viz_check_prerequisites() {
    if (version_compare(GLPI_VERSION, '10.0', 'lt')) {
        echo "Ce plugin nécessite GLPI >= 10.0";
        return false;
    }
    return true;
}

/**
 * Check configuration process
 * @return boolean
 */
function plugin_viz_check_config() {
    return true;
}
?>
