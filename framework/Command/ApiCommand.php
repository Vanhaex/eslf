<?php

namespace Framework\Command;

use Config\AppConfig;
use Framework\Command\StatusCommandHandler;
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
            ->setHelp('Evitez les noms constitués de caractères exotiques, utilisez plutot des noms ou termes explicites. Exemple : "Toto", "Home", etc...')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Le nom de l\'API, qui est obligatoire. Veuillez utiliser un nom explicite qui sera donné dans l\'url (exemple : \'bonjour\' pour \'/api/bonjour\')'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $uri = AppConfig::getApiBaseUri() . "/" . trim(strtolower($name));

        // Aucun cas où on ne souhaite pas décrire l'API
        $description = "L'API " . ucfirst($name) . "Api générée par ESbuilder";

        // On demande si l'API doit être décrite
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion("\nSouhaitez-vous une description pour l'API " . ucfirst($name) . "Api ? (Y/n)", false, '/^(y|j)/i');

        if ($helper->ask($input, $output, $question)){
            $question = new Question("\nVeuillez donner la description de votre API : ", $description);
            $description = $helper->ask($input, $output, $question);
        }

        // Le nom de l'API doit exister sinon erreur
        if (!$name){
            statusCommandHandler::error("\nVous devez indiquer le nom de l'API si vous voulez la créer");
            return Command::FAILURE;
        }
        else {
            $this->createAPI($name, $description, $uri);
        }

        statusCommandHandler::success("L'API " . $name . "Api.php a bien été créée dans le dossier '/app/api' !");
        return Command::SUCCESS;
    }

    private function createAPI($name, $description, $uri)
    {
        $path_to_api = $_SERVER['DOCUMENT_ROOT'] . "app" . DIRECTORY_SEPARATOR . "api";

        $namespace = "App\api";

        $name = ucfirst($name);

        $classname = trim($name."Api.php");

        // On va chercher le script "template" api.script
        $script = $this->getAPISourceScript();

        // Et on va remplacer les variables {{ ... }} pour y mettre les noms et le namespace
        $replaced = $this->replaceSourceVars($script, $namespace, $name, $description, $uri);

        $finalPath = $path_to_api . DIRECTORY_SEPARATOR . (isset($folder) ? $folder . DIRECTORY_SEPARATOR : "") . $classname;

        file_put_contents($finalPath, $replaced);
    }

    private function getAPISourceScript()
    {
        print "\nOn récupère le template source\n\n";
        return $_SERVER["DOCUMENT_ROOT"] . self::SCRIPTS_PATH . "api.script";
    }

    private function replaceSourceVars(&$script, $namespace, $classname, $description, $uri)
    {
        if (empty($script) || empty($namespace) || empty($classname)){
            return false;
        }

        print "On remplace les variables du template par les noms données en arguments\n";

        $script = file_get_contents($script);

        $script = str_replace(
            ['{{ ESbuilderNamespace }}','{{ ESbuilderName }}', '{{ ESbuilderDesc }}', '{{ ESbuilderURI }}'],
            [trim($namespace), trim($classname), trim($description), trim($uri)],
            $script);

        return $script;
    }
}