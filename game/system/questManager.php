<?php
/*  Utility functions for quests that are called by quest_api.
    Handles quest initialization and helper functions.
*/

include_once(__DIR__ . "/realm_config.php"); // Loads realm-specific settings
include_once(__DIR__ . "/db.php");           // Loads database connection ($sql)

class QuestManager {
    private $session;   // Reference to $_SESSION
    private $sql;       // Database connection
    private $realms;    // Realm configuration

    /*
        Constructor initializes session, database, and realms
    */
    public function __construct(&$session, $sql) {
        $this->session = &$session;
        $this->sql = $sql;
        $this->realms = $GLOBALS["REALMS"] ?? []; // from realm_config.php
        $this->initialize();
    }

    /*
        Initializes the quest session structure.
        Ensures all realms have quest containers.
    */
    private function initialize() {

        if (!isset($this->session["quests"])) {
            $this->session["quests"] = [];
        }

        foreach ($this->realms as $realmKey => $realmData) {

            if (!isset($this->session["quests"][$realmKey])) {
                $this->session["quests"][$realmKey] = [
                    "started"   => [],
                    "completed" => [],
                    "flags"     => [],
                    "visited"   => false
                ];
            }
        }
    }

    /* =========================
       Quest Actions
       ========================= */

    // Start a quest
    public function startQuest($questId) {
        $realm = $this->getCurrentRealm();

        if (!in_array($questId, $this->session["quests"][$realm]["started"])) {
            $this->session["quests"][$realm]["started"][] = $questId;
        }
    }

    // Complete a quest
    public function completeQuest($questId) {
        $realm = $this->getCurrentRealm();

        if (!in_array($questId, $this->session["quests"][$realm]["completed"])) {
            $this->session["quests"][$realm]["completed"][] = $questId;
        }
    }

    // Abandon a quest
    public function abandonQuest($questId) {
        $realm = $this->getCurrentRealm();

        $this->session["quests"][$realm]["started"] = array_diff(
            $this->session["quests"][$realm]["started"],
            [$questId]
        );
    }

    // Get all quests
    public function getQuests() {
        return $this->session["quests"];
    }

    /* =========================
       Helper Functions
       ========================= */

    // Get current realm (fallback safe)
    private function getCurrentRealm() {
        return $this->session["current_realm"] ?? array_key_first($this->realms);
    }
}
