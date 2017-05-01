<?php
require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond
 * @brief Unit tests for the class
 */

class LoginTest extends \PHPUnit_Extensions_Database_TestCase{

    public static function setUpBeforeClass() {
        self::$site = new Calendar\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }

    public function test_controller() {
        $session = array();	// Fake session
        $root = self::$site->getRoot();

        // Valid login
        $controller = new Calendar\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "bart477"));

        $this->assertEquals("Simpson, Bart", $session[Calendar\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/index.php", $controller->getRedirect());

        // Invalid login
        $controller = new Calendar\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "wrongpassword"));

        $this->assertNull($session[Calendar\User::SESSION_NAME]);
        $this->assertEquals("$root/login.php?e", $controller->getRedirect());
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet(){
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public function getConnection(){
        return $this->createDefaultDBConnection(self::$site->pdo(), 'mujtabad');
    }



    private static $site;
}

/// @endcond
?>
