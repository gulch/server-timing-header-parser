<?php

namespace gulch\ServerTimingHeaderParser\Tests;

use PHPUnit\Framework\TestCase;
use gulch\ServerTimingHeaderParser\Processor;

class GeneralHeaderTest extends TestCase
{
    public function testGeneralHeader(): void
    {
        $processor = new Processor();

        $header = '01_bootstrap;dur=4.4,02_app;dur=17.37,total;dur=21.91';

        $result = [
            [
                'name' => '01_bootstrap',
                'dur' => 4.4
            ],
            [
                'name' => '02_app',
                'dur' => 17.37,
            ],
            [
                'name' => 'total',
                'dur' => 21.91,
            ]
        ];

        $this->assertSame(
            $result,
            $processor->process($header)
        );
    }
}
