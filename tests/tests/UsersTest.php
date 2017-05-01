<?php

require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class EmailMock extends Calendar\Email {
    public function mail($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    public $to;
    public $subject;
    public $message;
    public $headers;
}

class UsersTest extends \PHPUnit_Extensions_Database_TestCase
{
	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'mujtabad');
    }

    public function test_construct() {
        $users = new Calendar\Users(self::$site);
        $this->assertInstanceOf('Calendar\Users', $users);
    }

    public function test_update() {
        $users = new Calendar\Users(self::$site);
        $user = $users->login("dudess@dude.com", "87654321");

        $user->setName("Rude Dude");
        $this->assertTrue($users->update($user));

        $user->setEmail("cbowen@cse.msu.edu");
        $this->assertFalse($users->update($user));
    }

    public function test_add() {
        $users = new Calendar\Users(self::$site);
        $user7 = $users->get(7);

        $mailer = new EmailMock();

        $this->assertContains("Email address already exists",
            $users->add($user7, $mailer));

        $row = array('id' => 0,
            'email' => 'dude@ranch.com',
            'name' => 'Dude, The',
            'password' => '12345678'
        );
        $user = new Calendar\User($row);
        $users->add($user, $mailer);

        $table = $users->getTableName();
        $sql = <<<SQL
select * from $table where email='dude@ranch.com'
SQL;

        $stmt = $users->pdo()->prepare($sql);
        $stmt->execute();
        $this->assertEquals(1, $stmt->rowCount());
        $this->assertEquals("dude@ranch.com", $mailer->to);
        $this->assertEquals("Confirm your email", $mailer->subject);
    }

    public function test_setPassword() {
        $users = new Calendar\Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertNotNull($user);
        $this->assertEquals("Dudess, The", $user->getName());

        // Change the password
        $users->setPassword(7, "dFcCkJ6t");

        // Old password should not work
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertNull($user);

        // New password does work!
        $user = $users->login("dudess@dude.com", "dFcCkJ6t");
        $this->assertNotNull($user);
        $this->assertEquals("Dudess, The", $user->getName());
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    /*
    public function test_login() {
        $users = new Calendar\Users(self::$site);

        // Test a valid login based on user ID
        $user = $users->login("dudess@dude.com", "87654321");
        $this->assertInstanceOf('Calendar\User', $user);

        // Test a valid login based on email address
        $user = $users->login("cbowen@cse.msu.edu", "super477");
        $this->assertInstanceOf('Calendar\User', $user);

        // Test a failed login
        $user = $users->login("dudess@dude.com", "wrongpw");
        $this->assertNull($user);
    }
    */

    public function test_get() {
        $users = new Calendar\Users(self::$site);
        $user = $users->get(7);
        $this->assertInstanceOf('Calendar\User', $user);

        $user = $users->get(0);
        $this->assertNull($user);
    }

    public function test_exists() {
        $users = new Calendar\Users(self::$site);

        $this->assertTrue($users->exists("dudess@dude.com"));
        $this->assertFalse($users->exists("dudess"));
        $this->assertFalse($users->exists("cbowen"));
        $this->assertTrue($users->exists("cbowen@cse.msu.edu"));
        $this->assertFalse($users->exists("nobody"));
        $this->assertFalse($users->exists("7"));
    }

    /*
    public function test_getClients() {
        $users = new Calendar\Users(self::$site);

        $clients = $users->getClients();

        $this->assertEquals(2, count($clients));
        $c0 = $clients[0];
        $this->assertEquals(2, count($c0));
        $this->assertEquals(9, $c0['id']);
        $this->assertEquals("Simpson, Bart", $c0['name']);
        $c1 = $clients[1];
        $this->assertEquals(10, $c1['id']);
        $this->assertEquals("Simpson, Marge", $c1['name']);
    }
    */

    private static $site;

    public static function setUpBeforeClass() {
        self::$site = new Calendar\Site();
        $localize  = require __DIR__ . '/localize.inc.php';
        if(is_callable($localize)) {
            print_r("\nLOCALIZED\n");
            $localize(self::$site);
        }
    }
	
}

/// @endcond
?>
