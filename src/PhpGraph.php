<?php

namespace Etudor\PhpGraph;

use Etudor\PhpGraph\DependencyExtractor\MethodArgumentsExtractor;
use Etudor\PhpGraph\Includer\FileIncluderInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use function var_dump;

class PhpGraph
{
    /**
     * @var DirectoryScanner
     */
    private $directoryScanner;

    /**
     * @var FileIncluderInterface
     */
    private $includer;

    /**
     * @var DependencyAdder
     */
    private $dependencyAdder;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var DirectoryMapToClassesMap
     */
    private $directoryMapper;

    public function __construct()
    {
        $this->initialize();

        $this->directoryScanner = $this->container->get('directory_scanner');
        $this->includer         = $this->container->get('file_includer');
        $this->dependencyAdder  = $this->container->get('dependency_adder');
        $this->directoryMapper  = $this->container->get('directory_mapper');

        # register default dependency extractors
        $this->dependencyAdder->registerDependencyExtractor(new MethodArgumentsExtractor());
    }

    private function initialize()
    {
        $this->container = new ContainerBuilder();
        $loader          = new YamlFileLoader($this->container, new FileLocator(__DIR__));
        $loader->load('Resources/config/services.yml');
    }

    /**
     * @param string $directory
     * @param string $autoload Path to the autoload file
     * @return array
     */
    public function create($directory, $autoload)
    {
        // get files tree
        $filesMap = $this->directoryScanner->scan($directory);

        // get classes from array of files
        $fullClasses = $this->directoryMapper->getClassesFromDirectoryStructure($filesMap);

        var_dump($fullClasses);die;
        // require the autoloader
        $this->includer->includeFile($autoload);

        // add dependencies to class map
        $classesWithDependenciesAdded = $this->dependencyAdder->addDependencies($fullClasses);

        return $classesWithDependenciesAdded;
    }
}
