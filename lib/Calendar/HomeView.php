<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/6/17
 * Time: 1:14 PM
 */

namespace Calendar;


class HomeView extends View{
    /**
     * HomeView constructor.
     * @param $user
     * set title
     */

    public function __construct($user){
        $this->user=$user;
        $this->setTitle("Calendar Home");

    }

    /**
     * @return HTML for home page
     */

    public function present(){
        if ($this->user === null) {
            $html=<<<HTML
<p class="hp">
Welcome to Calendar! </p>
HTML;
        } else {
            $name = $this->user->getName();
            $html = <<<HTML
<p  class="hp">Welcome, $name!</p>
HTML;
        }

        $html .= <<<HTML
<form method="post" action="post/index.php" class="initial-gameform">
<p>
<input type="submit" value="How To Page" name="howto" id="howto"/>  
HTML;
        if($this->user === null) {
            $html .= <<<HTML
<input type="submit" value="Login" name="login" id="login"/>
<input type="submit" value="Create Account" name="create" id="create"/>
</p>
</form>
HTML;
        }
        else{
            $html .= <<<HTML
<input type="submit" value="View/Create Games" name="games" id="games"/>
<input type="submit" value="Logout" name="logout" id="logout"/>
</p>
</form>
HTML;
        }

        return $html;
    }

    private $user;
}