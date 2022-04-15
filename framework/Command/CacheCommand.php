<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Framework\Command\StatusCommandHandler;

class CacheCommand extends Command
{

    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('cache')
            ->setDescription('Vide le cache.')
            ->addArgument(
                'all',
                InputArgument::OPTIONAL,
                'Vide tous les dossiers de cache du projet y compris celui pour les vues (dossier views_c).'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $all = $input->getArgument('all');

        $cacheFolder = $_SERVER["DOCUMENT_ROOT"] . "cache/" ;
        $viewsCacheFolder = $_SERVER["DOCUMENT_ROOT"] . "views_c/";

        // On vide déjà le dossier cache de base
        if (is_dir($cacheFolder) && is_readable($cacheFolder)){
            $files = glob($cacheFolder."*");
            foreach ($files as $file) {
                if (is_file($file)){
                    unlink($file);
                }
            }
        }

        // Le nom du controller doit exister sinon erreur
        if ($all){
            if (is_dir($viewsCacheFolder) && is_readable($viewsCacheFolder)){
                $views = glob($viewsCacheFolder."*");
                foreach ($views as $view) {
                    if (is_file($view)){
                        unlink($view);
                    }
                }
                print "\nOption all : Vidage du cache pour les vues\n";
            }
            else {
                statusCommandHandler::error("Le dossier 'views_c' n'est pas pas un dossier ou est inaccessible en lecture", $output);
                return Command::FAILURE;
            }
        }

        statusCommandHandler::success("Les dossiers de cache ont bien été vidés", $output);
        return Command::SUCCESS;
    }
}