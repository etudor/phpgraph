<?php

namespace Etudor\PhpGraph\Extractor;

class NameSpaceExtractor
{
    /**
     * @param string $content
     *
     * @return string
     */
    public function extract($content)
    {
        $namespaceRegex = '/namespace (?<namespace>.*);/';
        $matches = [];
        preg_match($namespaceRegex, $content, $matches);

        return $matches['namespace'];
    }
}
