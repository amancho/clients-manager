#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';


use iSalud\App\Console\RenewClientsConsoleCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new RenewClientsConsoleCommand());
$application->run();
