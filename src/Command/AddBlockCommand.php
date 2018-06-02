<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddBlockCommand extends ContainerAwareCommand {

    protected $_blockFactory;

    public function __construct(
        $name = null
    )
    {
        parent::__construct($name);
    }

    public function configure()
    {
        $this
            ->setName('magecoin:add-block')
            ->setDescription('Add block to MageCoin block chain')
            ->addOption('data', null, InputOption::VALUE_REQUIRED, 'Data to be serialized in block', null)
            ->addOption('purge', null, InputOption::VALUE_OPTIONAL, 'Purge json files and import new version !', null);
}

    public function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln("Test workign");
    }


}