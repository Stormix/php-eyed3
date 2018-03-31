<?php

/**
* eyeD3 wrapper test class | src/EyeD3.php
*
* @author Stormiix <hello@stormix.co>
* @package PSR\Stormiix\EyeD3
* @license MIT
* @version 1.0.0
* @copyright Copyright (c) 2018, Stormix.co
*/

class EyeD3Test extends \PHPUnit\Framework\TestCase
{

  /**
  * Just check if the EyeD3 has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
    public function testIsThereAnySyntaxError()
    {
        $var = new Stormiix\EyeD3\EyeD3("assets/test.mp3");
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
    * readMeta METHOD test
    */
    public function testreadMeta()
    {
        $var = new Stormiix\EyeD3\EyeD3("tests/assets/test.mp3");
        $expected = "TestArtist";
        $this->assertTrue($var->readMeta()["artist"] == $expected);
        unset($var);
    }

    /**
     * updateMeta METHOD test
    */
    public function testupdateMeta()
    {
        $var = new Stormiix\EyeD3\EyeD3("tests/assets/test.mp3");
        $expected = "TestArtistChanged";
        $var->updateMeta(["artist"=>$expected]);
        $this->assertTrue($var->readMeta()["artist"] == $expected);
        unset($var);
    }
}
