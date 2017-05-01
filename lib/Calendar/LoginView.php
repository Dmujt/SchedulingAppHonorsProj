<?php
namespace Calendar;


class LoginView extends View{

    // constructor
    private $session;
    private $get;

    /**
     * LoginView constructor.
     * @param $sess
     * @param $get
     * set title and nav
     */
    public function __construct($sess, $get) {
        $this->session = $sess;
        $this->get = $get;
        $this->setTitle("Login");
        $this->addLink("./", "Homepage");
    }


    /**
     * @return HTML for login page
     * present the form if needed
     */
    public function present() {
        $html = <<<HTML
<form method="post" action="./post/login.php" class="initial-gameform">
<fieldset>
<legend>Login</legend>
		<p>
			<label for="email">Email</label>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" id="password" name="password" placeholder="Password">
		</p>
		<p>
			<input type="submit" value="Login" name="login" id="login"> 
<a href="./lostpassword.php">Lost Password</a>
        </p>
        </fieldset>
</form>
HTML;
    return $html;

    }

    // need functions for potential errors to show to the user // could model after Step 8

    public function errorPresent() {

        if (isset($this->get['e'])) {
            return '<p class="errorp">ERROR: Invalid user / password</p>';
        }

        else {
            return '';
        }

    }

}