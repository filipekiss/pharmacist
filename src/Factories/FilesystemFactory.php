<?php 

namespace Pharmacist\Factories;

use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Local as LocalAdapter;

Class FilesystemFactory
{
    public function build($path) {
        if (empty($path)) {
            return null;
        }
        $adapter = new LocalAdapter($path);
        $filesystem = new Flysystem($adapter);
        return $filesystem;
    }
}