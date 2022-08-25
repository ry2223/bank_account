<?php

namespace App\Command;

use App\Repository\MoneyRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'transaction-history',
    description: 'Display transaction history of selected client',
)]
class TransactionHistoryCommand extends Command
{
    public function __construct(
        private MoneyRepository $moneyRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('clientId', InputArgument::REQUIRED, 'Select client account ID')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = $input->getArgument('clientId');

        $moneyHistory = $this->moneyRepository->showHistory($clientId);
        print_r($moneyHistory);

        return Command::SUCCESS;
    }
}
