<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
    
}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);
    echo json_encode(
        array("message" => "Unknown user",
              "error" => 1)
    );

}
else
{
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/checkitems.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$checks = new CheckItems($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$checks->ID = $data->ID;

if ($checks->ID > 0)
{
    $checks->readById();
}else{
    echo json_encode(
        array("message" => "No Item found.")
    );
}

// set template property values
$checks->Name = $data->Name;
$checks->Description = $data->Description;
$checks->Unit_of_measure = $data->Unit_of_measure;

if($checks->update()){
    echo '{';
        echo '"message": "Item was updated."';
    echo '}';
}
 
// if unable to update , tell 
else{
    echo '{';
        echo '"message": "Unable to update Item."';
    echo '}';
}
}