<?php
/**
 * Created by PhpStorm.
 * User: alaina
 * Date: 4/6/17
 * Time: 1:19 PM
 */

namespace Calendar;


class HomeController extends Controller{

    /**
     * HomeController constructor.
     * @param Site $site object passed to home controller
     * @param array $post
     * @param $user
     * redirect to corresponding pages
     */
    public function __construct(Site $site, array $post, $user){
        parent::__construct($site,$post);

        $root=$site->getRoot();
        if(isset($post['login'])){
            $this->redirect="$root/login.php";
        }
        else if (isset($post['howto'])){
            $this->redirect="$root/how-to-play.php";
        }
        else if(isset($post['games'])){
            $games = new Games($site);
            if (($user !== null) and ($games->exists($user->getId()))) {
                $this->redirect = "$root/post/games.php";
            } else {
                $this->redirect="$root/games.php";
            }
        }
        else if(isset($post['logout'])){
            $this->redirect="$root/post/logout.php";
        }
        else if(isset($post['create'])){
            $this->redirect="$root/new-user.php";
        }
    }

    

}