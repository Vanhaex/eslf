<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Framework\Command\StatusCommandHandler;


class ControllerCommand extends Command
{
    const SCRIPTS_PATH = "framework/Command/scripts/";

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('controller')
            ->setDescription('Créé un controller.')
            ->setHelp('Evitez les noms constitués de caractères exotiques, utilisez plutot des noms ou termes explicites. Exemple : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Le nom du controller, qui est obligatoire.'
            )
            ->addArgument(
                'folder',
                InputArgument::OPTIONAL,
                'Le sous-dossier dans lequel on souhaite créer le controller. Optionnel'
            )
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $folder = $input->getArgument('folder');

        // Le nom du controller doit exister sinon erreur
        if (!$name){
            statusCommandHandler::error("Vous devez indiquer le nom du controller si vous voulez le créer", $output);
            return Command::FAILURE;
        }
        else {
            $this->createController($name, $folder);
        }

        statusCommandHandler::success("Le controller " . $name . "Controller.php a bien été créé" . (isset($folder) ? " dans le sous-dossier " . $folder : "") . " !", $output);
        return Command::SUCCESS;
    }


    private function createController($name, $folder)
    {
        $namespaceFolder = '';
        $path_to_controller = $_SERVER['DOCUMENT_ROOT'] . "app" . DIRECTORY_SEPARATOR . "controller";

        // Le namespace par défaut dans le dossier controller, mais ça peut être ailleurs si on le précise avec "folder"
        if (isset($folder)){
            $namespaceFolder = "\\" . trim($folder);

            // On va créér le dossier s'il n'existe pas déjà
            if (!file_exists($path_to_controller . DIRECTORY_SEPARATOR . $folder)){
                print "\nCréation du dossier ".$folder."\n\n";
                mkdir($path_to_controller . DIRECTORY_SEPARATOR . $folder, 0775, true);
            }
        }

        $namespace = "App\controller" . $namespaceFolder;
        $classname = trim($name."Controller.php");

        // On va chercher le script "template" controller.script
        $script = $this->getControllerSourceScript();

        // Et on va remplacer les variables {{ ... }} pour y mettre les noms et le namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name);

        $finalPath = $path_to_controller . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getControllerSourceScript()
    {
        print "On récupère le template source\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "controller.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "On remplace les variables du template par les noms données en arguments\n\n";

        $script = file_get_contents($script);

        $script = str_replace(
            ['{{ ESbuilderNamespace }}','{{ ESbuilderName }}',],
            [trim($namespace), trim($classname),],
            $script);

        return $script;
    }
}