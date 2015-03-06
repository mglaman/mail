<?php

namespace ConsoleMail\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ConsoleMail\Mailbox\Mailbox;

class CheckMailCommand extends ConsoleMailCommand {
  protected function configure() {
    $this->setName('check')
      ->setDescription('Checks mail')
      ->addArgument('box', InputArgument::OPTIONAL, 'The box to list', 'INBOX');

  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->loadConfig();
    $status = $this->newMailbox($input->getArgument('box'))->checkMailbox();

    $output->writeln(sprintf(
      'You have <info>%1$s</info> recent messages and <info>%2$s</info> messages overall.',
      $status->{'Recent'},
      $status->{'Nmsgs'}
    ));
  }
}