<?php

namespace Pharmacist;

use \Phar as Phar;

Class Pharmacist
{

    /**
     * @param CLImate $climate    The CLImate instance used to output information to the terminal
     * @param Flysystem $filesystem The Flysystem instance used to handle files and folders.
     */
    public function __construct($climate, $filesystemFactory) 
    {
        $this->cli = $climate;
        $this->filesystemFactory = $filesystemFactory;
        $this->pharReadOnly = ini_get('phar.readonly');
        $this->cli->out("\nWelcome to the <green>Pharmacist</green>\n");
        if ($this->pharReadOnly) {
            $this->cli->yellow("<green>Pharmacist</green> has detect your PHP has the <magenta>phar.readonly</magenta> option set to true.")
            ->yellow("Please, change this option in yout PHP.ini and run <gren>Pharmacist</gren> again.");
            exit(1);
        }
    }

    /**
     * This will handle the creation of the .phar archive.
     * 
     * @param  string $source   The path to the source directory.
     * @param  string $name     The name of the output archive.
     * @param  string $cliEntry The entry point when calling this .phar from the CLI.
     * @param  string $webEntry The entry point when calling this .phar from a web stream.
     * 
     * @return void
     */
    public function create($source, $name, $cliEntry, $webEntry) {
        $isValidSource = $this->validateSource($source, $cliEntry, $webEntry);
        if (!$isValidSource) {
            if ($cliEntry === $webEntry) {
                $errorMessage = sprintf("Please, make sure <green>%s</green> and <green>%s</green> exists", $source, $source . DIRECTORY_SEPARATOR . $cliEntry);
                $this->cli->error($errorMessage);
                exit(1);
            }
            $errorMessage = sprintf("Please, make sure <green>%s</green>, <green>%s</green> and <green>%s</green> exists", $source, $source . DIRECTORY_SEPARATOR . $cliEntry, $source . DIRECTORY_SEPARATOR . $webEntry);
            $this->cli->error($errorMessage);
            exit(1);
        }
        $this->cli->green()->flank("BUILDING PHAR", "=", 6);
        $pharInfo = [
            [
            '<green>Source Directory</green>',
            "<magenta>$source</magenta>"
            ],
            [
            '<green>Target PHAR</green>',
            "<magenta>$name</magenta>"
            ],
            [
            '<green>CLI Entry Point</green>',
            "<magenta>$cliEntry</magenta>"
            ],
            [
            '<green>Web Entry Point</green>',
            "<magenta>$webEntry</magenta>"
            ]
        ];
        $this->cli->table($pharInfo);
        $this->buildPhar($source, $name, $cliEntry, $webEntry);
    }

    public function validateSource($source, $cliEntry, $webEntry)
    {
        $filesystem = $this->filesystemFactory->build($source);
        $isValidSource = ($filesystem->has($cliEntry) && $filesystem->has($webEntry));
        return $isValidSource;
    }

    public function buildPhar($srcDirectory, $pharName, $cliEntry, $webEntry)
    {
        try {
            $phar = new Phar($pharName,0,$pharName);
            $phar->startBuffering();
            $phar->buildFromDirectory($srcDirectory);
            $defaultStub = $phar->createDefaultStub($cliEntry,$webEntry);
            $stub = "#!/usr/bin/env php \n". $defaultStub;
            $phar->setStub($stub);
            $phar->stopBuffering();
            $this->cli->cyan("Your phar is ready at $pharName");
        } catch (Exception $e) {
            $this->cli->error("Something went wrong!");
            $this->cli->shout($e->getMessage);
            exit(1);
        }
    }
}