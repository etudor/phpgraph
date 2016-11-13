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
        // todo try catch or check if it's instance of reflection class after
        $class = new ReflectionClass($class);

        if ($class instanceof ReflectionClass) {
            return $class;
        }

        // todo save as a external dep
    }
}
