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

class InitCommand extends Command
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
            ->setName('project:init')
            ->setDescription('Init the project file configuration')
            ->setHelp('Help for my command !!!!')
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

        $output->writeln('');
        $output->writeln('<question>                                      </question>');
        $output->writeln('<question>  Init the deployer for this project  </question>');
        $output->writeln('<question>                                      </question>');
        $output->writeln('');

        dump($this->getApplication()->getConfig());

        $path = rtrim(rtrim($input->getArgument('path'), '/'), '\\').DIRECTORY_SEPARATOR;


        $this->locator = new FileLocator([$path]);

        try {
            $file = $this->locator->locate('.deployer.yml', null, false);

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
                    'commands'=> ['pre'=>[], 'post'=>[]],
                    'targets'=> []
        ]];

        $this->setProjectName($input, $output);

        $this->setSources($input, $output);

        $this->setShared($input, $output);

        $this->setCommand($input, $output, 'pre');
        $this->setCommand($input, $output, 'post');
        
        $this->setTarget($input, $output);

        dump($this->config);

        $yaml = Yaml::dump($this->config, 10);

        file_put_contents($path.'.deployer.yml', $yaml);

        $output->writeln($path);

        $output->writeln('File writen !');


    }

    private function setProjectName(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $projectNameQ = new Question('<question>Please enter the name of the project : </question>', 'MyProject');

        $this->config['project']['name'] = $helper->ask($input, $output, $projectNameQ);
        $output->writeln('');
        $output->writeln('');
    }


    private function setSources(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Now you can define the <info>project sources</info> for installation.');
        $output->writeln('<error>CAUTION :</error>Only svn repository allowed.');


        $helper = $this->getHelper('question');

        $svnName = new Question('<question>Please enter the URL of the main source :</question> ', null);
        $svnSource = new Question('<question>Please enter the name of the default source [tags] :</question> ', 'tags');
        $target = new Question('<question>Please enter the name of the target directory :</question> ', '.');

        while (true) {
            $output->writeln('');
            $output->writeln('Set empty URL for end.');
            $output->writeln('');
            $source=['type'=>'svn'];
            $source['base_url'] = $helper->ask($input, $output, $svnName);
            if (null === $source['base_url']) {
                break;
            }

            $output->writeln('');
            $output->writeln('');
            $source['default_source'] = $helper->ask($input, $output, $svnSource);
            
            $output->writeln('');
            $output->writeln('');
            $source['project_target'] = $helper->ask($input, $output, $target);
            
            $output->writeln('');
            $output->writeln('');
            $this->config['project']['sources'][] = $source;
        }
    }

    private function setShared(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Now you can define the <info>file and folder shared between all update</info>.');
        $output->writeln('<comment>The root path is not allowed.</comment>');

        $helper = $this->getHelper('question');

        $pathQuestion = new Question('<question>Please enter the path to refer of the root project :</question> ', null);

        $notAllowedPath = ['.', './'];

        while (true) {
            $output->writeln('');
            $output->writeln('Set empty path for end.');
            $output->writeln('');

            $path = $helper->ask($input, $output, $pathQuestion);
            if (null === $path) {
                break;
            }
            if (in_array($path, $notAllowedPath)) {
                $output->writeln('<error>The path '.$path.' is not allowed !</error>');
                continue;
            }

            try {
                $file = $this->locator->locate($path, null, false);

                dump($file);
                $this->config['project']['shared'][] = $path;
            } catch (\Exception $e) {
                $output->writeln('<error>This path does not exist : '.$path.'</error>');
            }


        }
    }


    private function setCommand(InputInterface $input, OutputInterface $output, $key)
    {

        $output->writeln('Now you can define the <info>'.$key.'</info> command.');
        //$output->writeln('Set here the command run ');

        $helper = $this->getHelper('question');

        $commandQuestion = new Question('<question>Please enter the command :</question> ', null);

        while (true) {
            $output->writeln('');
            $output->writeln('Set empty command for end.');
            $output->writeln('');

            $command = $helper->ask($input, $output, $commandQuestion);
            $output->writeln('');
            $output->writeln('');
            if (null === $command) {
                break;
            }

            $this->config['project']['commands'][$key][] = $command;

        }
    }


    private function setTarget(InputInterface $input, OutputInterface $output)
    {

        $output->writeln('Now you can define the <info>target and environement</info>.');
        //$output->writeln('Set here the command run ');

        $helper = $this->getHelper('question');

        $nameQuestion = new Question('<question>Please enter the name of target :</question> ', null);
        $devQuestion = new Question('<question>Please enter the environement for this target :</question> ', 'dev');
        $serverQuestion = new Question('<question>Please enter the server of target :</question> ', null);
        $folderDestQuestion = new Question('<question>Please enter the installation folder path :</question> ', null);
        $allowBackupQuestion = new ConfirmationQuestion('<question>Make a backup before update [Y/n] ?</question> ', false, '/^(y|o)/i');
        
        $allTargetName = [];
        while (true) {
            $output->writeln('');
            $output->writeln('Set empty name for end.');
            $output->writeln('');
            $target = [];
            $target['name'] = $helper->ask($input, $output, $nameQuestion);
            $output->writeln('');
            $output->writeln('');
            if (null === $target['name']) {
                break;
            }
            if (in_array($target['name'], $allTargetName)) {
                $output->writeln('<error>The target '.$target['name'].' is already defined !</error>');
                continue;
            }
            $allTargetName[] = $target['name'];

            
            $target['server'] = $helper->ask($input, $output, $serverQuestion);
            $output->writeln('');
            $output->writeln('');
            
            $target['env'] = $helper->ask($input, $output, $devQuestion);
            $output->writeln('');
            $output->writeln('');
            
            $target['source'] = $helper->ask($input, $output, $folderDestQuestion);
            $output->writeln('');
            $output->writeln('');
            
            $target['allow_backup'] = $helper->ask($input, $output, $allowBackupQuestion);
            $output->writeln('');
            $output->writeln('');




            $this->config['project']['targets'][] = $target;

        }
    }
}
