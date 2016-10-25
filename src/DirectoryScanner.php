<?php

namespace Etudor\PhpGraph;

/**
 * todo create tests
 * todo refactor
 */
class DirectoryScanner
{
    protected $filesMap = [];
    protected $baseDir;

    /**
     * @param string $dir
     * @param bool   $isInnerDir
     *
     * @return array
     */
    public function scan($dir, $isInnerDir = false)
    {
        if (false === $isInnerDir) {
            $this->baseDir = $dir;
        }

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, [".", ".."])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $this->scan($dir . DIRECTORY_SEPARATOR . $value, true);
                } else {
                    $this->filesMap[] = $dir . DIRECTORY_SEPARATOR . $value;
                }
            }
        }

        return $this->filesMap;
    }

    /**
     * Get path of file relative to base directory path provided
     *
     * @param string $dir
     *
     * @return string
     */
    protected function getRelativePath($dir)
    {
        return str_replace($this->baseDir, '', $dir);
    }
}
