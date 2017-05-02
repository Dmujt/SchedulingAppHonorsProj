<?php
/**
 * Created by PhpStorm.
 * User: riesbyfe
 * Date: 4/24/17
 * Time: 8:45 AM
 */

namespace Calendar;


class Events extends Table{

    public function __construct(Site $site){
        parent::__construct($site, "event");

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
        $row = new Event($statement->fetch(\PDO::FETCH_ASSOC));
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

    public function getFuture($userid){
        $date = date('Y-m-d H:i:s', time());
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE DATE(whendate) >= ? and userid= ? ;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($date, $userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPast($userid){
        $date = date('Y-m-d H:i:s', time());
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE DATE(whendate) <= ? and userid = ?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($date, $userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getToday($d, $userid){
        $date = date('Y-m-d H:i:s', $d);
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE DATE(whendate) = ? and userid=?;
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($date, $userid));

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(Event $t){
        $tname = $this->getTableName();
        $sql=<<<SQL
INSERT INTO $tname (strname, description,whendate,location, userid)
 VALUES (?,?,?,?,?);
SQL;
        $pdo = $this->pdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($t->getStrname(),
                $t->getDescription(),
                $t->getWhenDate(),
                $t->getLocation(),
                $t->getUserid()));
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

    public function update(Event $t, $id){
        $tname = $this->getTableName();
        $sql=<<<SQL
UPDATE $tname
SET strname=?, description=?, whendate = ?, location=? where id=?;
SQL;
        $pdo = $this->pdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $statement = $pdo->prepare($sql);

        try {
            $statement->execute(array($t->getStrname(),
                $t->getDescription(),
                $t->getWhenDate(),
                $t->getLocation(),
                $id));
        } catch(\PDOException $e) {
            return false;
        }
        return true;
    }

}