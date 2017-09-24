<?php

namespace Shov\StocksBundle\Command;

use Shov\StocksBundle\Exceptions\WrongPathException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StocksImportCommand extends ContainerAwareCommand
{
    const MESSAGES = [
        'WRONG_PATH' => "Wrong path!",
        'WRONG_FILE' => "Corrupted file given!",
    ];

    protected function configure()
    {
        $this
            ->setName('stocks:import')
            ->setDescription('Imports the stocks from given csv file')
            ->addArgument('source', InputArgument::REQUIRED, 'Give a path to stocks csv');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourcePath = $input->getArgument('source');

        try {
            if(!is_file($sourcePath)) {
                throw new WrongPathException();
            }
        } catch (WrongPathException $e) {
            $output->writeln(static::MESSAGES['WRONG_PATH']);
            return;
        }

        $output->writeln('Done.');
    }

}
