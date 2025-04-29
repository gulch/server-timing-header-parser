<?php

declare(strict_types=1);

namespace ServerTimingHeaderParser;

use function count;
use function explode;
use function floatval;
use function trim;

class Processor
{
    /* 
     * parse Server-Timing header(s)
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
                [$paramName, $paramValue] = explode('=', $params[$i]);

                $paramName = trim($paramName);

                if (!$paramName) continue;

                $paramValue = trim($paramValue);
                $paramValue = trim($paramValue, '"');

                $timing[$paramName] = floatval($paramValue);
            }

            $result_array[] = $timing;
        }

        return $result_array;
    }
}
