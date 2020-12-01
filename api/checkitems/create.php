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
 
$database = new Database();
$db = $database->getConnection();
 
$CheckItems  = new CheckItems($db);
$checklisttemplateitems  = new ChecklistTemplateItems($db);
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set user property values
$CheckItems->Name = $data->Name;
$CheckItems->Description = $data->Description;
$CheckItems->Unit_of_measure = $data->Unit_of_measure;
$checklisttemplateitems->List_ID = $data->listID;


// create the user
if($CheckItems->create()){

    $stmt = $CheckItems->readLast();

    
   
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        $checklisttemplateitems->Item_ID = $ID;

        

    }

    if( $checklisttemplateitems->create()){
        echo '{';
            echo '"message": "Check was created."';
        echo '}';

   
}
else{
    echo '{';
        echo '"message": "Unable to create machine."';
    echo '}';
}

  
}
 
// if unable to create the user, tell the user
else{
    echo '{';
        echo '"message": "Unable to create machine."';
    echo '}';
}
}
?>