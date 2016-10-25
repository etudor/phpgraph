<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\DirectoryScanner;

class DirectoryScannerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_instansiable()
    {
        $directoryScanner = new DirectoryScanner();

        $this->assertInstanceOf(DirectoryScanner::class, $directoryScanner);
    }
}
