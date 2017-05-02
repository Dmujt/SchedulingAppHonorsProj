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

    public function __construct(Site $site,$user)
    {
        $this->setSite($site);
        $this->user = $user;
        $this->setTitle("Calendar Home");
        $this->addLink("tasks.php", "Todo List");
        $this->addLink("events.php", "Events");
        $this->addLink("calendar.php", "Calendar");
        $this->addLink("./post/logout.php", "Log Out");
       // $this->setBg("cal");
    }

    /**
     * @return HTML for home page
     */

    public function present()
    {
        $html = "<h1>Monthly Calendar</h1>";
        $html .= $this->calendarDisplay();
        return $html;
    }
    private function calendarDisplay(){
        $dy = date("j"); // today's date
        $mon = date('m'); // month num
        $year = date("Y"); // yr in 4 digits
        $dateinfo = getdate(mktime(0,0,0,$mon, 1, $year)); // info for 1st day of mon

        $year = $dateinfo["year"];
        $month = $dateinfo["month"];
        $firstweekday = $dateinfo["wday"]; // 0 - 6 num for weekday
        //get the last day of the month
        $lastday = $this->getMonLastDay($mon, $mon, intval($year));

        $events = new Events($this->getSite());
        $html = <<<HTML
<div id="calendararea" class="card">
<div class="month"> 
  <p>
    $month $year
  </p>
</div>
<ul class="weekdays">
  <li>Mo</li>
  <li>Tu</li>
  <li>We</li>
  <li>Th</li>
  <li>Fr</li>
  <li>Sa</li>
  <li>Su</li>
</ul>
<ul class="days">
HTML;

        $day = 1;
        for($i=1; $i<=$firstweekday; $i++){
            $html .='<li class="notday"></li>'; //empty
        }
        while($day <= $lastday){
            //loop through each day
            $datereal = "$year-$mon-$day";
            $class="";
            if($day == $dy){
                //today highlight
                $class="today";
            }
            $html .= <<<HTML
<li class="$class">
$day
HTML;
            $todaysevents = $events->getToday($datereal, $this->user->getId());
            if($todaysevents != null){
                $html .= "<ul>";
                foreach ($todaysevents as $event) {
                    $name = $event['strname'];
                    $html.= <<<HTML
<li>
$name
</li>               
HTML;
                }

                    $html .="</ul>";
            }
            $html .=<<<HTML
</li>
HTML;
            $day ++;
    }

        $html .="</ul></div>";
        return $html;
    }

    private function getMonLastDay($mon,$month, $year){
        $cont = true;
        $today = 27;
        $lastday = 0;
        while($today <=32 && $cont ){
            //increment today date
            $dtoday = getdate(mktime(0,0,0,$month,$today,$year));
            if($dtoday["mon"] != $mon){
                $lastday = $today - 1;
                $cont = false;
            }
            $today ++;
        }
        return $lastday;
    }
    private $user;
}