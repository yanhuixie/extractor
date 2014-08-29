Extractor library for php
=========================

This library extracts your files from compressed files and returns a Symfony
Finder instance, ready to be managed

# Installing/Configuring

## Tags

* Use last unstable version ( alias of `dev-master` ) to stay in last commit
* Use last stable version tag to stay in a stable release.
* [![Latest Unstable Version](https://poser.pugx.org/mmoreram/extractor/v/unstable.png)](https://packagist.org/packages/mmoreram/extractor)
[![Latest Stable Version](https://poser.pugx.org/mmoreram/extractor/v/stable.png)](https://packagist.org/packages/mmoreram/extractor)

## Installing [Extractor](https://github.com/mmoreram/extractor)

You have to add require line into you composer.json file

``` yml
"require": {
    "php": ">=5.3.3",
    ...

    "mmoreram/extractor": "dev-master",
}
```

Then you have to use composer to update your project dependencies

``` bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar update
```

# Usage

Get a finder instance given a compressed file

``` php
<?php

use Symfony\Component\Finder\Finder;
use Mmoreram\Extractor\Resolver\ExtensionResolver;
use Mmoreram\Extractor\Extractor;

$extensionResolver = new ExtensionResolver;
$extractor = new Extractor($extensionResolver);

/**
 * @var Finder $files
 */
$files = $extractor->extractFromFile('/tmp/myfile.rar');
foreach ($files as $file) {

    echo $file->getRealpath() . PHP_EOL;
}
```

# Adapters

This library currently manages these extensions. All of these adapters only
works if the php extension is installed.

* Zip - http://php.net/manual/en/zip.phar.php
* Rar - http://php.net/manual/en/rar.phar.php
* Phar - http://php.net/manual/en/book.phar.php