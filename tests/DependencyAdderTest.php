<?php

namespace Etudor\PhpGraph\Tests;

use Etudor\PhpGraph\DependencyAdder;
use Etudor\PhpGraph\ReflectionClassFactory;

class DependencyAdderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function is_instantiable()
    {
        $classFactoryMock = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $adder = new DependencyAdder($classFactoryMock);

        $this->assertInstanceOf(DependencyAdder::class, $adder);
    }

    /**
     * @test
     */
    public function given_a_list_of_namespaces_it_calls_add_dependencies()
    {
        $classList = [
            'test\class1',
            'testnamespace\class2',
        ];

        $classFactoryMock = $this->getMockBuilder(ReflectionClassFactory::class)->getMock();
        $adder = new DependencyAdder($classFactoryMock);

        $customExtractor = $this->getMockBuilder('CustomExtractor')
            ->setMethods(['getDependencies'])->getMock();
        $customExtractor->method('getDependencies')->willReturn([]);

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
        $adder = new DependencyAdder($classFactoryMock);

        $customExtractor = $this->getMockBuilder('CustomExtractor')->setMethods(['getDependencies'])->getMock();

        $customExtractor->expects($this->at(0))->method('getDependencies')->willReturn([]);
        $customExtractor->expects($this->at(1))->method('getDependencies')->willReturn([]);

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
        $adder = new DependencyAdder($classFactoryMock);

        $customExtractor = $this->getMockBuilder('CustomExtractor')->setMethods(['getDependencies'])->getMock();
        $customExtractor->expects($this->at(0))->method('getDependencies')->willReturn(['11', '12']);
        $customExtractor->expects($this->at(1))->method('getDependencies')->willReturn(['21', '22']);

        $customExtractor2 = $this->getMockBuilder('CustomExtractor2')->setMethods(['getDependencies'])->getMock();
        $customExtractor2->expects($this->at(0))->method('getDependencies')->willReturn(['aa', 'ab']);
        $customExtractor2->expects($this->at(1))->method('getDependencies')->willReturn(['ba', 'bb']);

        $adder->registerDependencyExtractor($customExtractor);
        $adder->registerDependencyExtractor($customExtractor2);

        $classList = $adder->addDependencies($classList);
    }
}
