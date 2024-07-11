<?php

declare(strict_types=1);

namespace Crell\Config;

interface ConfigWriter
{
    public function write(object $object): void;
}
