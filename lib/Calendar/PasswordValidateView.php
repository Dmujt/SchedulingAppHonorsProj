<?php
namespace Calendar;


class PasswordValidateView extends View{
    //private $site;
    private $get;
    private $validator;

    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    //$site,
    public function __construct($get) {

        //$this->site = $site;
        $this->get = $get;

        //$this->addLink("login.php", "Log in");

        if (isset($get['v'])) {
            $this->validator = strip_tags($get['v']);
        }

    }

    /**
     * @return HTML for password validate function
     */

    public function present() {
        $err = $this->error_msg();
        $html = <<<HTML
<form class="login" method="post" action="./post/password-validate.php">
<input type="hidden" name="validator" value="$this->validator">
	<fieldset>
		<legend>Change Password</legend>
		<span class="error">
		$err
</span>
		<p>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<input type="password" id="name" name="password" placeholder="Password">
		</p>
		<p>
			<input type="password" id="phone" name="password2" placeholder="Confirm Password">
		</p>
		<p>
			<input type="submit" name="ok" value="OK"> <input type="submit" name="cancel" value="Cancel">
		</p>

	</fieldset>
</form>
HTML;

        return $html;
    }
    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    public function error_msg() {
        if(isset($this->get["e"])) {
            if ($this->get["e"] == 1) {
                return '<p class="errorp">ERROR: Email does not exist, Please Request New Validation</p>';
            }
            if ($this->get["e"] == 2) {
                return '<p class="errorp">ERROR: Passwords do not match, Please Request New Validation</p>';
            }
            if ($this->get["e"] == 3) {
                return '<p class="errorp">ERROR: Password too short, Please Request New Validation</p>';
            }
        }
        else {
            return '';
        }

    }

}