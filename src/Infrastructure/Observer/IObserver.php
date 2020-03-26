<?php

namespace App\Infrastructure\Observer;

interface IObserver
{
    public function notify(IObservable $objSource, $strMessage);
}
