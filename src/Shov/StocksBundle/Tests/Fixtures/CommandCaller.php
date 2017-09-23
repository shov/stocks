<?php

namespace Shov\StocksBundle\Tests\Fixtures;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CommandCaller extends CommandTester
{
    /**
     * @var null|Command
     */
    protected $defaultCommand = null;

    /**
     * Set up default command object, then you can run execute without specifics the command name
     *
     * @param Command $command
     */
    public function setDefaultCommand(Command $command)
    {
        $this->defaultCommand = $command;
    }

    /**
     * Mix default command name, just put your arguments in input
     *
     * @param array $input
     * @param array $options
     * @return int
     */
    public function execute(array $input, array $options = array())
    {
        if(!is_null($this->defaultCommand)) {
            $input = array_merge([
                'command' => $this->defaultCommand->getName(),
            ], $input);
        }

        return parent::execute($input, $options);
    }
}