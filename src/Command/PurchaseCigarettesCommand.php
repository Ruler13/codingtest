<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use App\Machine\AmountNotEnoughException;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        $success_msg = 'You bought <info>%d</info> packs of cigarettes for <info>%.2f</info>, each for <info>%.2f</info>.';
        $failure_msg = 'You tried to buy <info>%d</info> packs of cigarettes but you paid <info>%.2f</info>, you still have to pay <info>%.2f</info>. Please purchase again.';


        $cigaretteMachine = new CigaretteMachine();
        $purchaseTransaction = new PurchaseTransaction($itemCount, $amount);
        try {
            $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);
            $output->writeln(sprintf(
                $success_msg,
                $purchasedItem->getItemQuantity(),
                $purchasedItem->getTotalAmount(),
                CigaretteMachine::ITEM_PRICE
            ));
            $output->writeln('Your change is:');

            $table = new Table($output);
            $table
                ->setHeaders(array('Coins', 'Count'))
                ->setRows($purchasedItem->getChange());
            $table->render();
        } catch (AmountNotEnoughException $e) {
            $output->writeln(sprintf(
                $failure_msg,
                $purchaseTransaction->getItemQuantity(),
                $purchaseTransaction->getPaidAmount(),
                $e->getAmount()
            ));
        }
    }
}
