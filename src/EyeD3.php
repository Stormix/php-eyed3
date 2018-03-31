<?php

namespace Stormiix\EyeD3;

/**
*  EyeD3 class
*   A PHP wrapper for reading and updating ID3 meta data of (e.g.) MP3 files using eyeD3
*
*  @author Stormiix <hello@stormix.co>
*  @package PSR\Stormiix\EyeD3
*  @license MIT
*  @version 1.0.0
*
*  @TODO updateMeta()
*/
class EyeD3
{

   /**
    * Path to the eyeD3 cli.
    * @var string
    */

    public $path = '';

    /**
     * MP3 file path.
     * @var string
     */

    public $file = '';

    /**
     * faulty tags.
     *
     * Some tags are concatenated like: "track: 		genre: Synthpop (id 147)"
     * and other have their values on a new line
     * Comment: [Description: ] [Lang: XXX]
     * From http://www.xamuel.com/blank-mp3s/
     *
     * @var array
     */

    public $faultyTags = [];

    /**
     * Some tags to ignore.
     * @var array
     */
    public $ignoredTags = [];

    public function __construct($file, $path="eyeD3")
    {
        $this->path = $path;
        $this->file = $file;
        $this->faultyTags = ['track','comment','lyrics'];
        $this->ignoredTags = ['usertextframe'];
    }

    public static function match($needles, $haystack)
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
    * Read Meta Tags
    *
    * Reads the meta data of the given file
    *
    * @return array tags
    */

    public function readMeta()
    {
        $file = $this->file;
        $args = ['--no-color', $file];
        $command = $this->path;
        foreach ($args as $arg) {
            $command .= " ".$arg;
        }
        $output = shell_exec($command);
        //print_r($output);
        $lines = explode("\n", $output);
        $response = [];
        for ($i = 0; $i < count($lines); $i++) {
            $line = $lines[$i];
            if (!self::match($this->ignoredTags, strtolower($line))) {
                preg_match('/^(.*): (.*)$/', $line, $matches, PREG_OFFSET_CAPTURE);
                if ($matches) {
                    // Some tags are concatenated :track: 		genre: Synthpop (id 147)
                    // and other have their values on a new line
                    // Comment: [Description: ] [Lang: XXX]
                    // From http://www.xamuel.com/blank-mp3s/
                    if (self::match($this->faultyTags, strtolower($line))) {
                        $tag = explode(":", $matches[1][0])[0];
                        if ($tag == "track") {
                            if (strpos($matches[1][0], "genre") !== false) {
                                $tag = trim(explode(":", $matches[1][0])[1]);
                                $genreDetails = explode("id", $matches[2][0]);
                                $value = [
                                "genre" => trim(substr($genreDetails[0], 0, -3)),
                                "genre_id" => trim(substr($genreDetails[1], 0, -1))
                            ];
                            } else {
                                $tag = "track";
                                $value = $matches[2][0];
                            }
                        } else {
                            $value = $lines[$i+1];
                        }
                    } else {
                        $tag = strtolower($matches[1][0]);
                        $value = $matches[2][0];
                    }
                    if (!array_key_exists($tag, $response)) {
                        $response[$tag] = $value;
                    } else {
                        if (!array_key_exists($tag."s", $response)) {
                            $response[$tag."s"][] = $value;
                        }
                        unset($response[$tag]);
                    }
                }
            }
        }
        return $response;
    }

    /**
     * Builds an argument error out of the given meta data
     *
     * Create arguments as described in : https://eyed3.readthedocs.io/en/latest/plugins/classic_plugin.html
     *
     * @param array meta
     * @link https://eyed3.readthedocs.io/en/latest/plugins/classic_plugin.html
     * @return array command arguments
     */
    public static function buildArgs($meta)
    {
        $args = [];
        if (array_key_exists("artist", $meta)) {
            array_push($a, '-a', "'".$meta["artist"]."'");
        }
        if (array_key_exists("title", $meta)) {
            array_push($args, '-t', "'".$meta["title"]."'");
        }
        if (array_key_exists("album", $meta)) {
            array_push($args, '-A', "'".$meta["album"]."'");
        }
        if (array_key_exists("comment", $meta)) {
            array_push($args, '-c', '::'."'".$meta["comment"]."'");
        }
        if (array_key_exists("lyrics", $meta)) {
            array_push($args, '-L', '::'."'".$meta["lyrics"]."'");
        }
        if (array_key_exists("year", $meta)) {
            array_push($args, '-Y', $meta["year"]);
        }
        return $args;
    }


    /**
    * Update Meta Tags
    *
    * Update the meta data of a file with the given data
    *
    * @param array  meta
    * @param callable callback
    */

    public function updateMeta($meta, $callback = null)
    {
        $file = $this->file;
        $args = self::buildArgs($meta);
        array_push($args, $file);
        $command = $this->path;
        foreach ($args as $arg) {
            $command .= " ".$arg;
        }
        $output = shell_exec($command);
        print($output);
        // Execute callback
        if ($callback) {
            call_user_func($callback);
        }
    }
}
