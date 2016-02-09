<?php
namespace Arnovr\Statistics\Infrastructure\Owncloud\Storage\Scanner;

use Assert\Assertion;
use Measurements\Bytes\KiloBytes;
use OC\Files\View as FilesView;

class Quota
{
    /**
     * @param string $userName
     * @return integer
     */
    public function byUsername($userName)
    {
        $view = new FilesView('/' . $userName . '/files');
        $freeSpace = (int) $view->free_space();
        $fileInfo = $view->getFileInfo('/');

        Assertion::notEmpty($fileInfo);

        $usedSpace = $fileInfo->getSize();

        return KiloBytes::allocateUnits($freeSpace + $usedSpace)->units();
    }
}
