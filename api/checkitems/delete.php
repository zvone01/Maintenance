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

// get database connection
include_once '../config/database.php';

// instantiate user object
include_once '../objects/checkitems.php';
include_once '../objects/checklist_template_items.php';


$headers = apache_request_headers();
/*
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
{*/

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare item object
$item = new CheckItems($db);
$checklisttemplateitems  = new ChecklistTemplateItems($db);

// get category id
$data = json_decode(file_get_contents("php://input"));

// set category id to be deleted
$item->ID = $data;
$checklisttemplateitems->Item_ID = $data;
/*
TODO:
$checkList = new checkList($db);
$checkList->Item_ID
if($checkList->exsist())
$item->deactivate();
$checklisttemplateitems->deactivate();
*/
// delete the category
//print_r($checklisttemplateitems->deleteItem());
//$item->delete();

if ($checklisttemplateitems->deleteItem() && $item->delete()) {

        echo '{';
        echo '"message": "Item was deleted."';
        echo '}';
}

// if unable to delete the category
else {
    echo '{';
    echo '"message": "Unable to delete."';
    echo '}';
}
}
//}
