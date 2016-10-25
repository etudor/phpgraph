<?php

namespace Etudor\PhpGraph\Extractor;

class ClassExtractor
{
    /**
     * @param string $content
     *
     * @return string
     */
    public function extract($content)
    {
        $class = '/(class|interface) (?<class>\w+)/';
        $matches = [];
        preg_match($class, $content, $matches);

        return $matches['class'];
    }
}
