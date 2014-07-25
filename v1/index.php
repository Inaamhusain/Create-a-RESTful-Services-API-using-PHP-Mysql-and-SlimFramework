<?php

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '../libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;

$app->get('/tasks', function() {
            global $user_id;
            $response = array();
            $db = new DbHandler();

            // fetching all user tasks
            $result = $db->getAllUserTasks();
            $response["tasks"] = array();
            $response["users"] = array();

            // looping through result and preparing tasks array
            while ($task = $result['task']->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["task"] = $task["task"];
                $tmp["status"] = $task["status"];
                $tmp["createdAt"] = $task["created_at"];
                array_push($response["tasks"], $tmp);
            }
            while ($user = $result['user']->fetch_assoc()) {
                $tmp1 = array();
                $tmp1["id"] = $user["id"];
                $tmp1["name"] = ['Name'=>$user["name"],'ID'=>$user["id"],'Email'=>$user["email"]];
                $tmp1["email"] = $user["email"];
                $tmp1["password_hash"] = $user["password_hash"];
                $tmp1["api_key"] = $user["api_key"];
                $tmp1["status"] = $user["status"];
                $tmp1["created_at"] = $user["created_at"];
                array_push($response["users"], $tmp1);
            }

            echoRespnse(200, $response);
        });

function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>