<?php
    /*  Handles all inventory-related logic for a player called by inventory_api.
        It manages session state, artifact collection, shield management, and assembler progression.
        Flags and lists are stored in session and mirrored to the database via player_state.
    */

include_once(__DIR__ . "/realm_config.php"); // Realm-specific settings
include_once(__DIR__ . "/db.php");           // Database connection ($sql)

class InventoryManager {
    private $session; // Reference to session array
    private $sql;     // Database connection

    // Constructor initializes session and database
    public function __construct(&$session, $sql) {
        $this->session = &$session;
        $this->sql = $sql;
        $this->initialize();
    }

    // Initialize inventory structure in session
    private function initialize() {
        if (!isset($this->session["inventory"])) {
            $this->session["inventory"] = [
                "items" => [],
                "assembled" => [],
                "shield" => false
            ];
        }
    }

    // Collect a basic item
    public function collectItem($item) {
        if (!in_array($item, $this->session["inventory"]["items"])) {
            $this->session["inventory"]["items"][] = $item;
        }
    }

    // Assemble an item (moves it from items → assembled)
    public function assembleItem($item) {
        if (in_array($item, $this->session["inventory"]["items"])) {
            $this->session["inventory"]["assembled"][] = $item;

            // Remove from collected items
            $this->session["inventory"]["items"] = array_diff(
                $this->session["inventory"]["items"],
                [$item]
            );
        }
    }

    // Add shield
    public function addShield() {
        $this->session["inventory"]["shield"] = true;
    }

    // Remove shield
    public function removeShield() {
        $this->session["inventory"]["shield"] = false;
    }

    // Get entire inventory
    public function getInventory() {
        return $this->session["inventory"];
    }
}

 
?>
