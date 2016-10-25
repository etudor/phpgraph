<?php

namespace Etudor\PhpGraph\Renderer;

use Fhaculty\Graph\Edge\Base;
use Fhaculty\Graph\Edge\Directed;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;

class GoJs
{
    protected $jsGraph;

    public function render(Graph $graph)
    {
        $this->jsGraph['nodeDataArray'] = $this->getNodes($graph);
        $this->jsGraph['linkDataArray'] = []; //$this->getLinks($graph);

        return $this->jsGraph;
    }

    /**
     * @param Graph $graph
     *
     * @return array
     */
    protected function getNodes(Graph $graph)
    {
        $vertexes = $graph->getVertices();

        $nodes = [];
        $groups = $this->getGroups($graph);

        /** @var Vertex $vertex */
        foreach ($vertexes as $vertex) {
            $tmpNode = [
                'key'  => $vertex->getId(),
                'text' => $vertex->getId(),
            ];

            if ($this->getNodeGroup($vertex, $groups)) {
                $tmpNode['group'] = $this->getNodeGroup($vertex, $groups);
            }

            $nodes[] = $tmpNode;
        }

        foreach ($groups as $groupName => $groupNodes) {
            $nodes[] = [
                'key'  => $groupName,
                'text' => $groupName,
                'isGroup' => 'true',
            ];
        }

        return $nodes;
    }

    /**
     * @param Graph $graph
     *
     * @return array
     */
    protected function getLinks(Graph $graph)
    {
        $edges = $graph->getEdges();

        $links = [];
        /**
         * @var Base|Directed $edge
         */
        foreach ($edges as $edge) {

            $links[] = [
                'from' => $edge->getVertexStart()->getId(),
                'to'   => $edge->getVertexEnd()->getId(),
            ];

        }

        return $links;
    }

    /**
     * @param Graph $graph
     *
     * @return array
     */
    protected function getGroups(Graph $graph)
    {
        $group = [];
        $nodes = $graph->getVertices();
        /** @var Vertex $node */
        foreach ($nodes as $node) {
            $els = explode('\\', $node->getId());

            if (count($els) > 1) {
                $groupName         = $els[0] . '\\' . $els[1];
                $group[$groupName][] = $node->getId();
            }
        }

        return $group;
    }

    protected function getNodeGroup(Vertex $node, $groups)
    {
        foreach ($groups as $groupName => $nodes) {
            if (in_array($node->getId(), $nodes)) {
                return $groupName;
            }
        }
    }
}
