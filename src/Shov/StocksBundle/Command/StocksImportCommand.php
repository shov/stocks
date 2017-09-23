<?php

namespace Shov\StocksBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StocksImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('stocks:import')
            ->setDescription('Imports the stocks from given csv file')
            ->addArgument('source-scv', InputArgument::REQUIRED, 'Give a path to stocks csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourcePath = $input->getArgument('source-scv');

        $output->writeln('Done.');
    }

}
