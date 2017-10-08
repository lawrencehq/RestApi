<?php
/**
 * Created by PhpStorm.
 * User: Enthalqy Huang
 * Date: 2017/9/2
 * Time: 20:07
 */

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require 'vendor/autoload.php';
require 'db.php';
require 'common.php';

$app = new \Slim\App;

$app->get('/test', function($request, $response, $args) {
   return $response->write(date('Y-m-d'));
});

# add user
$app->get('/addUser/{username}/{gender}/{height}/{weight}', function($request, $response, $args) {
    $username = $args['username'];
    $gender = $args['gender'];
    $height = $args['height'];
    $weight = $args['weight'];
    $db = new DBAccess();
    $userid = $db->addUser($username, $gender, $height, $weight);
    if ($userid) {
        return $response->write(formatOutput(true, $userid, "Successfully add user."));
    } else {
        return $response->write(formatOutput(false, $userid, "Fail to add user."));
    }
});

# get user according to username
$app->get('/getUser/{username}', function($request, $response, $args) {
    $username = $args['username'];
    $db = new DBAccess();
    $user = $db->getUserViaName($username);
    if (empty($user)) {
        return $response->write(formatOutput(false, $user, "User not found"));
    }
    return $response->write(formatOutput(true, $user[0], "Request success"));
});

# get categories
$app->get('/category', function($request, $response, $args) {
    $db = new DBAccess();
    $categories = $db->getCategory();
    if (empty($categories)) {
        return $response->write(formatOutput(false, $categories, "No category found"));
    }
    return $response->write(formatOutput(true, $categories, "Request success"));
});

# get food according to category
//$app->get('/food/{category_id}', function($request, $response, $args) {
//    $category_id = $args['category_id'];
//    $db = new DBAccess();
//    $food = $db->getFoodViaCategory($category_id);
//    if (empty($food)) {
//        return $response->write(formatOutput(false, $food, "Food not found"));
//    }
//    return $response->write(formatOutput(true, $food, "Request success"));
//});

# fet all foods
$app->get('/food', function($request, $response, $args) {
    $db = new DBAccess();
    $food = $db->getAllFood();
    if (empty($food)) {
        return $response->write(formatOutput(false, $food, "Food not found"));
    }
    return $response->write(formatOutput(true, $food, "Request success"));
});

# add record
$app->get('/addRecord/{userid}/{foodid}/{quantity}', function($request, $response, $args) {
    $userid = $args['userid'];
    $foodid = $args['foodid'];
    $quantity = $args['quantity'];
    $db = new DBAccess();
    $record_id = $db->addRecord($userid, $foodid, $quantity);
    if ($record_id) {
        return $response->write(formatOutput(true, $record_id, "Request success"));
    } else {
        return $response->write(formatOutput(false, $record_id, "Fail to add record"));
    }
});

# get records according to userid and date
$app->get('/getRecords/{date}/{userid}', function($request, $response, $args) {
    $date = $args['date'];
    $userid = $args['userid'];
    $db = new DBAccess();
    $record = $db->getRecordViaDate($date, $userid);
    if (empty($record)) {
        return $response->write(formatOutput(false, $record, "No records found"));
    }
    return $response->write(formatOutput(true, $record, "Request success"));
});

# get the list of food names
$app->get('/getFoodName', function($request, $response, $args) {
    $db = new DBAccess();
    $record = $db->getFoodNames();
    if (empty($record)) {
        return $response->write(formatOutput(false, $record, "No food found"));
    }
    return $response->write(formatOutput(true, $record, "Request success"));
});




$app->run();