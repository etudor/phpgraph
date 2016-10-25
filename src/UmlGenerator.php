<?php

namespace Etudor\PhpGraph;

use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Exception\OutOfBoundsException;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

class UmlGenerator
{
    /**
     * @param $classMap
     *
     * @return Graph
     */
    public function buildGraph($classMap)
    {
        $graph = new Graph();
        foreach ($classMap as $class => $dependencies) {
            $vertex = $this->getOrNewVertex($graph, $class);
            if (is_array($dependencies)) {
                $this->addDependencies($dependencies, $graph, $vertex);
            }
        }

        return $graph;
    }

    /**
     * @param Graph  $graph
     * @param string $dep
     *
     * @return Vertex
     */
    protected function getOrNewVertex($graph, $dep)
    {
        try {
            $newVertex = $graph->getVertex($dep);
        } catch (OutOfBoundsException $exception) {
            $newVertex = new Vertex($graph, $dep);
        }

        return $newVertex;
    }

    /**
     * @param $dependencies
     * @param $graph
     * @param $vertex
     */
    protected function addDependencies(array $dependencies, $graph, $vertex)
    {
        foreach ($dependencies as $dep) {
            $newVertex = $this->getOrNewVertex($graph, $dep);

            $edge = new Directed($vertex, $newVertex);
            $vertex->addEdge($edge);
        }
    }
}
