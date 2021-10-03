<?php

declare(strict_types=1);

namespace App\Command\Shipping;

use App\Model\Shipping\Transaction\OutputFormatterInterface;
use App\Service\Shipping\ParseFromFileServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseDataFromFile extends Command
{
    private const PARAMETER_FILEPATH = 'filepath';

    protected static $defaultName = 'app:shipping-parse-data-from-file';

    private ParseFromFileServiceInterface $parseFromFileService;

    private OutputFormatterInterface $outputFormatter;

    public function __construct(
        ParseFromFileServiceInterface $parseFromFileService,
        OutputFormatterInterface $outputFormatter,
        string $name = null
    ) {
        $this->parseFromFileService = $parseFromFileService;
        $this->outputFormatter = $outputFormatter;

        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument(
            self::PARAMETER_FILEPATH,
            InputArgument::REQUIRED,
            'Shipping data file path'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $transactions = $this->parseFromFileService->parse($input->getArgument(self::PARAMETER_FILEPATH));

        foreach ($transactions as $transaction) {
            echo $this->outputFormatter->format($transaction);
        }

        $output->writeln('Shipment has been registered successfully!');

        return Command::SUCCESS;
    }
}