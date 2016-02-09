<?php
require_once('dependencies.php');

use OCA\Statistics\AppInfo\Chart;

$app = new Chart();
$container = $app->getContainer();

?>
<div class="app" ng-app="Statistics">
    <div id="app" ng-controller="StatisticsController as Charts">
        <div id="app-navigation">
            <?php include_once('userlist.php'); ?>
        </div>
        <div id="app-content">
            <div>
                <?php include_once('chartsettings.php'); ?>
            </div>

            <div id="chart-content">
                <?php include_once('chartcontent.php'); ?>
            </div>
        </div>
    </div>
</div>

<?php include('javascripttranslations.php'); ?>