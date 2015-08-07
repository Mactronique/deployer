<?php

namespace Mactronique\Deployer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use Symfony\Component\Config\FileLocator;

class InitCommand extends Command
{

    private $config;
     
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Init the project file configuration')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Root path to project'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);


        $path = rtrim(rtrim($input->getArgument('path'), '/'), '\\').DIRECTORY_SEPARATOR;


        $locator = new FileLocator([$path]);

        try {
            $file = $locator->locate('.deployer.yml', null, false);

            dump($file);
            $output->writeln('<error>This project is already configured.</error>');
            return;
        } catch (\Exception $e) {
            $output->writeln('Make file <info>for project</info>');
        }

        $this->config = ['project'=>[
                    'name'=> '',
                    'sources'=> [],
                    'shared'=> [],
                    'commands'=> [],
                    'targets'=> []
        ]];

        $this->setProjectName($input, $output);

        $this->setSources($input, $output);

        dump($this->config);
        $output->writeln($path);


    }

    private function setProjectName(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $projectNameQ = new Question('<question>Please enter the name of the project : </question>', 'MyProject');

        $this->config['project']['name'] = $helper->ask($input, $output, $projectNameQ);
    }


    private function setSources(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Now you can define the project sources for installation.');
        $output->writeln('<error>CAUTION :</error>Only svn repository allowed.');


        $helper = $this->getHelper('question');

        $svnName = new Question('<question>Please enter the URL of the main source : </question>', null);
        $svnSource = new Question('<question>Please enter the name of the default source [tags] : </question>', 'tags');
        $target = new Question('<question>Please enter the name of the target directory : </question>', '.');

        while (true) {
            $output->writeln('');
            $output->writeln('Set empty URL for end.');
            $output->writeln('');
            $source=['type'=>'svn'];
            $source['base_url'] = $helper->ask($input, $output, $svnName);
            if (null === $source['base_url']) {
                break;
            }
            $source['default_source'] = $helper->ask($input, $output, $svnSource);
            $source['project_target'] = $helper->ask($input, $output, $target);
            $this->config['project']['sources'][] = $source;
        }
    }
}
