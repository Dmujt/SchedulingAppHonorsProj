<?php

namespace Calendar;


class CreateUserController extends Controller {
    /**
     * CreateUserController constructor.
     * @param Site $site Site object passing to the controller
     * @param array $post Post from the create user page
     */
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        if(isset($post['email']) and isset($post['submit']) and isset($post['name'])){
            $email = trim(strip_tags($post['email']));
            $name = trim(strip_tags($post['name']));

            $users= new Users($site);
            $user = new User(array('email' => $email,
                'name' => $name));
            $mailer = new Email();
            if(!$users->exists($email)){
                $users->add($user, $mailer);
                $this->redirect="$root/index.php";
            } else {
                $this->redirect = "$root/new-user.php?e=0";
            }
        } else {
            $this->redirect = "$root/new-user.php?e=1";
        }

    }
}