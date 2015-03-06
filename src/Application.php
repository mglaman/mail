<?php

namespace ConsoleMail;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication {

  /**
   * @inheritoc
   */
  public function __construct() {
    parent::__construct('ConsoleMail', '1.0.x');

    $this->setDefaultTimezone();
    $this->addCommands($this->getCommands());
    $this->setDefaultCommand('check');
  }

  protected function getCommands() {
    return [
      new Command\ListMailCommand(),
      new Command\CheckMailCommand(),
      new Command\ViewMailCommand(),
      new Command\DeleteMailCommand(),
    ];
  }

  /**
   * Set the default timezone.
   *
   * PHP 5.4 has removed the autodetection of the system timezone,
   * so it needs to be done manually.
   * UTC is the fallback in case autodetection fails.
   */
  protected function setDefaultTimezone() {
    $timezone = 'UTC';
    if (is_link('/etc/localtime')) {
      // Mac OS X (and older Linuxes)
      // /etc/localtime is a symlink to the timezone in /usr/share/zoneinfo.
      $filename = readlink('/etc/localtime');
      if (strpos($filename, '/usr/share/zoneinfo/') === 0) {
        $timezone = substr($filename, 20);
      }
    } elseif (file_exists('/etc/timezone')) {
      // Ubuntu / Debian.
      $data = file_get_contents('/etc/timezone');
      if ($data) {
        $timezone = trim($data);
      }
    } elseif (file_exists('/etc/sysconfig/clock')) {
      // RHEL/CentOS
      $data = parse_ini_file('/etc/sysconfig/clock');
      if (!empty($data['ZONE'])) {
        $timezone = trim($data['ZONE']);
      }
    }
    date_default_timezone_set($timezone);
  }
}