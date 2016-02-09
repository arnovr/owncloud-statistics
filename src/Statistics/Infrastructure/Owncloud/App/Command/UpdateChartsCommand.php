<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\App\Command;

use Arnovr\Statistics\Application\Command\AddStorage;
use Arnovr\Statistics\Application\Handler\AddStorageHandler;
use Arnovr\Statistics\Domain\Model\User;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\Scanner\Quota;
use Arnovr\Statistics\Infrastructure\Owncloud\Storage\Scanner\Usage;
use Arnovr\Statistics\Infrastructure\Owncloud\User\UserList;
use Assert\InvalidArgumentException;
use OCA\Statistics\AppInfo\Chart;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateChartsCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('statistics:updatecharts')
            ->setDescription('Manually update the charts, this is also done by owncloud cronjob!');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws UpdateChartsException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = new Chart();
        $container = $app->getContainer();

        $quotaScanner = new Quota();
        $usageScanner = new Usage();

        /** @var UserList $userList */
        $userList = $container->query('UserList');

        /** @var AddStorageHandler $addStorageHandler */
        $addStorageHandler = $container->query('AddStorageHandler');

        $allUsers = $userList->allUsers();
        foreach ($allUsers as $user) {
            try {
                $this->createStorage($user, $usageScanner, $quotaScanner, $addStorageHandler);
            } catch (InvalidArgumentException $e) {
                throw UpdateChartsException::forUser($user->name());
            }
        }
    }

    /**
     * @param User $user
     * @param Usage $usageScanner
     * @param Quota $quotaScanner
     * @param AddStorageHandler $addStorageHandler
     */
    private function createStorage(User $user, Usage $usageScanner, Quota $quotaScanner, AddStorageHandler $addStorageHandler)
    {
        $addStorage = new AddStorage();
        $addStorage->name = $user->name();
        $addStorage->storage = $usageScanner->byUsername($user->name());
        $addStorage->quota = $quotaScanner->byUsername($user->name());
        $addStorageHandler->add($addStorage);
    }
}
