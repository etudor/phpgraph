<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\Extractor\FullClassNameExtractor;

class DirectoryMapToClassesMap
{
    /**
     * @var FileReader
     */
    private $fileReader;

    /**
     * @param FileReader $fileReader
     */
    public function __construct(FileReader $fileReader = null, FullClassNameExtractor $fullClassNameExtractor = null)
    {
        $this->fileReader = $fileReader ? $fileReader : new FileReader();
        $this->fullClassNameExtractor = $fullClassNameExtractor ? $fullClassNameExtractor : new FullClassNameExtractor();
    }

    /**
     * @param array $classMap
     *
     * @return array
     */
    public function getClassesFromDirectoryStructure(array $classMap)
    {
        $classes = [];

        foreach ($classMap as $class) {
            $content = $this->fileReader->read($class);
            $classes[] = $this->fullClassNameExtractor->extract($content);
        }

        return $classes;
    }

}
