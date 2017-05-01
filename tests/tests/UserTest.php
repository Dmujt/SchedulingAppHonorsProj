<?php

require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template
 * @cond 
 * @brief Unit tests for the class 
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct() {
        $row = array('id' => 12,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'password' => '12345678',
        );
        $user = new Calendar\User($row);
        $this->assertEquals(12, $user->getId());
        $this->assertEquals('dude@ranch.com', $user->getEmail());
    }
}

/// @endcond
?>
