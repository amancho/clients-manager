<?php

namespace iSalud\App\Console;

use Exception;
use iSalud\ClientsManager\Application\Command\RenewClients\RenewClientsCommand;
use iSalud\ClientsManager\Infrastructure\Service\GenerateClientsCSV\GenerateClientsCSV;
use iSalud\ClientsManager\Infrastructure\Service\GetClients\GetClientsFromApi;
use iSalud\ClientsManager\Infrastructure\Service\GetClients\GetClientsFromFile;
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
            $result = $this->renewClients();

            if (empty($result)) {
                throw new \Exception('ERROR :: Sorry, the file could not been generated');
            }

            $output->writeln($result);

        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
        }
    }

    private function getParams(InputInterface $input): void
    {
        $this->externalFile = $input->getArgument('external-file') ?? '';
        $this->destinationFile = $input->getArgument('destination-file') ?? '';
    }

    /**
     * @throws Exception
     */
    private function renewClients(): string
    {
        $renewClientsCommand = new RenewClientsCommand(
            GetClientsFromApi::create(),
            GetClientsFromFile::create(),
            GenerateClientsCSV::create(),
            $this->externalFile,
            $this->destinationFile
        );

        return $renewClientsCommand->execute();
    }
}