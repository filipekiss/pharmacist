<?php 

require __DIR__ . '/../vendor/autoload.php';

use Pharmacist\Commands\CreateCommand as CreateCommand;
use Symfony\Component\Console\Application as Application;
use League\CLImate\CLImate as CLImate;
use Pharmacist\Pharmacist as Pharmacist;
use Pharmacist\Factories\FilesystemFactory as FilesystemFactory;


$climate = new CLImate;
$filesystemFactory = new FilesystemFactory;
$pharmacist = new Pharmacist($climate, $filesystemFactory);

$commands = [
    'create' => new CreateCommand($pharmacist)
];

$application = new Application();
foreach ($commands as $id => $command) {
    $application->add($command);
}
$application->run();