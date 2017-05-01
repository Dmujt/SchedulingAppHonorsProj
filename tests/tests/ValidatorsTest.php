<?php

require __DIR__ . "/../../vendor/autoload.php";

/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class EmptyDBTest extends \PHPUnit_Extensions_Database_TestCase
{
	/**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */

    private static $site;

    public function getConnection()
    {

        return $this->createDefaultDBConnection(self::$site->pdo(), 'mujtabad');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        //return new PHPUnit_Extensions_Database_DataSet_DefaultDataSet();

        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
    }
    public static function setUpBeforeClass() {
        self::$site = new Calendar\Site();
        //TODO: fix not found Calendar\Site
        $localize  = require __DIR__ . '/localize.inc.php';
        if(is_callable($localize)) {
            print_r("\nLOCALIZED\n");
            $localize(self::$site);
        }
    }



    public function test_construct() {
        $validator = new Calendar\Validators(self::$site);
        $this->assertInstanceOf('Calendar\Validators', $validator);
    }


    public function test_newValidator() {
        $validators = new Calendar\Validators(self::$site);

        $validator = $validators->newValidator(27);
        $this->assertEquals(32, strlen($validator));

        $table = $validators->getTableName();
        $sql = <<<SQL
select * from $table
where userid=? and validator=?
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array(27, $validator));
        $this->assertEquals(1, $stmt->rowCount());
    }


    public function test_getOnce() {
        $validators = new Calendar\Validators(self::$site);

        // Test a not-found condition
        $this->assertNull($validators->getOnce(""));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(27);
        $validator2 = $validators->newValidator(27);

        $this->assertEquals(27, $validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(33);
        $validator2 = $validators->newValidator(33);

        $this->assertEquals(33, $validators->getOnce($validator2));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));
    }


    public function test_remove(){
        //remove is simply return getOnce function for now
        //therefore I am creating the same unit tests
        //until there is further change in remove function
        $validators = new Calendar\Validators(self::$site);

        // Test a not-found condition
        $this->assertNull($validators->getOnce(""));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(27);
        $validator2 = $validators->newValidator(27);

        $this->assertEquals(27, $validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(33);
        $validator2 = $validators->newValidator(33);

        $this->assertEquals(33, $validators->getOnce($validator2));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));

    }

    public function test_get(){
        $validators = new \Calendar\Validators(self::$site);
        $this->assertNull($validators->get(""));
        $validator = $validators->newValidator(27);
        $this->assertEquals(27,$validators->get($validator));

    }
}

/// @endcond
?>
