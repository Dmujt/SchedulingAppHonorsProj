<?php
/**
 * Created by PhpStorm.
 * User: Cornelius
 * Date: 4/6/2017
 * Time: 8:49 AM
 */

namespace Calendar;


class User {
    private $id;		///< The internal ID for the user
    private $email;		///< Email address
    private $name; 		///< Name as last, first

    const SESSION_NAME = 'user';

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct(array $row) {
        if (isset($row['id'])) {
            $this->id = $row['id'];
        } else {
            $this->id = 0;
        }

        $this->email = $row['email'];
        $this->name = $row['name'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}