<?php

namespace Etudor\PhpGraph\Extractor;

class FullClassNameExtractor
{
    public function __construct()
    {
        $this->namespaceExtractor = new NameSpaceExtractor();
        $this->classExtractor = new ClassExtractor();
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function extract($content)
    {
        $namespace = $this->namespaceExtractor->extract($content);
        $className = $this->classExtractor->extract($content);

        return $namespace . '\\' . $className;
    }
}
