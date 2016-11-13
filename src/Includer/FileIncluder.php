<?php

namespace Etudor\PhpGraph\Includer;

class FileIncluder implements FileIncluderInterface
{
    /**
     * @inheritdoc
     */
    public function includeFile($file)
    {
        require $file;
    }
}
