<?php
namespace OCA\Statistics\AppInfo;

$application = new Chart();
$application->registerRoutes($this, array(
    'routes' => array(
        array(
            'name' => 'Frontpage#run',
            'url' => '/',
            'verb' => 'GET'
        ),
        array(
            'name' => 'UserList#listUsers',
            'url' => '/users/list',
            'verb' => 'GET'
        ),
        array(
            'name' => 'GraphDataProvider#runStorage',
            'url' => '/graph/data/storage',
            'verb' => 'GET'
        ),
        array(
            'name' => 'GraphDataProvider#runActivity',
            'url' => '/graph/data/activity',
            'verb' => 'GET'
        )
    )
));