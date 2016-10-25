<?php

namespace Etudor\PhpGraph\Tests;

use Fhaculty\Graph\Graph;
use PHPUnit_Framework_TestCase;
use Etudor\PhpGraph\UmlGenerator;

class UmlGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getComplexMap
     */
    public function given_3_classes_the_graph_has_3_elements()
    {
        // todo refactor this shit
        $classMap = [
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
        $classNo = count($classMap);

        $uml = new UmlGenerator();
        $graph = $uml->buildGraph($classMap);

        $this->assertEquals($classNo, $graph->getVertices()->count(), sprintf('Fail asserting that the graph has %d elements.', $classNo));
    }

    /**
     * @test
     */
    public function class_wich_depends_on_class2_and_class3_has_connection_to_them()
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

        $generator = new UmlGenerator();

        $graph = $generator->buildGraph($classMap1);

        $class1Vertex = $graph->getVertex('class1');
        $class2Vertex = $graph->getVertex('class2');

        $this->assertTrue($class1Vertex->hasEdgeTo($class2Vertex), 'Class1 does not have a dependency on class2');
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
            'testClass',
        ];

        return [$simpleClass];
    }
}
