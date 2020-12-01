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
 
    include_once '../config/database.php';
    include_once '../objects/machine.php';

$database = new Database();
$db = $database->getConnection();
 
$machine  = new Machine($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set user property values
$machine->Name = $data->name;
$machine->Description = $data->description;
// create the user
if($machine->create()){
    echo '{';
        echo '"message": "Machine was created."';
    echo '}';
}
 
// if unable to create the user, tell the user
else{
    echo '{';
        echo '"message": "Unable to create machine."';
    echo '}';
}
}
?>