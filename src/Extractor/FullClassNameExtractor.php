<?php

namespace Etudor\PhpGraph\Extractor;

class FullClassNameExtractor implements ExtractorInterface
{
    /**
     * @var NameSpaceExtractor
     */
    private $namespaceExtractor;

    /**
     * @var ClassExtractor
     */
    private $classExtractor;

    public function __construct(
        NameSpaceExtractor $nameSpaceExtractor,
        ClassExtractor $classExtractor
    )
    {
        $this->namespaceExtractor = $nameSpaceExtractor;
        $this->classExtractor     = $classExtractor;
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
