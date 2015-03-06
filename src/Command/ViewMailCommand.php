<?php

namespace ConsoleMail\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewMailCommand extends ConsoleMailCommand {
  protected function configure() {
    $this->setName('view')
      ->setDescription('Views an email')
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

    $mail = $mailbox->getMail($mailId);

    $output->writeln('<info>From:</info> ' . $mailbox->formatFrom($mail));
    $output->writeln('<info>Subject:</info> ' . $mail->subject);
    $output->writeln('<info>Message:</info>');
    if (!empty($mail->textPlain)) {
      $output->writeln($mail->textPlain);
    } else {
      // @todo: Line space madness.
      $content = trim(strip_tags($mail->textHtml));
      $output->writeln($content);
    }

    return 0;
  }
}
