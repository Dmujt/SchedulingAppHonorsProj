<?php


namespace Calendar;


class Validators extends Table
{
    public function __construct(Site $site)
    {
        parent::__construct($site, "validator");
    }

    /**
     * Determine if a validator is valid. If it is,
     * get the user ID for that validator. Then destroy any
     * validator records for that user ID. Return the
     * user ID.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     */
    public function getOnce($validator) {
        $tname = $this->tableName;
        $sql = <<<SQL
SELECT userid, validator FROM $tname WHERE validator = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));

        $v_rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (count($v_rows) != 1) {
            return null;
        }

        $userid = $v_rows[0]['userid'];

        $sql = <<<SQL
DELETE FROM $tname WHERE userid = ?;
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        return $userid;
    }

    public function get($validator) {
        $tname = $this->tableName;
        $sql = <<<SQL
SELECT userid, validator FROM $tname WHERE validator = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($validator));

        $v_rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if (count($v_rows) != 1) {
            return null;
        }

        $userid = $v_rows[0]['userid'];

        return $userid;
    }

    public function remove($validator) {
        // Change this to be more specific later.
        return $this->getOnce($validator);
    }

    /**
     * @brief Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    private function createValidator($len = 32) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        // Write to the table
        $tname = $this->tableName;
        $pdo = $this->pdo();
        $sql = <<<SQL
INSERT INTO $tname (userid, validator, date)
VALUES (?,?,now());
SQL;
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid, $validator));

        return $validator;
    }
}