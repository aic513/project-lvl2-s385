<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\GenDiff\genDiff;

class DifferTest extends TestCase
{
    public function testPrettyGenDiffJson()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expected.txt'));
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile, 'pretty'));
    }
    
    public function testPrettyGenDiffYaml()
    {
        $beforeYamlFile = __DIR__ . '/fixtures/before.yaml';
        $afterYamlFile = __DIR__ . '/fixtures/after.yaml';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expected.txt'));
        $this->assertEquals($expected, genDiff($beforeYamlFile, $afterYamlFile, 'pretty'));
    }
    
    public function testPrettyInnerJson()
    {
        $beforeInnerJson = __DIR__ . '/fixtures/beforeInner.json';
        $afterInnerJson = __DIR__ . '/fixtures/afterInner.json';
        $expected = __DIR__ . '/fixtures/expectedInner.txt';
        $expected = rtrim(file_get_contents($expected));
        $this->assertEquals($expected, genDiff($beforeInnerJson, $afterInnerJson, 'pretty'));
    }
    
    public function testPlainInnerJson()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expectedPlainFormatResult.txt");
        $beforeInnerJson = __DIR__ . '/fixtures/beforeInner.json';
        $afterInnerJson = __DIR__ . '/fixtures/afterInner.json';
        $this->assertEquals($expected, genDiff($beforeInnerJson, $afterInnerJson, 'plain'));
    }
    
    public function testPlainGenDiffJson()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $expected = file_get_contents(__DIR__ . '/fixtures/expectedPlainFormatResultForSimpleStructure.txt');
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile, 'plain'));
    }
    
    public function testPlainGenDiffYaml()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.yaml';
        $afterJsonFile = __DIR__ . '/fixtures/after.yaml';
        $expected = file_get_contents(__DIR__ . '/fixtures/expectedPlainFormatResultForSimpleStructure.txt');
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile, 'plain'));
    }
    
    public function testJsonGenDiff()
    {
        $beforeJsonFile = __DIR__ . '/fixtures/before.json';
        $afterJsonFile = __DIR__ . '/fixtures/after.json';
        $expected = trim(file_get_contents(__DIR__ . '/fixtures/expectedJson.txt'));
        $this->assertEquals($expected, genDiff($beforeJsonFile, $afterJsonFile, 'json'));
    }
}
