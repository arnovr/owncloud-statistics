<?php

namespace OCA\Statistics\AppInfo;

use Arnovr\Statistics\Application\Handler\AddStorageHandler;
use Arnovr\Statistics\Application\UseCase\GetActivityHistory;
use Arnovr\Statistics\Application\UseCase\GetStorageHistory;
use Arnovr\Statistics\Infrastructure\Owncloud\Activity\OwncloudActivityRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\App\Controller\FrontpageController;
use Arnovr\Statistics\Infrastructure\Owncloud\App\Controller\GraphDataProviderController;
use Arnovr\Statistics\Infrastructure\Owncloud\App\Controller\UserListController;
use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\OwncloudStorageRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\RepositoryStrategy\SQLStorageRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\User\LoggedInUser;
use Arnovr\Statistics\Infrastructure\Owncloud\User\UserList;
use \OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

/**
 * @author Arno van Rossum <arno@van-rossum.com>
 */
class Chart extends App
{
    /**
     * @var IAppContainer
     */
    private $container;

    public function __construct(array $urlParams = array())
    {
        parent::__construct('statistics', $urlParams);
        $this->container = $this->getContainer();

        $path = dirname(dirname(__FILE__));
        require_once($path . '/vendor/autoload.php');

        $this->registerControllers();
        $this->registerOwncloudInfrastructure();
        $this->registerApplication();
    }

    private function registerControllers()
    {
        $this->container->registerService('FrontpageController', function($c) {
            return new FrontpageController(
                $c->query('AppName'),
                $c->query('Request')
            );
        });
        $this->container->registerService('UserListController', function($c) {
            return new UserListController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('UserList')
            );
        });
        $this->container->registerService('GraphDataProviderController', function($c) {
            return new GraphDataProviderController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('UseCaseGetStorageHistory'),
                $c->query('UseCaseGetActivityHistory')
            );
        });
    }

    private function registerOwncloudInfrastructure()
    {

        $this->container->registerService('ActivityRepository', function($c) {
            return new OwncloudActivityRepository(
                $c->query('ServerContainer')->getDb()
            );
        });
        $this->container->registerService('StorageRepository', function($c) {
            return new OwncloudStorageRepository(
                new SQLStorageRepository(
                    $c->query('ServerContainer')->getDb()
                )
            );
        });
        $this->container->registerService('FilterFactory', function($c) {
            return new FilterFactory(
                $c->query('LoggedInUser')
            );
        });

        $this->container->registerService('UserList', function() {
            return new UserList();
        });
        $this->container->registerService('LoggedInUser', function() {
            return new LoggedInUser();
        });
    }

    private function registerApplication()
    {

        $this->container->registerService('UseCaseGetActivityHistory', function($c) {
            return new GetActivityHistory(
                $c->query('ActivityRepository'),
                $c->query('FilterFactory')
            );
        });
        $this->container->registerService('UseCaseGetStorageHistory', function($c) {
            return new GetStorageHistory(
                $c->query('StorageRepository'),
                $c->query('FilterFactory')
            );
        });

        $this->container->registerService('AddStorageHandler', function($c) {
            return new AddStorageHandler(
                $c->query('StorageRepository')
            );
        });

    }
}
