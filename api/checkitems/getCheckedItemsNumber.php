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
 
include_once '../config/database.php';
include_once '../objects/checkitems.php';
 

$database = new Database();
$db = $database->getConnection();
 
$checkItems = new CheckItems($db);
 
$List_ID = isset($_GET['List_ID']) ? $_GET['List_ID'] : 0;

$checkItems->List_ID = $List_ID;
 

$stmt = $checkItems->readByListID();


$num = $stmt->rowCount();
 

if($num>0){
 
   
    $checks_arr=array();
    $checks_arr["checks"]=array();
    $checks_arr["checksDone"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        if($Cheklist_ID == null)
        {

 
        $check_item=array(
            "ID" => $Item_ID,
            "listID" => $ID,   
            "Name" => $Name,        
            "CheckListID" => $Cheklist_ID,          
            "Date" => $Date_Time,
            "Unit_of_measure" => "nije bitno"
        );
        array_push($checks_arr["checks"], $check_item);
    }
    else
    {

        $checkdone_item=array(
            "ID" => $Item_ID,
            "listID" => $ID,   
            "Name" => $Name,        
            "CheckListID" => $Cheklist_ID,          
            "Date" => $Date_Time,
            "Unit_of_measure" => "nije bitno"
        );
        array_push($checks_arr["checksDone"], $checkdone_item);
    }
 
      
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