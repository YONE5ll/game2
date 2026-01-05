
<?php
/*  Processes inventory updates triggered by JavaScript fetch() calls.
    It routes actions like collect, assemble, add/remove shield, and returns inventory state.
    It uses InventoryManager class to encapsulate logic and maintain session consistency.
    All realms use this to update thier inventory state without reloading the page.
*/
    
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/realm_config.php");
include_once(__DIR__ . "/db.php");
include_once(__DIR__ . "/inventoryManager.php");

// Create inventory manager instance (ORDER MATTERS)
$inventory = new InventoryManager($_SESSION, $sql);

// Get action and item
$action = isset($_GET["action"]) ? $_GET["action"] : "";
$item   = isset($_GET["item"]) ? $_GET["item"] : "";

$response = [
    "success" => false,
    "inventory" => []
];

// Route actions
switch ($action) {

    case "collect":
        $inventory->collectItem($item);
        $response["success"] = true;
        break;

    case "assemble":
        $inventory->assembleItem($item);
        $response["success"] = true;
        break;

    case "add_shield":
        $inventory->addShield();
        $response["success"] = true;
        break;

    case "remove_shield":
        $inventory->removeShield();
        $response["success"] = true;
        break;

    case "get_inventory":
        $response["success"] = true;
        break;

    default:
        $response["error"] = "Invalid action";
}

$response["inventory"] = $inventory->getInventory();

header("Content-Type: application/json");
echo json_encode($response);

    
?>

