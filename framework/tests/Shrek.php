<?php

namespace Nouracea\Nouramework\Tests;

class Shrek
{
    public function __construct(
        private readonly Fiona $wife
    ) {}

    public function callWife(): Fiona
    {
        return $this->wife;
    }
}
