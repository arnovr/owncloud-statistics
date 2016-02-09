<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\Activity;

use Arnovr\Statistics\Domain\Model\Activity\Activity;
use Arnovr\Statistics\Domain\Model\Activity\ActivityCollection;
use Arnovr\Statistics\Domain\Model\Activity\ActivityRepository;
use Arnovr\Statistics\Domain\Model\Filter\Filter;
use Arnovr\Statistics\Domain\Model\User;
use OCP\AppFramework\Db\Mapper;
use OCP\IDb;

class OwncloudActivityRepository extends Mapper implements ActivityRepository
{
    /**
     * SQLStorageRepository constructor.
     * @param IDb $db
     */
    public function __construct(IDb $db)
    {
        parent::__construct($db, 'uc_storageusage', null);
    }

    /**
     * @param Filter $filter
     * @return ActivityCollection
     */
    public function find(Filter $filter)
    {
        $qMarks = str_repeat('?,', count($filter->users()->asArray()) - 1) . '?';
        $sql = 'SELECT timestamp, user, count(1) as activities, user FROM *PREFIX*activity
WHERE timestamp >= ? AND timestamp < ? AND user IN (' . $qMarks . ') GROUP BY user';
        $query = $this->db->prepareQuery($sql);
        $params = array_merge(
            [
                $filter->dateRange()->dateFrom()->dateTime()->getTimestamp(),
                $filter->dateRange()->dateTo()->dateTime()->getTimestamp(),
            ],
            $filter->users()->asArray()
        );
        $result = $query->execute(
            $params
        );

        return $this->parseResultIntoCollection($result);
    }

    /**
     * @param $result
     * @return ActivityCollection
     */
    private function parseResultIntoCollection($result)
    {
        $activityCollection = new ActivityCollection();
        while ($row = $result->fetch()) {
            $activityCollection->add(
                $this->mapActivityRowToActivity($row)
            );
        }
        return $activityCollection;
    }


    /**
     * @param array $row
     * @return Activity
     */
    private function mapActivityRowToActivity($row)
    {
        $dateTime = new \DateTime();
        return Activity::withUserDateActivityCount(
            User::named($row['user']),
            $dateTime->setTimestamp((int) $row['timestamp']),
            (int) $row['activities']
        );
    }
}
