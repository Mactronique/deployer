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

class ManagerAddCommand extends Command
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
            ->setName('manager:add')
            ->setDescription('Add the project into manager')
            ->setHelp(<<<EOT
This command can add an project into manager. After this command, you can update the new project by using project name.
EOT
            )
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'url to deloyer config file'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln('');
        $output->writeln('<question>                                             </question>');
        $output->writeln('<question>  Add this project into the project manager  </question>');
        $output->writeln('<question>                                             </question>');
        $output->writeln('');
        
        $path = $input->getArgument('url');
        $conf = ['url'=>$path, 'enable'=>true];
        
        $output->writeln($path);


    }
}
