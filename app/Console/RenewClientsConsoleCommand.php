<?php

namespace iSalud\App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class RenewClientsConsoleCommand extends Command
{
    protected static $defaultName = 'app:renew-clients';
    private string $externalFile;
    private string $destinationFile;

    protected function configure(): void
    {
        $this->addArgument(
            'external-file',
            InputArgument::OPTIONAL,
            'File path to load additional clients data'
        );

        $this->addArgument(
            'destination-file',
            InputArgument::OPTIONAL,
            'File name to save clients data'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            $this->getParams($input);
            $this->renewClients();
            $output->writeln('It works!');
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
        }
    }

    private function getParams(InputInterface $input): void
    {
        $this->externalFile = $input->getArgument('external-file') ?? '';
        $this->destinationFile = $input->getArgument('destination-file') ?? '';
    }

    private function renewClients(): void
    {
        // TODO
    }
}