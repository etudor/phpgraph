<?php

namespace Etudor\PhpGraph;

/**
 * todo create tests
 * todo refactor
 */
class DirectoryScanner
{
    const PHP_EXTENSION = '.php';

    /**
     * @var string[]
     */
    protected $filesMap = [];

    /**
     * @var string
     */
    private $baseDir;

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

        $dirMap = scandir($dir);
        foreach ($dirMap as $file) {
            if (!in_array($file, [".", ".."])) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                    $this->scan($dir . DIRECTORY_SEPARATOR . $file, true);
                } else {
                    // save only php files todo add multiple extensions
                    if (substr($file, -4) !== self::PHP_EXTENSION) {
                        continue;
                    }

                    $this->filesMap[] = $dir . DIRECTORY_SEPARATOR . $file;
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
