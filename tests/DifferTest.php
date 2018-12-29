<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\GenDiff\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expected.txt'));
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile));
    }
    
    public function testGenDiffYaml()
    {
        $beforeYamlFile = __DIR__ . '/fixtures/before.yaml';
        $afterYamlFile = __DIR__ . '/fixtures/after.yaml';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expected.txt'));
        $this->assertEquals($expected, genDiff($beforeYamlFile, $afterYamlFile));
    }
    
    public function testInnerJson()
    {
        $beforeInnerJson = __DIR__ . '/fixtures/beforeInner.json';
        $afterInnerJson = __DIR__ . '/fixtures/afterInner.json';
        $expected = __DIR__ . '/fixtures/expectedInner.txt';
        $expected = rtrim(file_get_contents($expected));
        $this->assertEquals($expected, genDiff($beforeInnerJson, $afterInnerJson));
    }
}
