<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Framework\Command\StatusCommandHandler;


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
            ->setDescription('Créé un model.')
            ->setHelp('Evitez les noms constitués de caractères exotiques, utilisez plutot des noms ou termes explicites. Exemple : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Le nom du model, qui est obligatoire.'
            )
            ->addArgument(
                'folder',
                InputArgument::OPTIONAL,
                'Le sous-dossier dans lequel on souhaite créer le model. Optionnel'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $folder = $input->getArgument('folder');

        // Le nom du model doit exister sinon erreur
        if (!$name){
            statusCommandHandler::error("Vous devez indiquer le nom du model si vous voulez le créer");
            return Command::FAILURE;
        }
        else {
            // On demande si l'utilisateur veut ajouter la table
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Souhaitez-vous ajouter le nom de la table maintenant ?[N/y] ', false);
            if ($helper->ask($input, $output, $question)){
                $question_table = new Question('Veuillez indiquer le nom de la table : ', '');

                $table = $helper->ask($input, $output, $question_table);
            }

            $this->createModel($this->firstUpperCase($name), $folder, $table);
        }

        statusCommandHandler::success("Le model " . $this->firstUpperCase($name) . ".php a bien été créé" . (isset($folder) ? " dans le sous-dossier " . $folder : "") . " !");
        return Command::SUCCESS;
    }

    private function createModel($name, $folder, $table = "")
    {
        $namespaceFolder = '';
        $path_to_model = $_SERVER['DOCUMENT_ROOT'] . "app" . DIRECTORY_SEPARATOR . "model";

        // Le namespace par défaut dans le dossier model, mais ça peut être ailleurs si on le précise avec "folder"
        if (isset($folder)){
            $namespaceFolder = "\\" . trim($folder);

            // On va créér le dossier s'il n'existe pas déjà
            if (!file_exists($path_to_model . DIRECTORY_SEPARATOR . $folder)){
                print "\nCréation du dossier ".$folder."\n\n";
                mkdir($path_to_model . DIRECTORY_SEPARATOR . $folder, 0775, true);
            }
        }

        $namespace = "App\model" . $namespaceFolder;
        $classname = trim($name.".php");

        // Si on précise le nom de la table, alors on les nettoie d'abord puis on les ajoute
        $table = htmlspecialchars($table, ENT_QUOTES);

        // On va chercher le script "template" model.script
        $script = $this->getModelSourceScript();

        // Et on va remplacer les variables {{ ... }} pour y mettre les noms et le namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name, $table);

        $finalPath = $path_to_model . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getModelSourceScript()
    {
        print "On récupère le template source\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "model.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname, $table)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "On remplace les variables du template par les noms données en arguments\n";

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