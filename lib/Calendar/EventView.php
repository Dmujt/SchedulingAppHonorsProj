<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:54 AM
 */

namespace Calendar;


class EventView extends View
{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */
    private $eventinfo;
    public function __construct($site, $user, $get)
    {
        $this->setSite($site);
        $this->eventinfo = $get;
        $this->user = $user;
        $this->setTitle("Calendar Home");
        $this->addLink("tasks.php", "Todo List");
        $this->addLink("events.php", "Events");
        $this->addLink("calendar.php", "Calendar");
        $this->addLink("./post/logout.php", "Log Out");
        $this->setBg("ev");
    }


    /**
     * @return HTML for home page
     */

    public function present()
    {
        $html = "<h1>Events</h1>";
        $html .= $this->newForm();
        return $html;
    }
    private function newForm(){
        $html = "";
        $events = new Events($this->getSite());
        if(isset($this->eventinfo['t'])){
            $e = $events->get(strip_tags($this->eventinfo['t']));
            if ($e != null) {
                $name = $e->getStrname();
                $description = $e->getDescription();
                $whendate = strtotime( $e->getWhenDate() );
                $whendate = date( 'Y-m-d', $whendate );
                $location = $e->getLocation();
                $id = strip_tags($this->eventinfo['t']);
                $html = <<<HTML
 <div class="card">
   <h5>
     Edit Event
   </h5>
   <form action="post/event.php" method="POST">
    <input type="hidden" value="$id" name="id" />
     <input type="text" name="name" placeholder="Task Title" value="$name"/>
     <textarea name="description" placeholder="Description">$description</textarea>
          <div class="dualinput">
            <div class="form-field">
                <label>Where</label>
       <input type="text" name="location" placeholder="location" value="$location"/>
       </div>
       <div class="form-field">
                <label>When</label>
       <input type="date" name="whendate" value="$whendate"/>
       </div>

     </div>
     <input type="submit" value="Save" class="btn" name="update" />
   </form>
  </div>
HTML;
            }
        }

        return $html;
    }
}