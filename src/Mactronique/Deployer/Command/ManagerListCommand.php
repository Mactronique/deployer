<?php

namespace Mactronique\Deployer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;

class ManagerListCommand extends Command
{

    private $config;

    private $locator;
     
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('manager:list')
            ->setDescription('List all project into manager')
            ->setHelp('Help for my command !!!!')
            ->addOption('update', 'u', InputOption::VALUE_NONE, 'Update the list of project from SVN main repository')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln('');
        $output->writeln('<question>                                      </question>');
        $output->writeln('<question>  Init the deployer for this project  </question>');
        $output->writeln('<question>                                      </question>');
        $output->writeln('');
        

        $update = $this->getOption('update');

        

    }
}
