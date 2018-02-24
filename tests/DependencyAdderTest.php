<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\DependencyAdder;
use Etudor\PhpGraph\Extractor\ExtractorInterface;
use Etudor\PhpGraph\ReflectionClassFactory;

class DependencyAdderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $classFactoryMock = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $adder            = new DependencyAdder($classFactoryMock);

        $this->assertInstanceOf(DependencyAdder::class, $adder);
    }

    /**
     * @test
     */
    public function given_a_list_of_namespaces_it_tries_to__add_dependencies()
    {
        $classList = [
            'test\class1',
            'testNamespace\class2',
        ];

        $classFactoryMock    = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $reflectionClassMock = $this->getMockBuilder(\ReflectionClass::class)->disableOriginalConstructor()->getMock();
        $classFactoryMock->method('create')->willReturn($reflectionClassMock);
        $adder = new DependencyAdder($classFactoryMock);

        $customExtractor = $this
            ->getMockBuilder('CustomExtractor')
            ->setMethods(['addDependencies'])
            ->getMock();

        $customExtractor->method('addDependencies')->willReturn(['dependency1Class']);

        $adder->registerDependencyExtractor($customExtractor);

        $classList = $adder->addDependencies($classList);
        $this->assertEquals(2, count($classList));
    }

    /**
     * @test
     */
    public function registering_one_dependency_extractor_it_calls_it()
    {
        $classList = [
            'test\class1',
            'testnamespace\class2',
        ];

        $classFactoryMock = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $adder            = new DependencyAdder($classFactoryMock);

        $customExtractor = $this->getMockBuilder('CustomExtractor')->setMethods(['getDependencies'])->getMock();

        $customExtractor->expects($this->at(0))->method('addDependencies')->willReturn([]);
        $customExtractor->expects($this->at(1))->method('addDependencies')->willReturn([]);

        $adder->registerDependencyExtractor($customExtractor);

        $classList = $adder->addDependencies($classList);
    }

    /**
     * @test
     */
    public function registering_two_dependency_extractors_it_calls_both()
    {
        $classList = [
            'test\class1',
            'testnamespace\class2',
        ];

        $classFactoryMock = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $adder            = new DependencyAdder($classFactoryMock);

        $customExtractor = $this->getMockBuilder(ExtractorInterface::class)
            ->setMethods(['addDependencies'])->getMock();
        $customExtractor->expects($this->at(0))->method('addDependencies')->willReturn(['11', '12']);
        $customExtractor->expects($this->at(1))->method('addDependencies')->willReturn(['21', '22']);

        $customExtractor2 = $this->getMockBuilder('CustomExtractor2')->setMethods(['addDependencies'])->getMock();
        $customExtractor2->expects($this->at(0))->method('addDependencies')->willReturn(['aa', 'ab']);
        $customExtractor2->expects($this->at(1))->method('addDependencies')->willReturn(['ba', 'bb']);

        $adder->registerDependencyExtractor($customExtractor);
        $adder->registerDependencyExtractor($customExtractor2);

        $classList = $adder->addDependencies($classList);
    }
}
