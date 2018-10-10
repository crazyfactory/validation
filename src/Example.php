<?php

namespace CrazyFactory\Boilerplate;

class Example
{
    private $maxItems = 0;
    private $items = [];

    /**
     * Example constructor.
     * @param int $maxItems
     */
    public function __construct(int $maxItems)
    {
        $this->maxItems = $maxItems;
    }

    /**
     * @param $item mixed anything to add to stack
     * @throws \Exception
     */
    public function add($item)
    {
        if (count($this->items) > $this->maxItems) {
            throw new \Exception('Stack Overflows');
        }
        $this->items[] = $item;
    }
}
