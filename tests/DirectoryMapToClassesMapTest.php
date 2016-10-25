<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\DirectoryMapToClassesMap;
use Etudor\PhpGraph\Extractor\FullClassNameExtractor;
use Etudor\PhpGraph\FileReader;
use PHPUnit_Framework_TestCase;

class DirectoryMapToClassesMapTest extends PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $directoryReader = new DirectoryMapToClassesMap();

        $this->assertInstanceOf(DirectoryMapToClassesMap::class, $directoryReader);
    }

    public function testFilesAreRead()
    {
        $fileReader = $this->getMockBuilder(FileReader::class)
            ->setMethods(['read'])
            ->getMock();
        $fullClassExtractor = $this->getMockBuilder(FullClassNameExtractor::class)
            ->getMock();
        $fileReader->expects($this->exactly(2))->method('read');

        $directoryReader = new DirectoryMapToClassesMap($fileReader, $fullClassExtractor);
        $directoryReader->getClassesFromDirectoryStructure([
            'file1',
            'file2',
        ]);
    }

    /**
     * @test
     */
    public function two_files_returns_two_namespaces()
    {
        $fileReader = $this->getMockBuilder(FileReader::class)
            ->getMock();
        $fullClassExtractor = $this->getMockBuilder(FullClassNameExtractor::class)
            ->setMethods(['extract'])
            ->getMock();

        $namespaces = ['test1\test2\test3', 'test2\test1\test3'];

        $fullClassExtractor->expects($this->at(0))
            ->method('extract')
            ->willReturn($namespaces[0]);

        $fullClassExtractor->expects($this->at(1))
            ->method('extract')
            ->willReturn($namespaces[1]);

        $directoryReader = new DirectoryMapToClassesMap($fileReader, $fullClassExtractor);

        $classes = $directoryReader->getClassesFromDirectoryStructure([
            'file1',
            'file2',
        ]);

        $this->assertEquals(json_encode($namespaces), json_encode($classes), 'failed to assert that list of files returned coresponding namespaces');
    }
}
