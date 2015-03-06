# Console Mail

A Symfonfy console IMAP tool for those of us who are bad at checking email.

## Configure

Copy `config.yml.example` to `config.yml`. Change the host, port, username, and password.

## Commands

Simply running `mail` will return the number of recent and total emails from your inbox. With any of the commands, sub out [box] with a folder name.

````
Available commands:
  mail check [BOX]        Returns number of recent and total emails.
  mail list [BOX]         Displays overview 10 recent emails
  mail view ID [BOX]      Views an email
  mail rm ID [BOX]        Moves email to trash
````

## Kudos
* php-imap library so I didn't have to wrap imap_*
* platformsh-cli for reference on making Symfony console application.
