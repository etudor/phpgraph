<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\DependecyExtractor\MethodArgumentsExtractor;
use Etudor\PhpGraph\Includer\FileIncluder;
use Etudor\PhpGraph\Includer\FileIncluderInterface;

class PhpGraph
{
    /**
     * @var DirectoryScanner
     */
    protected $directoryScanner;

    /**
     * @var FileIncluderInterface
     */
    protected $includer;

    /**
     * @var DependencyAdder
     */
    protected $dependencyAdder;

    /**
     * @param DirectoryScanner|null      $directoryScanner
     * @param FileIncluderInterface|null $includer
     * @param DependencyAdder            $dependencyAdder
     */
    public function __construct(
        DirectoryScanner $directoryScanner = null,
        FileIncluderInterface $includer = null,
        DependencyAdder $dependencyAdder = null,
        DirectoryMapToClassesMap $classesGetter = null
    )
    {
        $this->directoryScanner = $directoryScanner ? $directoryScanner : new DirectoryScanner();
        $this->includer = $includer ? $includer : new FileIncluder();
        $this->dependencyAdder = $dependencyAdder ? $dependencyAdder : new DependencyAdder();
        $this->classGetter = $classesGetter ? $classesGetter : new DirectoryMapToClassesMap();
    }

    public function create($directory, $autoload)
    {
        $filesMap = $this->directoryScanner->scan($directory);
        $fullClasses = $this->classGetter->getClassesFromDirectoryStructure($filesMap);

        $this->includer->include($autoload);

        $this->dependencyAdder->registerDependencyExtractor(new MethodArgumentsExtractor());

        $classesWithDependenciesAdded = $this->dependencyAdder->addDependencies($fullClasses);

        return $classesWithDependenciesAdded;
    }
}
