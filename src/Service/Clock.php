<?php

namespace App\Service;

use DateTimeImmutable;

interface Clock
{
    public function now(): DateTimeImmutable;
}