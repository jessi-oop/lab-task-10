<?php

require_once  __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Entity/Journal.php';

class JournalRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createJournalEntry($title, $content)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO journal (title, content) VALUES (?, ?)");
            $data = $stmt->execute([$title, $content]);
            return $data;
        } catch (PDOException $e) {
            error_log("Error in saving journal entry: " . $e->getMessage());
            return false;
        }
    }

    public function getAllEntry()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM journal ORDER BY created_at DESC");

            if (!$stmt) {
                $error = $this->db->errorInfo();
                error_log("Query failed: " . $error[2]);
                return [];
            }

            $journals = [];
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($data) { // only add if $data is not false
                    $journals[] = new Journal($data);
                }
            }

            return $journals;

        } catch (PDOException $e) {
            error_log("Error getting journal entries: " . $e->getMessage());
            return [];
        }
    }

    public function getJournalById($journal_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM journal WHERE journal_id = ?");
            $stmt->execute([$journal_id]);
            $data = $stmt->fetch();

            if ($data) {
                return new Journal($data);
            }
        } catch (PDOException $e) {
            error_log("Error getting journal entry: " . $e->getMessage());
            return null;
        }
    }

    public function updateJournalEntry($journal_id, $title, $content)
    {
        try {
            $stmt = $this->db->prepare("UPDATE journal SET title = ?, content = ? WHERE journal_id = ?");
            return $stmt->execute([$title, $content, $journal_id]);
        } catch (PDOException $e) {
            error_log("Error updating journal entry: " . $e->getMessage());
            return false;
        }
    }

    public function deleteJournal($journal_id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM journal WHERE journal_id = ?");
            return $stmt->execute([$journal_id]);
        } catch (PDOException $e) {
            error_log("Error deleting journal entry: " . $e->getMessage());
            return false;
        }

    }
}
