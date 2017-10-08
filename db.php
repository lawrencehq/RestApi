<?php
/**
 * Created by PhpStorm.
 * User: Enthalqy Huang
 * Date: 2017/9/2
 * Time: 20:07
 */

// define database information
define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PWD', "123456");
define('DB_NAME', "food_health");
//date_default_timezone_set('UTC+10');


// get database connection
global $conn;
function connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    if (mysqli_connect_errno()) {
        echo "Failure when connect to mysql, " . mysqli_connect_error();
    }

    return $conn;
}

// calss for data processing
class DBAccess {
    public $conn;
    function __construct() {
        $this->conn = connect();
    }

    public function addUser($username, $gender, $height, $weight) {
        $sql = "insert into user(username, gender, height, weight) VALUES('$username', '$gender', '$height', '$weight')";
        $rs = $this->conn->query($sql);
        $userid = $this->conn->insert_id;
        if (!empty($userid)) {
            return $userid;
        } else {
            return;
        }
    }

    public function getUserViaName($username) {
        $sql = "select * from user where username='$username'";
        $rs = $this->conn->query($sql);
        $user = $rs->fetch_all(MYSQLI_ASSOC);
        return $user;
    }

    public function getCategory() {
        $sql = "select * from category";
        $rs = $this->conn->query($sql);
        $categories = $rs->fetch_all(MYSQLI_ASSOC);
        return $categories;
    }

    public function getFoodViaCategory($category_id) {
        $sql = "select * from food where cid='$category_id'";
        $rs = $this->conn->query($sql);
        $food = $rs->fetch_all(MYSQLI_ASSOC);
        return $food;
    }

    public function getAllFood() {
        $sql = "select * from food";
        $rs = $this->conn->query($sql);
        $food = $rs->fetch_all(MYSQLI_ASSOC);
        return $food;
    }

    public function addRecord($userid, $foodid, $quantity) {
        $date = date('Y-m-d');
        $sql = "insert into record(uid, fid, quantity, time) VALUES('$userid', '$foodid', '$quantity', '$date')";
        $rs = $this->conn->query($sql);
        $recordid = $this->conn->insert_id;
        if (!empty($recordid)) {
            return $recordid;
        } else {
            return;
        }
    }

    public function getRecordViaDate($date, $userid) {
        $sql = "select * from record join user ON record.uid=user.id join food ON record.fid=food.id
                where uid='$userid' and time='$date'";
        $rs = $this->conn->query($sql);
        $records = $rs->fetch_all(MYSQLI_ASSOC);
        return $records;
    }

    public function getFoodNames() {
        $sql = "select name from food";
        $rs = $this->conn->query($sql);
        $records = $rs->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}