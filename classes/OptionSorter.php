<?php

class OptionSorter
{
    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function sort()
    {
        return $this->options[rand(0, count($this->options) - 1)];
    }
}

$sorter = new OptionSorter([1, 2, 3, 4, 5]);