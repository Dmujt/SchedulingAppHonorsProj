<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:45 AM
 */

namespace Calendar;


class Task
{
    private $strname;
    private $description;
    private $completed=0;
    private $userid;

    /**
     * @return mixed
     */
    public function getStrname()
    {
        return $this->strname;
    }

    /**
     * @param mixed $name
     */
    public function setStrname($strname)
    {
        $this->strname = $strname;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * @param boolean $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function __construct($row){
        $this->strname  =$row['strname'];
        $this->description = $row['description'];
        $this->completed = $row['completed'];
        $this->userid = $row['userid'];
    }
}