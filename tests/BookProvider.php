<?php

namespace Swis\PHPStan\Reflection\Tests;

use Faker\Provider\Base;

class BookProvider extends Base
{
    public function customBookIsbn(): string
    {
        return $this->generator->ean13();
    }
}
