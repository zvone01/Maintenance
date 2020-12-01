<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

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
 
$machineID = isset($_GET['machineID']) ? $_GET['machineID'] : 0;

if ($machineID > 0)
{
    $stmt = $checks->readByMachineID($machineID);
}else{
    $stmt = $checks->read();
}
// query products
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $checks_arr=array();
    $checks_arr["checks"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $check_item=array(
            "ID" => $ID,
            "machineID" => $machineID,           
            "Name" => $Name,          
            "Description" => $Description,
            "Unit_of_measure" => $Unit_of_measure
        );
 
        array_push($checks_arr["checks"], $check_item);
    }
 
    echo json_encode($checks_arr);
}
 
else{
    echo json_encode(
        array("message" => "No checks found.")
    );
}
}
?>