<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:51 AM
 */

namespace Calendar;


class EventsController extends Controller
{

    /**
     * GamesController constructor.
     * @param Site $site object passing to Games controller
     * @param array $post gamesview
     * @param $user user object
     * websocket installed
     */
    public function __construct(Site $site, array $post, $user)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/events.php";
        $events = new Events($site);

        if (isset($post['newtask'])) {
            //create new
            $arr = array(
                'strname'=> strip_tags($post['name']),
                'description'=>strip_tags($post['description']),
                'location'=>strip_tags($post['location']),
                'whendate'=>strip_tags($post['whendate']),
                'userid'=>$user->getId()
            );
            $e = new Event($arr);

            $events->create($e);
        } else if (isset($post['edit'])) {
            //edit
            $this->redirect = "$root/event.php?t=".strip_tags($post['id']);
        } else if (isset($post['delete'])) {
            //delete
            $id = intval(strip_tags($post['id']));
            $events->delete($id);
        }else if(isset($post['update'])){
            if(isset($post['id'])){
                $arr = array(
                    'strname'=> strip_tags($post['name']),
                    'description'=>strip_tags($post['description']),
                    'location'=>strip_tags($post['location']),
                    'whendate'=>strip_tags($post['whendate']),
                );
                $e = new Event($arr);
                $events->update($e, intval(strip_tags($post['id'])));
            }
        }
    }
}