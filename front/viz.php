<?php
/**
 * @file viz/front/viz.php
 * @brief Displays the configured URL in an iFrame within GLPI
 */

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Session::checkLoginUser(); // Vérifie que l'utilisateur est connecté

$plugin = new Plugin();
$plugin->init('viz');
$iframe_url = $plugin->getOption('iframe_url'); 

// Vérifie si l'URL est configurée
if (empty($iframe_url)) {
    Html::header(__('Erreur iFrame', 'viz'));
    echo "<div class='container-fluid'>";
    echo "<h2>" . __('Erreur de Configuration', 'viz') . "</h2>";
    echo "<div class='info'>" . __('L\'URL du site web n\'est pas configurée. Veuillez aller dans Configuration > Plugins > Mon iFrame pour saisir l\'URL.', 'viz') . "</div>";
    echo "</div>";
    Html::footer();
    exit();
}

Html::header(__('iFrame Site Web', 'viz'));

echo "<div class='container-fluid'>";
echo "<h2>" . __('Site Web Externe', 'viz') . "</h2>";

// Le code de l'iframe
// Note: Utilisation de '100vh' pour une hauteur maximale dans la fenêtre GLPI
echo "<iframe src='" . $iframe_url . "' style='width: 100%; height: 90vh; border: none;'></iframe>";

echo "</div>";

Html::footer();

?>
