<?php

namespace Etudor\PhpGraph\Tests\Renderer;

use Etudor\PhpGraph\Renderer\Renderer;
use Etudor\PhpGraph\UmlGenerator;

class RendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_is_instantiable()
    {
        $generator = new UmlGenerator();
        $graph = $generator->buildGraph(['test', 'test2']);

        $render = new Renderer();

        $this->assertInstanceOf(Renderer::class, $render);
    }
}
