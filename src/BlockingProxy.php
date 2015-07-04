<?php

namespace Clue\React\Block;

use Clue\React\Block\Blocker;
use React\Promise\PromiseInterface;

class BlockingProxy
{
    public function __construct($instance, Blocker $blocker)
    {
        $this->instance = $instance;
        $this->blocker = $blocker;
    }

    public function __call($name, $args)
    {
        $result = call_user_func_array(array($this->instance, $name), $args);

        if ($result instanceof PromiseInterface) {
            $result = $this->blocker->awaitOne($promise);
        }

        return $result;
    }
}
