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
include_once '../objects/checklist_template.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$template = new ChecklistTemplate($db);

if( isset($_GET['Machine_ID']) ) {    
    // query only for this machine templates
    $stmt = $template->readByMachineIDwithDates($_GET['Machine_ID']);
}
else{ 
    // query all templates
    $stmt = $template->read();
}
 
// check if more than 0 record found
if($stmt->rowCount()>0){
 
    // users array
    $template_arr=array();
    $template_arr["templates"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        
        $template_item=array(
            "Id" => $ID,
            "Name" => $Name,
            "Machine_ID" => $Machine_ID,
            "Frequency" => $Frequency,
            "StartDate" => $StartDate,
            "EndDate" => $EndDate,
            );
 
        array_push($template_arr["templates"], $template_item);
    }
 
    echo json_encode($template_arr);
}
 
else{
    echo json_encode(
        array("message" => "No templates found.")
    );
}
}
?>