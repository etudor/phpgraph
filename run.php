<?php

use Etudor\PhpGraph\DependecyExtractor\MethodArgumentsExtractor;
use Etudor\PhpGraph\PhpGraph;
use Etudor\PhpGraph\UmlGenerator;

include __DIR__ . '/vendor/autoload.php';

$classMap = new PhpGraph();
$map = $classMap->create('/home/tudor/Project/pets/src', '/home/tudor/Project/pets/vendor/autoload.php');
//$map = $classMap->create(__DIR__ . '/src', __DIR__ . '/vendor/autoload.php');

//$ma = new MethodArgumentsExtractor();
//$dep = $ma->getDependencies(new ReflectionClass(PhpGraph::class));

$uml = new UmlGenerator();
$graph = $uml->buildGraph($map);

$graphviz = new \Etudor\PhpGraph\Renderer\GoJs();
$gojs = $graphviz->render($graph);

//
//App\Service;
//
//class PasswordEncoder
//$classNo = count($classMap);
//
//
