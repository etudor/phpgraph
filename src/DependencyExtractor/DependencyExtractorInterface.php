<?php

namespace Etudor\PhpGraph\DependecyExtractor;

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
