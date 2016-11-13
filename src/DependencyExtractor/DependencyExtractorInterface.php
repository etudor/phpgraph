<?php

namespace Etudor\PhpGraph\DependencyExtractor;

use ReflectionClass;

interface DependencyExtractorInterface
{
    /**
     * @param ReflectionClass $class
     *
     * @return mixed
     */
    public function getDependencies(ReflectionClass $class);
}
