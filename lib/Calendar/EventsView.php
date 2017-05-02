<?php
/**
 * Created by PhpStorm.
 * User: Dena
 * Date: 5/1/2017
 * Time: 11:03 PM
 */

namespace Calendar;


class EventsView extends View
{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */

    public function __construct(Site $site, $user)
    {        $this->setSite($site);

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
        $html .= $this->futureEvents();
        $html .= $this->pastEvents();

        return $html;
    }

    private function newForm(){
        $whendate = date( 'Y-m-d', time() );
        $html = <<<HTML
 <div class="card">
   <h5>
     New Event
   </h5>
   <form action="post/event.php" method="POST">
     <input type="text" name="name" placeholder="Event Name"/>
     <textarea name="description" placeholder="Description"></textarea>
     <div class="dualinput">
            <div class="form-field">
                <label>Where</label>
       <input type="text" name="location" placeholder="location"/>
       </div>
       <div class="form-field">
                <label>When</label>
       <input type="date" name="whendate" value="$whendate"/>
       </div>

     </div>     <input type="submit" value="+" class="plus" name="newtask" />
   </form>
  </div>
HTML;
        return $html;
    }


    public function futureEvents(){
        $html = <<<HTML
   <div class="card">
   <h4>
     Upcoming Events
   </h4>
<ul>
HTML;
        $t = new Events($this->getSite());
        $tasks = $t->getFuture($this->user->getId());
        foreach ($tasks as $task) {
            $title = $task['strname'];
            $description = $task['description'];
            $phpdate = strtotime( $task['whendate'] );
            $whendate = date( 'm/d/Y', $phpdate );
            $location = $task['location'];
            $id = $task['id'];
            $html .= <<<HTML
    <li>
    <form method="POST" action="post/event.php">
    <input type="hidden" name="id" value="$id" />
      <p>
        $title
      </p><input type="submit" value="Edit" class="edit" name="edit"/>
      <p class="description">
        $description
        <span>
        <span>
        <i class="fa fa-map-marker"></i>$location &nbsp;
         <i class="fa fa-clock-o"></i>$whendate
         </span>
</span>
      </p>

      <input type="submit" value="Delete" class="delete" name="delete"/>
    </form>
  </li>

HTML;
        }
        $html .= <<<HTML
     </ul>
  </div>
HTML;

        return $html;
    }

    private function pastEvents(){
        $html = <<<HTML
   <div class="card">
   <h4>
     Past Events
   </h4>
<ul>
HTML;
        $t = new Events($this->getSite());
        $tasks = $t->getPast($this->user->getId());
        foreach ($tasks as $task) {
            $title = $task['strname'];
            $description = $task['description'];
            $phpdate = strtotime( $task['whendate'] );
            $whendate = date( 'm/d/Y', $phpdate );
            $location = $task['location'];
            $id = $task['id'];
            $html .= <<<HTML
    <li class="done">
    <form method="POST" action="post/event.php">
    <input type="hidden" name="id" value="$id" />
      <p>
        $title
      </p><input type="submit" value="Edit" class="edit" name="edit"/>
      <p class="description">
        $description
        <span>
        <span>
        <i class="fa fa-map-marker"></i>$location &nbsp;
         <i class="fa fa-clock-o"></i>$whendate
         </span>
</span>
      </p>

      <input type="submit" value="Delete" class="delete" name="delete"/>
    </form>
  </li>

HTML;
        }
        $html .= <<<HTML
     </ul>
  </div>
HTML;

        return $html;
    }


    private $user;
}