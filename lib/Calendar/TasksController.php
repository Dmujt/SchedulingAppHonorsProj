<?php
/**
 * Created by PhpStorm.
 * User: Dena
 * Date: 5/2/2017
 * Time: 8:12 AM
 */

namespace Calendar;


class TasksController extends Controller{

    /**
     * GamesController constructor.
     * @param Site $site object passing to Games controller
     * @param array $post gamesview
     * @param $user user object
     * websocket installed
     */
    public function __construct(Site $site, array $post, $user){
        $root = $site->getRoot();
        $this->redirect = "$root/tasks.php";
        $tasks = new Tasks($site);

        if(isset($post['newtask'])){
            //create new task
            $arr = array(
                'strname'=> strip_tags($post['name']),
                'completed'=>0,
                'description'=>strip_tags($post['description']),
                'userid'=>$user->getId()
            );
            $task = new Task($arr);

            $tasks->create($task);
        }else if(isset($post['edit'])){
            //edit task
            $this->redirect = "$root/task.php?t=".strip_tags($post['id']);
        }else if(isset($post['markdone'])){
            //complete task
            $id = intval(strip_tags($post['id']));
            $tasks->markComplete($id);
        }else if(isset($post['delete'])){
            //delete task
            $id = intval(strip_tags($post['id']));
            $tasks->delete($id);
        }else if(isset($post['marknotdone'])){
            $id = intval(strip_tags($post['id']));
            $tasks->markUnComplete($id);
        }else if(isset($post['update'])){
            if(isset($post['id'])){
                $arr = array(
                    'strname'=> strip_tags($post['name']),
                    'completed'=>0,
                    'description'=>strip_tags($post['description']),
                    'userid'=>$user->getId()
                );
                $task = new Task($arr);
                $tasks->update($task, intval(strip_tags($post['id'])));
            }
        }
    }
}