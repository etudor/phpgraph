<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\DependencyExtractor\DependencyExtractorInterface;
use function var_dump;

class DependencyAdder
{
    /**
     * @var ReflectionClassFactory
     */
    private $reflectionClassFactory;

    /**
     * @var DependencyExtractorInterface[]
     */
    protected $extractors = [];

    /**
     * @param ReflectionClassFactory $reflectionClassFactory
     */
    public function __construct(ReflectionClassFactory $reflectionClassFactory)
    {
        $this->reflectionClassFactory = $reflectionClassFactory;
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
                $reflectionClass = $this->reflectionClassFactory->create($class);
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

                // todo filter and remove duplicate dependencies
            } catch (\ReflectionException $exception) {
                // currently try to skip interfaces
                // todo do something with interfaces: skip them
            }
        }

        return $dependencies;
    }
}
