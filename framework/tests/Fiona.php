<?php

namespace Nouracea\Nouramework\Tests;

class Fiona
{
    public function __construct(
        private readonly Donkey $friend,
        private readonly RyanGosling $idol,
    ) {}

    public function callFriend(): Donkey
    {
        return $this->friend;
    }

    public function manOfMyDreams(): RyanGosling
    {
        return $this->idol;
    }
}
