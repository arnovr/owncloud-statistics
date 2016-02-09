<?php

$styles = [
    'style'
];
foreach ($styles as $style) {
    style('statistics', $style);
}
$scripts = [
    'vendor/angular/angular',
    'vendor/angular-route/angular-route',
    'vendor/angular-bootstrap/ui-bootstrap.min',
    'vendor/angular-bootstrap/ui-bootstrap-tpls.min',
    'vendor/angular-resource/angular-resource.min',
    'vendor/canvasjs/canvas.min',
    'public/app',
    'public/animation'
];
foreach ($scripts as $script) {
    script('statistics', $script);
}