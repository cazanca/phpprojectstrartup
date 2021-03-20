<?php

namespace App\Core;

use App\Helpers\Message;

class Controller
{
    protected View $view;
    protected Message $message;

    public function __construct(string $pathToViews)
    {
        $this->view = new View($pathToViews);
        $this->message = new Message();
    }
}
