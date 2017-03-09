<?php

namespace Etudor\PhpGraph;

use ReflectionClass;

class ReflectionClassFactory
{
    /**
     * @param string $className
     * @return ReflectionClass
     * @throws UnableToCreateReflectionException
     */
    public function create($className)
    {
        try {
            // todo try catch or check if it's instance of reflection class after
            $class = new ReflectionClass($className);
        } catch (\ReflectionException $exception) {
            throw new UnableToCreateReflectionException(sprintf('Unable to create reflection class for %s', $class), 0, $exception);
        }

        if ($class instanceof ReflectionClass) {
            return $class;
        }

        // todo save as a external dep
        throw new UnableToCreateReflectionException('We shouldnt get here.');
    }
}
