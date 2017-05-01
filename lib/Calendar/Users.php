<?php

namespace Calendar;


class Users extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "user");
    }

    public function remove($userid)
    {
        $tname = $this->tableName;
        $sql = <<<SQL
DELETE FROM $tname
WHERE id = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    public function get($id)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if ($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($email)
    {
        $tname = $this->tableName;
        $sql = <<<SQL
SELECT $tname.email
FROM $tname
WHERE $tname.email = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));

        return count($statement->fetchAll(\PDO::FETCH_ASSOC)) != 0;
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
    public function update(User $user)
    {
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE id=?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($user->getId()));

        if ($statement->rowCount() === 0) {
            return false;
        }

        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE email=?;
SQL;

        $statement = $pdo->prepare($sql);
        $statement->execute(array($user->getEmail()));

        if ($statement->rowCount() !== 0) {
            for ($i = 0; $i < $statement->rowCount(); $i++) {
                $row = $statement->fetch(\PDO::FETCH_ASSOC);
                if ($row['id'] !== $user->getId()) {
                    return false;
                }
            }
        }

        $sql = <<<SQL
UPDATE $this->tableName
SET email=?, name=?
WHERE id=?;
SQL;
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($user->getEmail(), $user->getName(), $user->getId()));

        } catch (\PDOException $e) {
            return false;
        }


        if (!$statement->rowCount()) {
            return false;
        }

        return $ret;
    }


    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer)
    {
        // Ensure we have no duplicate email address
        // Ensure we have no duplicate email address
        if ($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(name, email)
values(?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($user->getName(), $user->getEmail()));
        $id = $this->pdo()->lastInsertId();

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu" . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Calendar. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password)
    {
        $sql = <<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if ($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if ($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function randomSalt($len = 16)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password)
    {
        $salt = $this->randomSalt();
        $hash = hash("sha256", $password . $salt);

        if ($this->get($userid) === null) {

            return false;
        }

        $tname = $this->tableName;
        $sql = <<<SQL
UPDATE $tname SET salt = ?, password = ? WHERE id = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($salt, $hash, $userid));

        return true;
    }

    /**
     * @param $email of account w/ lost password
     * @return null if invalid email
     */
    public function lost_password($email){
        $sql = <<<SQL
SELECT * 
FROM $this->tableName
WHERE email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(trim(strip_tags($email))));
        if ($statement->rowCount() === 0) {
            return null;
        }

        $mailer = new Email();
        $user = new User($statement->fetch(\PDO::FETCH_ASSOC));
        $id = $user->getId();
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);
        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu" . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Lost Calendar Password";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>We heard you are having trouble remembering your password.
In order to change your password please visit the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);
        return $user;
    }
}