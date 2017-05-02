<?php

namespace Calendar;


class LostPasswordController extends Controller{

    /**
     * LostPasswordController constructor.
     * @param Site $site
     * @param array $post
     */
    public function __construct(Site $site,array $post){
        $root=$site->getRoot();
        if(isset($post['email']) and isset($post['submit'])){
            $email=$post['email'];
            $users= new Users($site);
            if($users->exists($email)){
                $ret = $users->lost_password($email);
                if ($ret === null) {
                    $this->redirect = "$root/lostpassword.php?e";
                }
            }
        }
        $this->redirect="$root/index.php";
    }

}