<?php

namespace Tests\UmlGenerator;

use Fhaculty\Graph\Graph;
use PHPUnit_Framework_TestCase;
use UmlGenerator;

class UmlGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function testItWorks()
    {
        $this->assertTrue(true);
    }

    public function testUmlGenerator()
    {
        $uml = new UmlGenerator();

        $directory = "src/";

        $classes = $uml->buildUml($directory);
        $html = $uml->render($classes);

        $this->assertTrue(strlen($html) > 0);
    }

    public function testBuildUmlCreatesAGraph()
    {
        $uml = new UmlGenerator();
        $umlTree = $uml->buildUml('src/');
        $this->assertInstanceOf(Graph::class, $umlTree);
    }

    /**
     * @test
     * @dataProvider getSimpleClass
     */
    public function given_a_class_in_directory_the_graph_has_one_leaf($classes)
    {
        $uml = new UmlGenerator();
        $graph = $uml->buildUml($classes);
        $this->assertEquals(1, $graph->getVertices()->count());
    }

    /**
     * @test
     * @dataProvider getComplexMap
     */
    public function given_3_classes_the_graph_has_3_elements($classMap)
    {
        $classNo = count($classMap);

        $uml = new UmlGenerator();
        $graph = $uml->buildGraph($classMap);

        $this->assertEquals($classNo, $graph->getVertices()->count(), sprintf('Fail asserting that the graph has %d elements.', $classNo));
    }

    public function getComplexMap()
    {
        $classMap1 = [
            'class1' => [
                'class2',
                'class3',
            ],
            'class2' => [
                'class1',
            ],
            'class3' => [
                'class1',
                'class2',
            ],
        ];

        return [$classMap1];
    }

    public function getSimpleClass()
    {
        $simpleClass = [
            'testClass'
        ];

        return [$simpleClass];
    }
}
