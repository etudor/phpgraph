<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\Includer\FileIncluder;
use Etudor\PhpGraph\Includer\FileIncluderInterface;

class FileIncluderTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsInstantiable()
    {
        $includer = new FileIncluder();
        $this->assertInstanceOf(FileIncluderInterface::class, $includer);
    }
}
