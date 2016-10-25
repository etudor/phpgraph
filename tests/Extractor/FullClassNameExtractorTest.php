<?php

namespace Etudor\PhpGraph\Tests\Extractor;

use Etudor\PhpGraph\Extractor\FullClassNameExtractor;

class FullClassNameExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $extractor = new FullClassNameExtractor();
        
        $this->assertInstanceOf(FullClassNameExtractor::class, $extractor);
    }

    /**
     * @test
     * @dataProvider getContentWithClassName
     */
    public function get_correct_full_class_name($content, $class)
    {
        $extractor = new FullClassNameExtractor();

        $fullClass = $extractor->extract($content);

        $this->assertEquals($class, $fullClass);
    }

    public function getContentWithClassName()
    {
        return [
            [
                '<?php namespace test\test2;
                class testclass',
                'test\test2\testclass'
            ],
        ];
    }


    
}
