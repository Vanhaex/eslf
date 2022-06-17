<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class VersionCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('version')
            ->setDescription('Affiche la dernière version stable du projet.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("ESLF v2.0.0");

        return Command::SUCCESS;
    }
}