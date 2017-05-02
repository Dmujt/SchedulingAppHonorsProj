<?php

namespace Calendar;


class PasswordValidateController
{
    /**
     * PasswordValidateController constructor.
     * @param Site $site
     * @param array $post
     */
    public function __construct(Site $site, array $post) {
        $root = $site->getRoot();
        //$this->redirect = "$root/";

        // if you hit cancel you go back to the root page
        if (isset($post['cancel'])) {

        }
        else if (isset($post['ok'])){
            //
            // 1. Ensure the validator is correct! Use it to get the user ID.
            // 2. Destroy the validator record so it can't be used again!
            //
            $validators = new Validators($site);
            $userid = $validators->get($post['validator']);
            if($userid === null) {
                //$this->redirect = "$root/";
                $this->redirect = "password-validate.php?e=1";
                return;
            }

            // test the email and passwords for valid
            $users = new Users($site);
            $editUser = $users->get($userid);
            if($editUser === null) {
                // User does not exist!
                //$this->redirect = "$root/";
                $this->redirect = "password-validate.php?e=1";
                return;
            }

            $email = trim(strip_tags($post['email']));
            if($email !== $editUser->getEmail()) {
                // Email entered is invalid
                $this->redirect = "$root/password-validate.php?e=1" . "&v=" . $post['validator'];
                return;
            }

            $password1 = trim(strip_tags($post['password']));
            $password2 = trim(strip_tags($post['password2']));
            if($password1 !== $password2) {
                // Passwords do not match
                $this->redirect = "$root/password-validate.php?e=2" . "&v=" . $post['validator'];
                return;
            }

            if(strlen($password1) < 8) {
                // Password too short
                $this->redirect = "$root/password-validate.php?e=3" . "&v=" . $post['validator'];
                return;
            }

            $validators->remove($post['validator']);
            $users->setPassword($userid, $password1);
        }
        $this->redirect = "$root/";

    }

    private $redirect; ///< Page we will redirect the user to.

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }
}