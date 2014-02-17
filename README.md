Comet Labs Space Odyssey
========================

Welcome to The Comet Cult labs training Symfony application.

Vagrant & Puppet
----------------

To get the Vagrant machine running just type:

```bash
vagrant up --provision
```

Then login to the machine with:

```bash
vagrant ssh
```

Installing vendors
------------------

Head over to the project's directory

```bash
cd /var/www/comet-labs.dev/
```

Download composer with:

```
curl -s http://getcomposer.org/installer | php
```

Then install all the vendors by typing:

```
php composer.phar install --dev
```

CI
--

To run Behat scenarios just type:

```bash
./bin/behat @TheCometCultOdysseyBundle
```
