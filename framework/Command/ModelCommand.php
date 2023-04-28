<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;


class ModelCommand extends Command
{
    const SCRIPTS_PATH = "framework/Command/scripts/";

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('model')
            ->setDescription('Create a model.')
            ->setHelp('Please avoid names with exotic characters, rather use explicit names or terms. Example : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Model name, required.'
            )
            ->addArgument(
                'folder',
                InputArgument::OPTIONAL,
                'Sub-folder where we want to create the middleware. Optionnal'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $folder = $input->getArgument('folder');

        // Model name must exists
        if (!$name){
            statusCommandHandler::error("You must tell controller name if you want to create it");
            return Command::FAILURE;
        }
        else {
            // Let's ask the user if he wants to give the table
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Do you want to add table name now ?[N/y] ', false);
            if ($helper->ask($input, $output, $question)){
                $question_table = new Question('Please give the name of the table : ', '');

                $table = $helper->ask($input, $output, $question_table);
            }

            $this->createModel($this->firstUpperCase($name), $folder, $table);
        }

        statusCommandHandler::success("Model " . $this->firstUpperCase($name) . ".php was successfully created " . (isset($folder) ? " in the subfolder " . $folder : "") . " !");
        return Command::SUCCESS;
    }

    private function createModel($name, $folder, $table = "")
    {
        $namespaceFolder = '';
        $path_to_model = $_SERVER['DOCUMENT_ROOT'] . "app" . DIRECTORY_SEPARATOR . "model";

        // Default namespace in model folder, we can precise it with "folder" option
        if (isset($folder)){
            $namespaceFolder = "\\" . trim($folder);

            // Let's create folder if it don't exists
            if (!file_exists($path_to_model . DIRECTORY_SEPARATOR . $folder)){
                print "\nCreating the folder ".$folder."\n\n";
                mkdir($path_to_model . DIRECTORY_SEPARATOR . $folder, 0775, true);
            }
        }

        $namespace = "App\model" . $namespaceFolder;
        $classname = trim($name.".php");

        // If we precise table name, let's clean it before add it
        $table = htmlspecialchars($table, ENT_QUOTES);

        // We will fetch script "model.script"
        $script = $this->getModelSourceScript();

        // We will replace variables {{ ... }} by names and namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name, $table);

        $finalPath = $path_to_model . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getModelSourceScript()
    {
        print "We will fetch source template\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "model.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname, $table)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "We replace variables with name given in argument\n";

        $script = file_get_contents($script);

        $script = str_replace(
            ['{{ ESbuilderNamespace }}','{{ ESbuilderName }}','{{ ESbuilderModelTable }}'],
            [trim($namespace), trim($classname), $table],
            $script);

        return $script;
    }

    private function firstUpperCase($string)
    {
        if (empty($string)){
            return false;
        }

        $firstCase = strtoupper(substr($string, 0, 1));

        return preg_replace("/^[\w]{1}/", $firstCase, $string);
    }
}