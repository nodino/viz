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
 * Hook to add a menu entry for the custom iFrame page
 * @return array
 */
function plugin_viz_add_menu() {
    global $CFG_GLPI;
    
    $plugin = new Plugin();
    $plugin->init('viz');

    // On vérifie qu'une URL est configurée avant d'afficher le bouton
    $iframe_url = $plugin->getOption('iframe_url');

    if (empty($iframe_url)) {
        return [];
    }

    $menu = [];

    // Ajoute une entrée de menu dans la barre principale (Outils)
    $menu['tools'] = [
        'title'    => __('iFrame Externe', 'viz'),
        'page'     => $CFG_GLPI["root_doc"].'/plugins/viz/front/myiframe.php',
        'icon'     => 'fas fa-globe', // Icône monde
        'tooltip'  => __('Afficher le site web configuré dans un iFrame', 'viz'),
        'links'    => []
    ];

    return $menu;
}

/**
 * Hook to display and manage plugin configuration options
 */
function plugin_viz_config_page() {
    global $CFG_GLPI;

    $plugin = new Plugin();
    $plugin->init('viz');

    // Vérifie si le formulaire a été soumis
    if (isset($_POST['update'])) {
        Session::checkRight('config', UPDATE); // Vérifie les droits de modification
        $plugin->saveOptions($_POST);
        Html::back();
    }

    // Affichage de la page de configuration
    Html::header(__('Configuration iFrame', 'viz'));
    
    $current_url = $plugin->getOption('iframe_url');

    echo "<div class='container-fluid'>";
    echo "<h2>" . __('URL du site à intégrer', 'viz') . "</h2>";
    // Le formulaire poste vers config.form.php qui appelle cette fonction pour traiter la soumission
    echo "<form method='post' action='" . $CFG_GLPI["root_doc"] . "/plugins/viz/front/config.form.php'>";

    echo "<table class='tab_cadre_fixe'>";

    // Champ de saisie de l'URL
    echo "<tr class='tab_bg_1'>";
    echo "<td style='width: 20%;'>" . __('URL complète du site', 'viz') . "</td>";
    echo "<td>";
    echo "<input type='url' name='iframe_url' value='" . $current_url . "' size='100' placeholder='Exemple: https://www.monsite.com/' required>";
    echo "<div class='info'>" . __('Attention: de nombreux sites (comme Google) bloquent l\'affichage via iFrame (X-Frame-Options).', 'viz') . "</div>";
    echo "</td>";
    echo "</tr>";

    echo "<tr class='tab_bg_2'>";
    echo "<td colspan='2' class='center'>";
    echo "<input type='submit' name='update' class='submit' value='" . __('Sauvegarder', 'viz') . "'>";
    echo "</td>";
    echo "</tr>";
    
    echo "</table>";
    echo "</form>";
    echo "</div>";

    Html::footer();
}
?>