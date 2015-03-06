<?php

namespace ConsoleMail\Mailbox;

class Mailbox extends \ImapMailbox {
  public function __construct($imapPath, $login, $password, $attachmentsDir = null, $serverEncoding = 'utf-8') {
    parent::__construct($imapPath, $login, $password, $attachmentsDir, $serverEncoding);
  }

  public function formatFrom(\IncomingMail $mail) {
    $from = $mail->fromAddress;
    if ($mail->fromName) {
      $from = $mail->fromName . '<' . $mail->fromAddress . '>';
    }
    return $from;
  }

  public function formateDate($date) {
    $mailDate = new \DateTime($date);
    $now = new \DateTime();

    $diff = $now->diff($mailDate);
    if ($diff->days == 1) {
      return 'Yesterday';
    } elseif ($diff->days > 1) {
      return $mailDate->format('j F');
    } else {
      return $mailDate->format('g:ia');
    }

  }
}
