# php-eyed3

[![GitHub stars](https://img.shields.io/github/stars/Stormiix/php-eyed3.svg)](https://github.com/Stormiix/php-eyed3/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/Stormiix/php-eyed3.svg?style=flat)](https://github.com/Stormiix/php-eyed3/network)
[![Build Status](https://img.shields.io/travis/Stormiix/php-eyed3/master.svg?style=flat-square)](https://travis-ci.org/Stormiix/php-eyed3)
[![Donations Badge](https://stormix.co/donate/images/badge.svg)](https://stormix.co/donate/)

A PHP wrapper for reading and updating ID3 meta data of (e.g.) MP3 files using eyeD3

## Requirements

You need PHP >= 7.0 to use the library, but the latest stable version
of PHP is recommended.

## Installation

1. Make sure you have `eyeD3` installed.
2. Install package
```bash
	composer require stormiix/php-eyed3 dev-master
```
This will edit (or create) your composer.json file and automatically
choose the most recent version.
3. Require autoload.php
```php
	require __DIR__ . '/vendor/autoload.php';
```
## Usage

```php
	use Stormiix\EyeD3\EyeD3;

	$eyed3 = new EyeD3("mp3 file path");
	$tags = $eyed3->readMeta();
	// $tags is an array that contains the following keys:
	// artist, title, album, comment(s), lyrics ..etc

	$meta = [
		"artist" => "MyArtist",
		"title" => "MyTitle",
		"album" => "MyAlbum",
		"comment" => "MyComment",
		"lyrics" => "MyLyrics",
		"album_art" => "cover.png"
	];
	// Update the mp3 file with the new meta tags
  	$eyed3->updateMeta($meta);
```

## Running tests

    $ phpunit

## Authors

* **Anas Mazouni** - [php-eyed3](https://github.com/Stormiix/php-eyed3)

P.S: a similar wrapper exists for NodeJs apps: [node-eyed3](https://github.com/saschagehlich/node-eyed3)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
