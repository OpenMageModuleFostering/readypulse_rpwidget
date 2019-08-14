<?php
//ini_set('display_errors', 1);
require_once('iRPWidgetSettings.php');
require_once('RPWidget.php');

$link = 'http://widgets.readypulse.com/curations/1/embed/api.html?width=400&height=600';

if($_GET['json'] == 'true') $link = 'http://widgets.readypulse.com/curations/1/embed/api.json?width=400&height=600';

$settings = array(
    'id' => 1,
    'nativelook' => false,
    'widgeturl' => $link,
    'width' => 500,
    'height' => 400,
    'type' => 'feed',
    'theme' => '4',
    'show-header' => true,
    'show-footer' => true,
);

if($_GET['json'] == 'true') {
    $settings['nativelook'] = true;
    echo '<link rel="stylesheet" href="rpwidget.css" />';
}

$rpwidget = New RPWidget($settings);

$data = $rpwidget->getXTemplate();

print($data);
?>
