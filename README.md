Comet Labs Space Odyssey
========================

Welcome to The Comet Cult labs training Symfony application.

Vagrant & Puppet
----------------

Head over to [The Comet Cult Labs Vagrant Puppet setup](https://github.com/cometcult/vagrant-comet-labs) for instructions

Everything below is done on the virtual machine environment so make sure you logged into it with `vagrant ssh`

Installing vendors
------------------

Head over to the project's directory

```bash
cd /srv/comet-labs.dev/
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
