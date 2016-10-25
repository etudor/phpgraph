<?php

namespace Etudor\PhpGraph\DependecyExtractor;

use ReflectionClass;

class MethodArgumentsExtractor implements DependencyExtractorInterface
{
    /**
     * @inheritdoc
     */
    public function getDependencies(ReflectionClass $class)
    {
        $dep = [];
        $methods = $class->getMethods();
        foreach ($methods as $method) {
            $parameters = $method->getParameters();
            foreach ($parameters as $parameter) {
                if ($parameter->getClass()) {
                    $dep[] = $parameter->getClass()->getName();
                }
            }
        }

        return $dep;
    }
}
