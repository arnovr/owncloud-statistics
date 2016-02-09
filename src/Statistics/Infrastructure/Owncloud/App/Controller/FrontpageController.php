<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\App\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class FrontpageController extends Controller
{
    /**
     * @param string $appName
     * @param IRequest $request
     */
    public function __construct($appName, IRequest $request)
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
    }

    /**
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     * @return TemplateResponse
     */
    public function run()
    {
        return new TemplateResponse(
            $this->appName,
            'main',
            array('requesttoken' => \OC_Util::callRegister())
        );
    }
}
