<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MiddlewareCommand extends Command
{
    const SCRIPTS_PATH = "framework/Command/scripts/";

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('middleware')
            ->setDescription('Create a middleware.')
            ->setHelp('Please avoid names with exotic characters, rather use explicit names or terms. Example : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Middleware name, required.'
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

        // Middleware name must exists
        if (!$name){
            statusCommandHandler::error("You must tell controller name if you want to create it");
            return Command::FAILURE;
        }
        else {
            $this->createMiddleware($name, $folder);
        }

        statusCommandHandler::success("Middleware " . $name . "Middleware.php has been successfully created " . (isset($folder) ? " in the sub-folder " . $folder : "") . " ! Don't forget to call it in the entry point of your project (index.php).");
        return Command::SUCCESS;
    }


    private function createMiddleware($name, $folder)
    {
        $namespaceFolder = '';
        $path_to_middleware = $_SERVER['DOCUMENT_ROOT'] . "framework" . DIRECTORY_SEPARATOR . "Middlewares";

        // Default namespace in middleware folder, we can precise it with "folder" option
        if (isset($folder)){
            $namespaceFolder = "\\" . trim($folder);

            // Let's create folder if it don't exists
            if (!file_exists($path_to_middleware . DIRECTORY_SEPARATOR . $folder)){
                print "\nCreating folder ".$folder."\n\n";
                mkdir($path_to_middleware . DIRECTORY_SEPARATOR . $folder, 0775, true);
            }
        }

        $namespace = "Framework\Middlewares" . $namespaceFolder;
        $classname = trim($name."Middleware.php");

        // We will fetch script "middleware.script"
        $script = $this->getMiddlewareSourceScript();

        // We will replace variables {{ .. }} by name and namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name);

        $finalPath = $path_to_middleware . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getMiddlewareSourceScript()
    {
        print "We will fetch source template\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "middleware.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "We replace variables with name given in argument\n\n";

        $script = file_get_contents($script);

        $script = str_replace(
            ['{{ ESbuilderNamespace }}','{{ ESbuilderName }}',],
            [trim($namespace), trim($classname),],
            $script);

        return $script;
    }
}