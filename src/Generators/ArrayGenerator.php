<?php

declare(strict_types=1);

namespace gulch\ServerTimingHeaderParser\Generators;

final class ArrayGenerator implements GeneratorContract
{
    public function generate(array $input)
    {
        return $input;
    }
}
