<?php

namespace Etudor\PhpGraph\Includer;

class FileIncluder implements FileIncluderInterface
{
    /**
     * @inheritdoc
     */
    public function include($file)
    {
        require $file;
    }
}
