<?php

declare(strict_types=1);

namespace gulch\ServerTimingHeaderParser;

use function count;
use function explode;
use function floatval;
use function trim;

class Processor
{
    /* 
     * process Server-Timing header
     * https://www.w3.org/TR/server-timing
     * 
     * example -> Server-Timing: miss,db;dur=53,app;dur=47.2,cache;desc="Cache Read";dur=23.2
     */
    public function process(string $header): array
    {
        $header = trim($header);

        if ('' === $header) return [];

        $result_array = [];

        foreach (explode(',', $header) as $item) {
            $params = explode(';', $item);

            $timing['name'] = $params[0];

            for ($i = 1, $c = count($params); $i < $c; ++$i) {
                [$param_name, $param_value] = explode('=', $params[$i]);

                $param_name = trim($param_name);

                if (!$param_name) continue;

                $param_value = trim($param_value);
                $param_value = trim($param_value, '"');

                $timing[$param_name] = floatval($param_value);
            }

            $result_array[] = $timing;
        }

        return $result_array;
    }
}
