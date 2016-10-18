<?php

class UmlGenerator
{
    public function buildUml($directory)
    {
        $graph      = new Fhaculty\Graph\Graph();
        $newVertice = new \Fhaculty\Graph\Vertex($graph, '1');

        return $graph;
    }

    public function render($classes)
    {
        return ' ';
    }

    public function buildGraph($classMap)
    {
        $graph = new Fhaculty\Graph\Graph();
        foreach ($classMap as $class => $dependencies) {
            $vertex = new \Fhaculty\Graph\Vertex($graph, $class);
        }

        return $graph;
    }
}
