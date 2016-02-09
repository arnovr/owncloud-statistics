<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\App\Controller;

use Arnovr\Statistics\Application\UseCase\GetActivityHistory;
use Arnovr\Statistics\Application\UseCase\GetStorageHistory;
use Assert\InvalidArgumentException;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

/**
 * @author Arno van Rossum <arno@van-rossum.com>
 */
class GraphDataProviderController extends ApiController
{
    /**
     * @var GetStorageHistory
     */
    private $getStorageHistory;
    /**
     * @var GetActivityHistory
     */
    private $getActivityHistory;

    /**
     * @param string $appName
     * @param IRequest $request
     * @param GetStorageHistory $getStorageHistory
     * @param GetActivityHistory $getActivityHistory
     */
    public function __construct(
        $appName,
        IRequest $request,
        GetStorageHistory $getStorageHistory,
        GetActivityHistory $getActivityHistory
    ) {
        parent::__construct(
            $appName,
            $request,
            'GET',
            'Authorization, Content-Type, Accept',
            1728000
        );
        $this->appName = $appName;
        $this->request = $request;
        $this->getStorageHistory = $getStorageHistory;
        $this->getActivityHistory = $getActivityHistory;
    }

    /**
     * JSON Ajax call
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param string $users
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $unit
     * @return JSONResponse
     */
    public function runStorage($users, $dateFrom, $dateTo, $unit)
    {
        try {
            return new JSONResponse(
                $this->getStorageHistory->getStorage(
                    $users,
                    $dateFrom,
                    $dateTo,
                    $unit
                )
            );
        } catch (InvalidArgumentException $e) {
            return new JSONResponse();
        }
    }

    /**
     * JSON Ajax call
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param string $users
     * @param string $dateFrom
     * @param string $dateTo
     * @return JSONResponse
     */
    public function runActivity($users, $dateFrom, $dateTo)
    {
        try {
            return new JSONResponse(
                $this->getActivityHistory->getActivity(
                    $users,
                    $dateFrom,
                    $dateTo
                )
            );
        } catch (InvalidArgumentException $e) {
            return new JSONResponse();
        }
    }
}
