<?php

namespace ConsoleMail\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Yaml\Parser;
use ConsoleMail\Mailbox\Mailbox;

class ConsoleMailCommand extends Command {
  /**
   * @var array
   */
  protected $config;
  /**
   * @var \ConsoleMail\Mailbox\Mailbox;
   */
  protected $mailbox;

  public function loadConfig() {
    if (!$this->config) {
      $configPath = CLI_ROOT . '/config.yml';
      $parser = new Parser();
      $this->config = $parser->parse(file_get_contents($configPath));
    }
    return $this->config;
  }

  public function newMailbox($box = 'INBOX') {
    $this->mailbox = new Mailbox($this->imapPath($box), $this->imapUser(), $this->imapPass());
    return $this->mailbox;
  }

  public function imapPath($box = null) {
    if ($box == null) {
      return '{' . $this->config['host'] . ':' . $this->config['port'] . '}';
    } else {
      return '{' . $this->config['host'] . ':' . $this->config['port'] . '}' . $box;
    }
  }

  public function imapUser() {
    return $this->config['user'];
  }

  public function imapPass() {
    return $this->config['pass'];
  }
}