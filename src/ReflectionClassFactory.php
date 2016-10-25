<?php

namespace Etudor\PhpGraph;

use ReflectionClass;

class ReflectionClassFactory
{
    /**
     * @param object $class
     *
     * @return ReflectionClass
     */
    public function create($class)
    {
        return new ReflectionClass($class);
    }
}
