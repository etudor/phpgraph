<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\Extractor\FullClassNameExtractor;

/**
 * Extracts FQCN from files array
 *
 * @package Etudor\PhpGraph
 */
class DirectoryMapToClassesMap
{
    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * @param FileReader             $fileReader
     * @param FullClassNameExtractor $fullClassNameExtractor
     */
    public function __construct(
        FileReader $fileReader,
        FullClassNameExtractor $fullClassNameExtractor
    )
    {
        $this->fileReader             = $fileReader;
        $this->fullClassNameExtractor = $fullClassNameExtractor;
    }

    /**
     * @param array $classMap
     *
     * @return array
     */
    public function getClassesFromDirectoryStructure(array $filesMap)
    {
        $classes = [];

        foreach ($filesMap as $file) {
            $content   = $this->fileReader->read($file);
            $classes[$file] = $this->fullClassNameExtractor->extract($content);
        }

        return $classes;
    }

}
