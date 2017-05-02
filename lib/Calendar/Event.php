<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:45 AM
 */

namespace Calendar;


class Event
{
    private $name;
    private $description;
    private $whendate;
    private $location;
    private $userid;

    public function __construct($row){
        $this->strname  =$row['strname'];
        $this->description = $row['description'];
        $this->whendate = $row['whendate'];
        $this->location = $row['location'];
        $this->userid = $row['userid'];
    }

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
     * @return mixed
     */
    public function getWhenDate()
    {
        return $this->whendate;
    }

    /**
     * @param mixed $whendate
     */
    public function setWhenDate($whendate)
    {
        $this->whendate = $whendate;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
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
}