<?php


namespace Calendar;

class Site{

    /**
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * set email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * @return $root
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @param string $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }

    /**
     * @return string Table prefix
     */
    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }

    /**
     * Configure the database
     * @param $host
     * @param $user
     * @param $password
     * @param $prefix
     */
    public function dbConfigure($host, $user, $password, $prefix) {
        $this->dbHost = $host;
        $this->dbUser = $user;
        $this->dbPassword = $password;
        $this->tablePrefix = $prefix;
    }

    /**
     * Database connection function
     * @returns PDO object that connects to the database
     */
    function pdo() {
        // This ensures we only create the PDO object once
        if($this->pdo !== null) {
            return $this->pdo;
        }

        try {
            $this->pdo = new \PDO($this->dbHost, $this->dbUser, $this->dbPassword);
        } catch(\PDOException $e) {
            // If we can't connect we die!
            die("Unable to select database");
        }

        return $this->pdo;
    }

    private $email = '';        ///< Site owner email address
    private $dbHost = null;     ///< Database host name
    private $dbUser = null;     ///< Database user name
    private $dbPassword = null; ///< Database password
    private $tablePrefix = '';  ///< Database table prefix
    private $root = '';
    private $pdo = null; ///< The PDO object
}