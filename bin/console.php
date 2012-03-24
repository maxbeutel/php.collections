<?php

require_once __DIR__ . '/../autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

$console = new Application();
$console->add(new Collection\Command\TypedCollectionGenerator());
/*
$console
    ->register('collection:generate-typed')
    ->setDefinition(array(
        new InputArgument('definitions', InputArgument::REQUIRED, 'Definitions JSON file'),
    ))
    ->setDescription('Generate typed collections')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $dir = $input->getArgument('dir');

        $output->writeln(sprintf('Dir listing for <info>%s</info>', $dir));
    })
;
*/

$console->run();