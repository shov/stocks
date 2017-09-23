<?php

namespace Shov\StocksBundle\Tests\Fixtures;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;

abstract class CommandTestCase extends KernelTestCase
{
    protected function getCommandTesterFor(Command $command): CommandTester
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add($command);

        $command = $application->find($command->getName()); //?
        return new CommandTester($command);
    }
}