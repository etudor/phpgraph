<?php

namespace Etudor\PhpGraph\Includer;

interface FileIncluderInterface
{
    /**
     * @param string $file
     */
    public function includeFile($file);
}
