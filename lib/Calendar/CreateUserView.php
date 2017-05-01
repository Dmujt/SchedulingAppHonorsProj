<?php
/**
 * Created by PhpStorm.
 * User: Cornelius
 * Date: 4/7/2017
 * Time: 1:05 PM
 */

namespace Calendar;


class CreateUserView extends View {
    private $site;
    private $error;

    /**
     * CreateUserView constructor.
     * @param Site $site Site $site object passing to construct
     * @param array $get Get from URL
     * return error message if input is invalid or wrong
     */
    public function __construct(Site $site, array $get) {
        $this->setTitle("Create User");
        $this->addLink("./", "Homepage");
        $this->site = $site;
        $this->error = "";
        if (isset($get['e'])) {
            $this->error .= "<p  class=\"errorp\">";

            if ($get['e'] == 0) {
                $this->error .= "User email already exists.";
            } else if ($get['e'] == 1) {
                $this->error .= "Please enter a valid username/email.";
            } else {
                $this->error .= "An unspecified error has occured.";
            }

            $this->error .= "</p>";
        }
    }

    /**
     * return HTML for Create User page
     */

    public function present() {
        $html = <<<HTML
<form action="post/new-user.php" method="post">
	<fieldset>
	$this->error
		<legend>Create User</legend>
		<p>
			<label for="email">Email</label>
			<input type="email" id="email" name="email" placeholder="Email">
		</p>
		<p>
			<label for="name">Name</label>
			<input type="text" id="name" name="name" placeholder="Name">
		</p>
		<p>
			<input type="submit" name="submit" value="Submit"> <a href="./lostpassword.php">Lost Password</a>
		</p>
	</fieldset>
</form>
HTML;
        return $html;
    }
}