<?php

declare(strict_types=1);

namespace gulch\ServerTimingHeaderParser\Generators;

interface GeneratorContract
{
    public function generate(array $input);
}
