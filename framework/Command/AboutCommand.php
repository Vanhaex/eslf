<?php

namespace Framework\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AboutCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('about')
            ->setDescription('Show informations about framework.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(
            <<<EOT
<info>ESLF Framework - Easy Simple and Lightweight web Framework</info>
<comment>ESLF is a simple framework for writing web applications </comment>
EOT
        );

        return Command::SUCCESS;
    }
}
