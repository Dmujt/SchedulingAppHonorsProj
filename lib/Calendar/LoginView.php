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
        $this->setTitle("Log In");
    }


    /**
     * @return HTML for login page
     * present the form if needed
     */
    public function present() {
        $err = $this->errorPresent();
        $html = <<<HTML
          <div id="introfield">
    <h1>
      <i class="fa fa-calendar">
      </i>
    </h1>
  </div>
<form method="post" action="./post/login.php" class="initial-gameform">
	<fieldset>
		<legend>Login</legend>
		<span class="error">
		$err
</span>
		<p>

			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<input type="password" id="password" name="password" placeholder="Password">
		</p>
		<p>
			<input type="submit" name="login" value="Login"> <a href="./lostpassword.php">Lost Password</a> <a href="./new-user.php">Sign Up</a>
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