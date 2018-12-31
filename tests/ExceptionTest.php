<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use function App\GenDiff\genDiff;

class ExceptionTest extends TestCase
{
    public function testFileEmpty()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $emptyJsonFile = __DIR__ . '/fixtures/empty.json';
        try {
            gendiff($beforeJsonFile, $emptyJsonFile, 'pretty');
            $this->fail('exception expected');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
    
    public function testUnsupportedTypeFile()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $expectedTxtFile = __DIR__ . '/fixtures/expected.txt';
        try {
            gendiff($beforeJsonFile, $expectedTxtFile, 'pretty');
            $this->fail('exception expected');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
    
    public function testUnsupportedFormat()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        try {
            gendiff($beforeJsonFile, $afterJsonFile, 'pretty1');
            $this->fail('exception expected');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
    }
}
