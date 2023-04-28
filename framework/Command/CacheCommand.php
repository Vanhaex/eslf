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
            ->setDescription('Empty cache.')
            ->addArgument(
                'all',
                InputArgument::OPTIONAL,
                'Empty all cache folders, (also folder views_c).'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $all = $input->getArgument('all');

        $cacheFolder = $_SERVER["DOCUMENT_ROOT"] . "cache/" ;
        $viewsCacheFolder = $_SERVER["DOCUMENT_ROOT"] . "views_c/";

        // Empty base cache folder
        if (is_dir($cacheFolder) && is_readable($cacheFolder)){
            $files = glob($cacheFolder."*");
            foreach ($files as $file) {
                if (is_file($file)){
                    unlink($file);
                }
            }
        }

        // Name of the controller musts exists
        if ($all){
            if (is_dir($viewsCacheFolder) && is_readable($viewsCacheFolder)){
                $views = glob($viewsCacheFolder."*");
                foreach ($views as $view) {
                    if (is_file($view)){
                        unlink($view);
                    }
                }
                print "\nOption all : Empty cache for views\n";
            }
            else {
                statusCommandHandler::error("Folder 'views_c' is not a folder or you can't read it");
                return Command::FAILURE;
            }
        }

        statusCommandHandler::success("Cache folder has been successfully empty ", $output);
        return Command::SUCCESS;
    }
}