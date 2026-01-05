<?php
/*  Processes quest updates triggered by JavaScript fetch() calls.
    All realms use this to update their quest state without reloading the page via fetch().
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once(__DIR__ . "/realm_config.php");   // Realm-specific settings
include_once(__DIR__ . "/db.php");             // Database connection ($pdo)
include_once(__DIR__ . "/questManager.php");   // QuestManager class

// Instantiate QuestManager
$questManager = new QuestManager($_SESSION, $pdo);

// Get parameters from POST or GET
$action  = $_POST["action"] ?? $_GET["action"] ?? "";
$questId = $_POST["quest"]  ?? $_GET["quest"]  ?? "";

// Default response
$response = [
    "success" => false,
    "quests" => []
];

// Route actions
switch ($action) {

    case "start":
        if (!empty($questId)) {
            $questManager->startQuest($questId);
            $response["success"] = true;
        }
        break;

    case "complete":
        if (!empty($questId)) {
            $questManager->completeQuest($questId);
            $response["success"] = true;
        }
        break;

    case "abandon":
        if (!empty($questId)) {
            $questManager->abandonQuest($questId);
            $response["success"] = true;
        }
        break;

    case "get_quests":
        $response["success"] = true;
        break;

    default:
        $response["error"] = "Invalid action";
        break;
}

// Always return latest quest state
$response["quests"] = $questManager->getQuests();

// Return JSON
header("Content-Type: application/json");
echo json_encode($response);
?>