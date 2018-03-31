<?php

/**
*  Corresponding Class to test EyeD3 class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
*  @author yourname
*/
class EyeD3Test extends PHPUnit_Framework_TestCase{

  /**
  * Just check if the EyeD3 has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testIsThereAnySyntaxError(){
	$var = new Stormiix\EyeD3\EyeD3;
	$this->assertTrue(is_object($var));
	unset($var);
  }

  /**
  * Just check if the EyeD3 has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
  public function testMethod1(){
	$var = new Stormiix\EyeD3\EyeD3;
	$this->assertTrue($var->method1("hey") == 'Hello World');
	unset($var);
  }

}
