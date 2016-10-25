<?php

namespace Etudor\PhpGraph\Tests\Extractor;

use Etudor\PhpGraph\Extractor\NameSpaceExtractor;

class NamespaceExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function IsInstantiable()
    {
        $extractor = new NameSpaceExtractor();

        $this->assertInstanceOf(NameSpaceExtractor::class, $extractor);
    }

    /**
     * @test
     * @dataProvider getContentWithNamespaces
     *
     * @param string $content
     * @param string $nameSpace
     */
    public function getCorrectNamespacesFromContent($content, $nameSpace)
    {
        $extractor = new NameSpaceExtractor();
        $extractedNamespace = $extractor->extract($content);

        $this->assertEquals($nameSpace, $extractedNamespace, 'Namespace not extracted correctly by namespace extractor.');
    }

    public function getContentWithNamespaces()
    {
        return [
            [
                '<?php 
                namespace test\test2;
                class {',
                'test\test2'
            ],
            [
                '<?php namespace test2\test3;
                class {',
                'test2\test3'
            ]
        ];
    }
}
