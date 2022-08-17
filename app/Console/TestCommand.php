<?php declare(strict_types = 1);

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('test');
        $this->setDescription('Command for run test.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        var_dump("It works.");
        return 0;
    }
}
