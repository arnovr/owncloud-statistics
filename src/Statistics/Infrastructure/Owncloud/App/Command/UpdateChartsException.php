<?php

namespace Arnovr\Statistics\Infrastructure\Owncloud\App\Command;

class UpdateChartsException extends \Exception
{
    /**
     * @param string $name
     * @return UpdateChartsException
     */
    public static function forUser($name)
    {
        return new self('Could not update charts for ' . $name);
    }
}
