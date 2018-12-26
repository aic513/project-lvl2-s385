<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Parser\parse;
use function Differ\GenDiff\genDiff;

class DifferTest extends TestCase
{
    public function testParser()
    {
        $jsonPath = __DIR__ . '/fixtures/before.json';
        $expected = [
            "host" => "hexlet.io",
            "timeout" => 50,
            "proxy" => "123.234.53.22"
        ];
        $this->assertEquals($expected, parse($jsonPath));
    }

    public function testGenDiff()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $this->assertEquals(
            '{
  host: hexlet.io
+ timeout: 20
- timeout: 50
- proxy: 123.234.53.22
+ verbose: true
}',
            genDiff($beforeJsonFile, $afterJsonFile));
    }
}
