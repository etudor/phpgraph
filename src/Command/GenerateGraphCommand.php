<?php

namespace Etudor\PhpGraph\Command;

use Etudor\PhpGraph\PhpGraph;
use Etudor\PhpGraph\UmlGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateGraphCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('generate:graph')
            ->setDescription('Generate a graph from php project.')
            ->addArgument(
                'dir',
                InputArgument::REQUIRED,
                'Directory where your application that you want to create graph for lies.'
            )
            ->addArgument(
                'autoload',
                InputArgument::REQUIRED,
                'Path to composer autoload or if you don\'t use composer path to your autoload.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classMap = new PhpGraph();

        $map = $classMap->create(
            $input->getArgument('dir'),
            $input->getArgument('autoload')
        );

        var_dump($map);
        die;

        $uml = new UmlGenerator();
        $graph = $uml->buildGraph($map);

        $graphviz = new \Etudor\PhpGraph\Renderer\GoJs();
        $gojs = $graphviz->render($graph);

        file_put_contents('web/test.json', json_encode($gojs));
    }
}
