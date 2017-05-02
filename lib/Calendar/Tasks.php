<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:45 AM
 */

namespace Calendar;


class Tasks extends Table{

    public function __construct(Site $site){
        parent::__construct($site, "task");

        $this->site = $site;
    }

    public function get($id){
        $sql = <<<SQL
SELECT * FROM $this->tableName WHERE id = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }
        $row = new Task($statement->fetch(\PDO::FETCH_ASSOC));
        return $row;
    }

    public function getAll($userid)
    {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE userid = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUnComplete($userid){
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE completed = 0 and userid=?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getComplete($userid){
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE completed = 1 and userid=?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function create(Task $t){
        $tname = $this->getTableName();
        $sql=<<<SQL
INSERT INTO $tname (strname, description, userid)
 VALUES (?,?,?);
SQL;
        $pdo = $this->pdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($t->getStrname(), $t->getDescription(), $t->getUserid()));
        } catch(\PDOException $e) {
            return false;
        }
        return true;
    }

    public function delete($id){
        /**/
        $sql=<<<SQL
DELETE FROM $this->tableName WHERE id = ?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($id)) === false) {
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return true;
    }

    public function update(Task $t, $id){
        $tname = $this->getTableName();
        $sql=<<<SQL
UPDATE $tname
SET strname=?, description=? where id=?;
SQL;
        $pdo = $this->pdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($t->getStrname(), $t->getDescription(),$id));
        } catch(\PDOException $e) {
            return false;
        }
        return true;
    }

    public function markComplete($id){
        $sql = <<<SQL
UPDATE $this->tableName
SET completed = 1 where id=?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

    public function markUnComplete($id)
    {
        $sql = <<<SQL
UPDATE $this->tableName
SET completed = 0 where id=?;
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
    }

}