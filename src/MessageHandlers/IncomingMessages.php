<?php

namespace App\MessageHandlers;

use App\Messages\MyMessage;

class IncomingMessages
{
    public function __invoke(MyMessage $message)
    {
        echo "Message!!";
    }
}
