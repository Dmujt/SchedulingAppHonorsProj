<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:54 AM
 */

namespace Calendar;


class TaskView extends View
{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */
    private $taskinfo;
    public function __construct($site, $user, $get)
    {
        $this->setSite($site);
        $this->taskinfo = $get;
        $this->user = $user;
        $this->setTitle("Calendar Home");
        $this->addLink("tasks.php", "Todo List");
        $this->addLink("events.php", "Events");
        $this->addLink("calendar.php", "Calendar");
        $this->addLink("./post/logout.php", "Log Out");
        $this->setBg("tt");
    }


    /**
     * @return HTML for home page
     */

    public function present()
    {
        $html = "<h1>Tasks</h1>";
        $html .= $this->newForm();
        return $html;
    }

    private function newForm(){
        $html = "";
        $tasks = new Tasks($this->getSite());
        if(isset($this->taskinfo['t'])){
            $task = $tasks->get(strip_tags($this->taskinfo['t']));
                if ($task != null) {
                    $name = $task->getStrname();
                    $description = $task->getDescription();
                    $id = strip_tags($this->taskinfo['t']);
                    $html = <<<HTML
 <div class="card">
   <h5>
     Edit Task
   </h5>
   <form action="post/task.php" method="POST">
    <input type="hidden" value="$id" name="id" />
     <input type="text" name="name" placeholder="Task Title" value="$name"/>
     <textarea name="description" placeholder="Description">$description</textarea>
     <input type="submit" value="Save" class="btn" name="update" />
   </form>
  </div>
HTML;
                }
        }

        return $html;
    }

}