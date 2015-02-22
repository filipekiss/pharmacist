<?php 

namespace Pharmacist\Commands;

use \Symfony\Component\Console\Command\Command as Command;

Class PharmacistCommand extends Command
{
    public function __construct(\Pharmacist\Pharmacist $pharmacist) 
    {
        $this->pharmacist = $pharmacist;
        parent::__construct();
    }
}

