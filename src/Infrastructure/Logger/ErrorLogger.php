<?php

namespace App\Infrastructure\Logger;

use App\Infrastructure\Observer\IObservable;
use App\Infrastructure\Observer\IObserver;
use App\Infrastructure\Parser\FeedParserBase;

class ErrorLogger implements IObserver
{
    public function notify(IObservable $objSource, $strMessage)
    {
        if ($objSource instanceof FeedParserBase) {
            printf('ERROR -> %s.' . PHP_EOL, $strMessage);
        }
    }
}
