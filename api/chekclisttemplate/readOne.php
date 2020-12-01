<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/token.php';

$headers = apache_request_headers();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { } elseif (!Token::is_valid($headers['Authorization'])) {

    http_response_code(401);
    echo json_encode(
        array(
            "message" => "Unknown user",
            "error" => 1
        )
    );
} else {
    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/checklist_template.php';

    // instantiate database and user object
    $database = new Database();
    $db = $database->getConnection();

    // initialize object
    $template = new ChecklistTemplate($db);

    if (isset($_GET['ID'])) {
        // query only for this machine templates
        $template->ID = $_GET['ID'];
        if ($template->readByID()) {
            echo json_encode($template);
        } else goto a_gusta;
    } else {
        a_gusta: echo json_encode(
            array("message" => "No templates found.")
        );
        return;
    }
}
