<?php

namespace Etudor\PhpGraph;

class FileReader
{
    /**
     * @param string $file
     *
     * @return string
     */
    public function read($file)
    {
        return file_get_contents($file);
    }
}
