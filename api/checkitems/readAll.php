<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/checkitems.php';

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
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$checkItems = new CheckItems($db);
 
$List_ID = isset($_GET['List_ID']) ? $_GET['List_ID'] : 0;

if ($List_ID > 0)
{
    $stmt = $checkItems->readByListID($List_ID);
}else{
    $stmt = $checkItems->read();
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
            "listID" => $List_ID,           
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