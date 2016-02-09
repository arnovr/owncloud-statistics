<?php

$path = dirname(dirname(__FILE__));
require_once($path . '/vendor/autoload.php');
$application->add(new Arnovr\Statistics\Infrastructure\Owncloud\App\Command\UpdateChartsCommand());