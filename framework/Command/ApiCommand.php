<?php

namespace Framework\Command;

use Config\AppConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ApiCommand extends Command
{
    const SCRIPTS_PATH = "framework/Command/scripts/";

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('api')
            ->setDescription('Créé une API.')
            ->setHelp('Please avoid names with exotic characters, rather use explicit names or terms. Example : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Name of the API, required. Please use an explicit name that will be shown in the URL (example : \'hello\' for \'/api/hello\')'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $uri = AppConfig::getApiBaseUri() . "/" . trim(strtolower($name));

        // Default description
        $description = "API " . ucfirst($name) . "Api generated with ESbuilder";

        // Let's ask to the user if he want to describe
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion("\nDo you want to describe this API " . ucfirst($name) . "Api ? (Y/n)", false, '/^(y|j)/i');

        if ($helper->ask($input, $output, $question)){
            $question = new Question("\nPlease describe your API in such words : ", $description);
            $description = $helper->ask($input, $output, $question);
        }

        // API name must exists
        if (!$name){
            statusCommandHandler::error("\nYou must give a name for your API if you want to use it !");
            return Command::FAILURE;
        }
        else {
            $this->createAPI($name, $description, $uri);
        }

        statusCommandHandler::success("API " . $name . "Api.php was successfully created in '/app/api' folder !");
        return Command::SUCCESS;
    }

    private function createAPI($name, $description, $uri)
    {
        $folder = "";

        $path_to_api = $_SERVER['DOCUMENT_ROOT'] . "app" . DIRECTORY_SEPARATOR . "api";

        $namespace = "App\api";

        $name = ucfirst($name);

        $classname = trim($name."Api.php");

        // Let's search script "api.script"
        $script = $this->getAPISourceScript();

        // We will replace variables {{ .. }} by name and namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name, $description, $uri);

        $finalPath = $path_to_api . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getAPISourceScript()
    {
        print "\nWe will fetch source template\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "api.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname, $description, $uri)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "We replace variables with name given in argument\n";

        $script = file_get_contents($script);

        $script = str_replace(
            ['{{ ESbuilderNamespace }}','{{ ESbuilderName }}', '{{ ESbuilderDesc }}', '{{ ESbuilderURI }}'],
            [trim($namespace), trim($classname), trim($description), trim($uri)],
            $script);

        return $script;
    }
}