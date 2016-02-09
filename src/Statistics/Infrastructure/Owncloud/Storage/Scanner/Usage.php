<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\Storage\Scanner;

use Measurements\Bytes\KiloBytes;

use OC\Files\Storage\Home;

class Usage
{
    /**
     * @param string $userName
     * @return integer
     */
    public function byUsername($userName)
    {
        $data = new Home(
            array(
                'user' => \OC_User::getManager()->get($userName)
            )
        );

        return KiloBytes::allocateUnits(
            $data->getCache('files')->calculateFolderSize('files')
        )->units();
    }
}
