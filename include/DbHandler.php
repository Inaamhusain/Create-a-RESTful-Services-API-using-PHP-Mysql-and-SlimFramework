<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    public function getAllUserTasks() {
        $stmt = $this->conn->prepare("SELECT * FROM tasks");
        $stmt->execute();
        $tasks = $stmt->get_result();
        $stmt->close();
        $stmt1 = $this->conn->prepare("SELECT * FROM users");
        $stmt1->execute();
        $users = $stmt1->get_result();
        $stmt1->close();
        return array("task"=>$tasks,"user"=>$users);
    }
}

?>
