// backend/api/depreciation/update.php
<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Depreciation.php';

$database = new Database();
$db = $database->getConnection();

$depreciation = new Depreciation($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->id) &&
    !empty($data->name) &&
    !empty($data->cost) &&
    !empty($data->period) &&
    !empty($data->category) &&
    !empty($data->assetValue)
) {
    $depreciation->id = $data->id;
    $depreciation->name = $data->name;
    $depreciation->cost = $data->cost;
    $depreciation->period = $data->period;
    $depreciation->category = $data->category;
    $depreciation->assetValue = $data->assetValue;

    if($depreciation->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Depreciation updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update depreciation."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update depreciation. Data is incomplete."));
}
