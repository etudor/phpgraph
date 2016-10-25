<?php

namespace Etudor\PhpGraph\Tests\Extractor;

use Etudor\PhpGraph\Extractor\ClassExtractor;

class ClassExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $extractor = new ClassExtractor();

        $this->assertInstanceOf(ClassExtractor::class, $extractor);
    }

    /**
     * @test
     * @dataProvider getClassesContent
     */
    public function extract_correct_class_from_content($content, $classCorrect)
    {
        $extractor = new ClassExtractor();

        $class = $extractor->extract($content);

        $this->assertEquals($classCorrect, $class);
    }

    public function getClassesContent()
    {
        return [
            [
                '<?php class test {',
                'test'
            ],
            [
                '<?php class test2 
                {',
                'test2'
            ],
            [
                '<?php 
                class test3 extends
                {',
                'test3'
            ],
            [
                '<?php 
                interface test4
                {',
                'test4'
            ],
        ];
    }
}
