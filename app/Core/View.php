<?php

namespace App\Core;

use League\Plates\Engine;

class View
{
    private Engine $engine;

    public function __construct(string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT)
    {
        $this->engine = Engine::create($path, $ext);
    }

    public function render(string $template, array $data)
    {
        echo $this->engine->render($template, $data);
    }

    public function template(string $template, array $data)
    {
        return $this->engine->render($template, $data);
    }

    public function engine()
    {
        return $this->engine;
    }
}
