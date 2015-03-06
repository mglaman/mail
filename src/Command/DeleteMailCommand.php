<?php

namespace ConsoleMail\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteMailCommand extends ConsoleMailCommand {
  protected function configure() {
    $this->setName('rm')
      ->setDescription('Delete an email')
      ->addArgument('id', InputArgument::REQUIRED, 'The mail ID')
      ->addArgument('box', InputArgument::OPTIONAL, 'The box to list', 'INBOX');
  }
  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->loadConfig();
    $mailbox = $this->newMailbox($input->getArgument('box'));

    $mailId = $input->getArgument('id');
    if (empty($mailId)) {
      $output->writeln('You must specify mail ID to view!');
      return 1;
    }

    $mailbox->deleteMail($mailId);

    return 0;
  }
}
