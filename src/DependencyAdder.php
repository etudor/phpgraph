<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\DependencyExtractor\DependencyExtractorInterface;

class DependencyAdder
{
    /**
     * @var ReflectionClassFactory
     */
    private $classFactory;

    /**
     * @var DependencyExtractorInterface[]
     */
    protected $extractors = [];

    /**
     * @param ReflectionClassFactory $classFactory
     */
    public function __construct(ReflectionClassFactory $classFactory = null)
    {
        $this->classFactory = $classFactory ? $classFactory : new ReflectionClassFactory();
    }

    /**
     * @param $customExtractor
     */
    public function registerDependencyExtractor($customExtractor)
    {
        $this->extractors[] = $customExtractor;
    }

    /**
     * Applies registered dependency extractors and adds dependencies for list of classes
     *
     * @param array $classList
     *
     * @return array
     */
    public function addDependencies(array $classList)
    {
        $dependencies = [];
        foreach ($classList as $class) {
            try {
                $reflectionClass = $this->classFactory->create($class);
                if (!$reflectionClass) {
                    continue;
                }

                $dependencies[$class] = [];
                foreach ($this->extractors as $extractor) {
                    $dependencies[$class] = array_merge(
                        $dependencies[$class],
                        $extractor->getDependencies($reflectionClass)
                    );
                }
            } catch (\ReflectionException $exception) {
                // currently try to skip interfaces
                // todo do something with interfaces
            }
        }

        return $dependencies;
    }
}
