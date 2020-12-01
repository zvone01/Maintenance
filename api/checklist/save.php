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
include_once '../objects/checklist.php';
 
$database = new Database();
$db = $database->getConnection();
 
$checklist  = new Checklist($db);
 
// get posted data
$dataArray = json_decode(file_get_contents("php://input"));
$tokenData = Token::is_valid($headers['Authorization']);
print_r($tokenData['data']['id']);
$error = false;
foreach($dataArray as $data)
{
    $checklist->Template_ID = $data->Template_ID;
    $checklist->Machine_ID = $data->Machine_ID;
    $checklist->Item_ID = $data->Item_ID;
    $checklist->Date_Time = $data->Date_Time; //date("Y-m-d H:i:s");;
    $checklist->User_ID = $tokenData['data']['id'];
    $checklist->Checked = true;
    $checklist->Value = 0;
    $checklist->Note = "";
    $checklist->Failure_ID = 0;

    if(!$checklist->save()){
        echo '{';
            echo '"message": "Unable to save."';
        echo '}';
        return;
    }
     
}
echo '{';
    echo '"message": "Saved."';
echo '}';


}
