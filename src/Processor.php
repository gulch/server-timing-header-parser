<?php

declare(strict_types=1);

namespace gulch\ServerTimingHeaderParser;

use gulch\ServerTimingHeaderParser\Generators\GeneratorContract;

use function count;
use function explode;
use function mb_trim;

/* 
* Server-Timing header parse processor
* https://www.w3.org/TR/server-timing
* 
* example:
* Server-Timing: miss,db;dur=53,app;dur=47.2,cache;desc="Cache Read";dur=23.2
*/

class Processor
{
    protected GeneratorContract $generator;

    public function __construct(GeneratorContract $generator) 
    {
        $this->generator = $generator;
    }

    public function handle(string $header): mixed
    {
        return $this->generator->generate($this->process($header));
    }

    /**
     * process Server-Timing header
     *
     * @param string $header
     * @return array<int,array<string,int|float|string>>|array{}
     */
    protected function process(string $header): array
    {
        $header = mb_trim($header);

        if ('' === $header) return [];

        $result_array = [];

        foreach (explode(',', $header) as $metric) {
            $params = explode(';', $metric);

            // metric name
            $name = mb_trim($params[0]);

            if ($name === '') continue;

            $timing = [
                'name' => $name,
            ];

            for ($i = 1, $c = count($params); $i < $c; ++$i) {
                [$param_name, $param_value] = explode('=', $params[$i]);

                $param_name = mb_trim($param_name);

                if ($param_name === '') continue;

                $param_value = mb_trim($param_value);
                $param_value = mb_trim($param_value, '"');

                $timing[$param_name] = $param_value;
            }

            $result_array[] = $timing;
        }

        return $result_array;
    }
}
