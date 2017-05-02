<?php

namespace Calendar;


class HomeView extends View{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */

    public function __construct(Site $site, $user){
        $this->setSite($site);
        $this->user=$user;
        $this->setTitle("Calendar Home");
        $this->addLink("tasks.php", "Todo List");
        $this->addLink("events.php", "Events");
        $this->addLink("calendar.php", "Calendar");
        $this->addLink("./post/logout.php", "Log Out");
        $this->setBg("main");
    }

    /**
     * @return HTML for home page
     */

    public function present(){
        $html = "";
        $tv = new TasksView($this->getSite(), $this->user);
        $ev = new EventsView($this->getSite(), $this->user);
        $html.= $tv->uncompleteList();
        $html.= $ev->futureEvents();
        return $html;
    }

    private $user;
}