<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\App\Controller;

use Arnovr\Statistics\Infrastructure\Owncloud\User\UserList;
use OCP\AppFramework\ApiController;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;

class UserListController extends ApiController
{
    /**
     * @var UserList
     */
    private $userList;

    /**
     * @param string $appName
     * @param IRequest $request
     * @param UserList $userList
     */
    public function __construct($appName, IRequest $request, UserList $userList)
    {
        parent::__construct(
            $appName,
            $request,
            'GET',
            'Authorization, Content-Type, Accept',
            1728000
        );
        $this->appName = $appName;
        $this->request = $request;
        $this->userList = $userList;
    }

    /**
     * JSON Ajax call
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @return JSONResponse
     */
    public function listUsers()
    {
        $output = [];
        $users = $this->userList->allUsers();
        foreach ($users as $user) {
            $output[] = ["name" => $user->name()];
        }

        return new JSONResponse($output);
    }
}
