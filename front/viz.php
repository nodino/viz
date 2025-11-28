<?php
/**
 * @file viz/front/viz.php
 * @brief Displays the configured URL in an iFrame within GLPI
 */

define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// Vérifie que l'utilisateur est connecté
Session::checkLoginUser();

// Récupère l'URL configurée
$iframe_url = PluginVizConfig::getIframeUrl();

// Vérifie si l'URL est configurée
if (empty($iframe_url)) {
    Html::header(__('Viz - Site Web', 'viz'), $_SERVER['PHP_SELF']);
    
    echo "<div class='container-fluid'>";
    echo "<div class='alert alert-warning'>";
    echo "<i class='fas fa-exclamation-triangle fa-2x'></i> ";
    echo "<h3>" . __('Configuration requise', 'viz') . "</h3>";
    echo "<p>" . __('L\'URL du site web n\'est pas configurée.', 'viz') . "</p>";
    
    if (Session::haveRight('config', UPDATE)) {
        echo "<p>";
        echo "<a href='" . $CFG_GLPI['root_doc'] . "/plugins/viz/front/config.form.php' class='btn btn-primary'>";
        echo "<i class='fas fa-cog'></i> ";
        echo __('Configurer maintenant', 'viz');
        echo "</a>";
        echo "</p>";
    } else {
        echo "<p>" . __('Veuillez contacter un administrateur pour configurer le plugin.', 'viz') . "</p>";
    }
    
    echo "</div>";
    echo "</div>";
    
    Html::footer();
    exit();
}

// Validation supplémentaire de l'URL (sécurité)
if (filter_var($iframe_url, FILTER_VALIDATE_URL) === false) {
    Html::header(__('Viz - Site Web', 'viz'), $_SERVER['PHP_SELF']);
    
    echo "<div class='container-fluid'>";
    echo "<div class='alert alert-danger'>";
    echo "<i class='fas fa-exclamation-circle fa-2x'></i> ";
    echo "<h3>" . __('Erreur de configuration', 'viz') . "</h3>";
    echo "<p>" . __('L\'URL configurée est invalide.', 'viz') . "</p>";
    echo "</div>";
    echo "</div>";
    
    Html::footer();
    exit();
}

// Affichage de la page avec l'iframe
Html::header(__('Viz - Site Web', 'viz'), $_SERVER['PHP_SELF']);

echo "<div class='container-fluid' style='padding: 0;'>";
echo "<div style='margin-bottom: 10px;'>";
echo "<h2><i class='fas fa-globe'></i> " . __('Site Web Externe', 'viz') . "</h2>";
echo "<small class='text-muted'>" . htmlspecialchars($iframe_url, ENT_QUOTES, 'UTF-8') . "</small>";
echo "</div>";

// L'iframe avec échappement de l'URL pour la sécurité
echo "<iframe 
    src='" . htmlspecialchars($iframe_url, ENT_QUOTES, 'UTF-8') . "' 
    style='width: 100%; height: calc(100vh - 200px); border: 1px solid #ddd; border-radius: 4px;'
    title='" . __('Site Web Externe', 'viz') . "'
    sandbox='allow-same-origin allow-scripts allow-popups allow-forms'
    allowfullscreen>
</iframe>";

echo "<div class='alert alert-info' style='margin-top: 10px;'>";
echo "<i class='fas fa-info-circle'></i> ";
echo __('Si le site ne s\'affiche pas, il est possible qu\'il bloque l\'intégration en iframe (politique X-Frame-Options).', 'viz');
echo "</div>";

echo "</div>";

Html::footer();
?>
