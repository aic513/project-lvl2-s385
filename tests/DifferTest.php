<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\GenDiff\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expected.txt'));
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile));
    }
}
