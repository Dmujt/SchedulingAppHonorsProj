<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:46 AM
 */

namespace Calendar;


class CalendarView extends View
{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */

    public function __construct($user)
    {
        $this->user = $user;
        $this->setTitle("Calendar Home");
        $this->addLink("tasks.php", "Todo List");
        $this->addLink("events.php", "Events");
        $this->addLink("calendar.php", "Calendar");
        $this->addLink("./post/logout.php", "Log Out");
        $this->setBg("cal");
    }

    /**
     * @return HTML for home page
     */

    public function present()
    {
        $html = "<h1>Weekly Calendar</h1>";

        return $html;
    }

    private $user;
}