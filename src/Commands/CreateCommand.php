<?php

namespace Pharmacist\Commands;

use Symfony\Component\Console\Input\InputArgument as InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption as InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

Class CreateCommand extends PharmacistCommand
{
    protected function configure() {
        $this
            ->setName('create')
            ->setDescription('Create the phar archive')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'The source directory to archive.'
                )
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The output archive name.'
                )
            ->addOption(
                'cli-entry',
                'C',
                InputOption::VALUE_OPTIONAL,
                'The default entry point when calling from CLI.',
                'index.php'
                )
            ->addOption(
                'web-entry',
                'W',
                InputOption::VALUE_OPTIONAL,
                'The default entry point when calling from Web. (default: same as cli)',
                null
                );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $source = $input->getArgument('source');
        $name = $input->getArgument('name');
        $cliEntry = $input->getOption('cli-entry');
        $webEntry = ($input->getOption('web-entry') ? $input->getOption('web-entry') : $cliEntry);
        $this->pharmacist->create($source, $name, $cliEntry, $webEntry);
    }
}