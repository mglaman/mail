<?php

namespace ConsoleMail\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class ListMailCommand extends ConsoleMailCommand {
  protected function configure() {
    $this->setName('list')
      ->setDescription('Lists mail')
      ->addArgument('box', InputArgument::OPTIONAL, 'The box to list', 'INBOX');
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $this->loadConfig();

    $mailbox = $this->newMailbox($input->getArgument('box'));
    $mailIds = $mailbox->sortMails(SORTARRIVAL);
    $mailIds = array_slice($mailIds, 0, 10);
    $mailInfo = $mailbox->getMailsInfo($mailIds);
    $mailInfo = array_reverse($mailInfo, true);

    $table = new Table($output);
    $table->setHeaders(['ID', 'From', 'Subject', 'Date'])
      ->setStyle('default');

    foreach ($mailInfo as $mail) {

      $table->addRow([
        $mail->uid,
        $mail->from,
        $mail->subject,
        $mailbox->formateDate($mail->date),
      ]);
    }

    $table->render();
  }
}
