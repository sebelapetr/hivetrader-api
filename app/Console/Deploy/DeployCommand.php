<?php declare(strict_types = 1);

namespace App\Console;

use Contributte\Deployer\Config\Config;
use Contributte\Deployer\Config\Section;
use Contributte\Deployer\Manager;
use Nette\DI\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DeployCommand extends Command
{
    public Manager $deployManager;

    public function __construct(Container $container, string $name = null)
    {
        $this->deployManager = $container->getByType(Manager::class);
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('deploy');
        $this->setDescription('Deploy to FTP.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        var_dump("Start deploy");
        $this->deployManager->deploy();
        var_dump("Done");
        return 0;
    }
}
