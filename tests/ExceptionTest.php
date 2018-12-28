<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\GenDiff\genDiff;

class ExceptionTest extends TestCase
{
    public function testFileEmpty()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $emptyJsonFile = __DIR__ . '/fixtures/empty.json';
        try {
            gendiff($beforeJsonFile, $emptyJsonFile);
            $this->fail('exception expected');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
    
    public function testUnsuportedTypeFile()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $expectedTxtFile = __DIR__ . '/fixtures/expected.txt';
        try {
            gendiff($beforeJsonFile, $expectedTxtFile);
            $this->fail('exception expected');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
