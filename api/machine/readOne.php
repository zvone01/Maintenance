<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
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
include_once '../objects/machine.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$machine = new Machine($db);

$machine->ID = isset($_GET['ID']) ? $_GET['ID'] : die();
 
 // read the details of machine to be edited
$machine->readOne();
 
// create array
$machine_arr = array(
    "ID" =>  $machine->ID,
    "Name" => $machine->Name,
    "Description" => $machine->Description 
);
// make it json format
print_r(json_encode($machine_arr));
}
?>
