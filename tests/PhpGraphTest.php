<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\DependencyAdder;
use Etudor\PhpGraph\DirectoryMapToClassesMap;
use Etudor\PhpGraph\DirectoryScanner;
use Etudor\PhpGraph\Includer\FileIncluderInterface;
use Etudor\PhpGraph\PhpGraph;

class PhpGraphTest extends \PHPUnit_Framework_TestCase
{
    protected $directoryScannerMock;

    protected $includerMock;

    protected $classGetterMock;

    protected $depenedencyAdderMock;

    public function setUp()
    {
        $this->directoryScannerMock = $this->getMockBuilder(DirectoryScanner::class)->getMock();
        $this->includerMock         = $this->getMockBuilder(FileIncluderInterface::class)->getMock();
        $this->classGetterMock      = $this->getMockBuilder(DirectoryMapToClassesMap::class)->getMock();
        $this->depenedencyAdderMock = $this->getMockBuilder(DependencyAdder::class)->getMock();

        $this->directoryScannerMock->method('scan')->willReturn([]);
        $this->classGetterMock->method('getClassesFromDirectoryStructure')->willReturn([]);
    }

    /**
     * @test
     */
    public function is_instantiable()
    {
        $classMap = new PhpGraph();

        $this->assertInstanceOf(PhpGraph::class, $classMap);
    }

    /**
     * @test
     * @dataProvider directoryProvider
     */
    public function given_a_directory_it_scans_directory($dir, $autoload)
    {
        $this->directoryScannerMock->expects($this->once())->method('scan')->willReturn([]);

        $classMapCreator = $this->createPhpGraph();
        $classMap = $classMapCreator->create($dir, $autoload);
    }

    /**
     * @test
     * @dataProvider directoryProvider
     */
    public function given_a_directory_it_get_the_classes_from_directory_map($dir, $autoload)
    {
        $this->classGetterMock->expects($this->once())->method('getClassesFromDirectoryStructure')->willReturn([]);

        $classMapCreator = $this->createPhpGraph();
        $classMap = $classMapCreator->create($dir, $autoload);
    }

    /**
     * @test
     * @dataProvider directoryProvider
     */
    public function given_an_autoload_file_it_includes_the_file($dir, $autoload)
    {
        $this->includerMock->expects($this->once())->method('includeFile');

        $classMapCreator = $this->createPhpGraph();
        $classMap = $classMapCreator->create($dir, $autoload);
    }

    /**
     * @test
     * @dataProvider directoryProvider
     */
    public function given_classes_loaded_it_adds_dependencies($dir, $autoload)
    {
        $this->depenedencyAdderMock->expects($this->once())->method('addDependencies');

        $classMapCreator = $this->createPhpGraph();
        $classMap = $classMapCreator->create($dir, $autoload);
    }

    public function directoryProvider()
    {
        return [
            [
                'dir', 'autoload'
            ]
        ];
    }

    /**
     * @return PhpGraph
     */
    protected function createPhpGraph()
    {
        return new PhpGraph(
            $this->directoryScannerMock,
            $this->includerMock,
            $this->depenedencyAdderMock,
            $this->classGetterMock
        );
    }
}

