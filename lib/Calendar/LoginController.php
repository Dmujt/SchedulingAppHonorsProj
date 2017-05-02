<?php

namespace Calendar;


class LoginController{
    /**
     * LoginController constructor.
     * @param Site $site
     * @param array $session
     * @param array $post
     */
    public function __construct(Site $site, array &$session, array $post){
        $root = $site->getRoot();
        if(isset($post['home'])){
            $this->redirect="$root/index.php";
            return;
        }
        else if(isset($post['lost'])){
            $this->redirect="$root/lostpassword.php";
            return;
        }

        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        if($user === null) {
            // Login failed
            $this->redirect = "$root/login.php?e";
        } else {
            $this->redirect="$root/index.php";
        }

    }

    /**
     * @return page redirect to
     */
    public function getRedirect(){
        return $this->redirect;
    }

    private $redirect;  ///< Page we will redirect the user to.
}