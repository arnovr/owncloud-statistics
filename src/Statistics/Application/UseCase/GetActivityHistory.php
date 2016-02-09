<?php


namespace Arnovr\Statistics\Application\UseCase;

use Arnovr\Statistics\Domain\Model\Activity\ActivityRepository;
use Arnovr\Statistics\Infrastructure\Owncloud\FilterFactory;

class GetActivityHistory
{
    /**
     * @var ActivityRepository
     */
    private $activityRepository;

    /**
     * @var FilterFactory
     */
    private $filterFactory;

    /**
     * GetActivityHistory constructor.
     * @param ActivityRepository $activityRepository
     * @param FilterFactory      $filterFactory
     */
    public function __construct(
        ActivityRepository $activityRepository,
        FilterFactory $filterFactory
    ) {
        $this->activityRepository = $activityRepository;
        $this->filterFactory = $filterFactory;
    }

    /**
     * @param string $users
     * @param string $dateFrom
     * @param string $dateTo
     * @return \JsonSerializable
     */
    public function getActivity($users, $dateFrom, $dateTo)
    {
        return $this->activityRepository->find(
            $this->filterFactory->createFrom(
                $users,
                $dateFrom,
                $dateTo
            )
        );
    }
}
