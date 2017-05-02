<?php
/**
 * Created by PhpStorm.
 * User: Dena
 * Date: 5/1/2017
 * Time: 11:02 PM
 */

namespace Calendar;


class TasksView extends View
{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */

    public function __construct(Site $site,$user)
    {
        $this->setSite($site);
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
        $html.= $this->uncompleteList();
        $html .= $this->completedList();
        return $html;
    }

    private function newForm(){
    $html = <<<HTML
 <div class="card">
   <h5>
     New Task
   </h5>
   <form action="post/task.php" method="POST">
     <input type="text" name="name" placeholder="Task Title"/>
     <textarea name="description" placeholder="Description"></textarea>
     <input type="submit" value="+" class="plus" name="newtask" />
   </form>
  </div>
HTML;
    return $html;
    }

    private function completedList(){
        $html = <<<HTML
   <div class="card">
   <h4>
     Completed
   </h4>
<ul>
HTML;
        $t = new Tasks($this->getSite());
        $tasks = $t->getComplete($this->user->getId());
        foreach ($tasks as $task) {
            $title = $task['strname'];
            $description = $task['description'];
            $id = $task['id'];

            $html .= <<<HTML
    <li class="done">
    <form method="POST" action="post/task.php">
    <input type="hidden" name="id" value="$id" />
      <p>
        $title
      </p>
      <p class="description">
        $description
      </p>
      <input type="submit" value="✗" class="plus incomplete"  name="marknotdone"/>

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

    public function uncompleteList(){
        $html = <<<HTML
   <div class="card">
   <h4>
     Incomplete Tasks
   </h4>
<ul>
HTML;
        $t = new Tasks($this->getSite());
        $tasks = $t->getUnComplete($this->user->getId());
        foreach ($tasks as $task) {
            $title = $task['strname'];
            $description = $task['description'];
            $id = $task['id'];

            $html .= <<<HTML
    <li >
    <form method="POST" action="post/task.php">
    <input type="hidden" name="id" value="$id" />
      <p>
        $title
      </p>
       <input type="submit" value="Edit" class="edit" name="edit"/>
      <p class="description">
        $description
      </p>

      <input type="submit" value="Delete" class="delete" name="delete"/>
      <input type="submit" value="✔" class="plus"  name="markdone"/>
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