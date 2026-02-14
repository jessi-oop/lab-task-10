<?php

require_once __DIR__ . '/../Repository/JournalRepository.php';

class JournalService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new JournalRepository();
    }

    public function saveJournalEntry($title, $content)
    {
        if (empty($title) || empty($content)) {
            return ['success' => false, 'message' => 'Journal entry must have a title and content.'];
        }

        $save_journal = $this->repo->createJournalEntry($title, $content);
        if ($save_journal) {
            return ['success' => true, 'message' => 'Journal entyr saved.'];
        }

        return ['success' => false, 'message' => 'Error in saving journal entry.'];
    }

    public function getAllJournal()
    {
        return $this->repo->getAllEntry(); // Just return the array directly
    }

    public function getJournalById($journal_id)
    {
        if (empty($journal_id)) {
            return ['success' => false, 'message' => 'Journal ID must be required.'];
        }

        $journal =  $this->repo->getJournalById($journal_id);
        if ($journal) {
            return ['success' => true, 'message' => 'Journal retrieved.', 'journal' => $journal];
        }

        return ['success' => false, 'message' => 'Error in retrieving journal.'];
    }

    public function udpateJournal($journal_id, $title, $content)
    {
        if (empty($journal_id)) {
            return ['success' => false, 'message' => 'Journal does not exist.'];
        }

        if (empty($title) || empty($content)) {
            return ['success' => false, 'message' => 'Title and contentn cannot be empty'];
        }

        $updated_journal = $this->repo->updateJournalEntry($journal_id, $title, $content);

        if ($updated_journal) {
            return ['success' => true, 'message' => 'Journal updated successfully.'];
        }

        return ['success' => false, 'message' => 'Error in updating journal.'];
    }

    public function deleteJournalEntry($journal_id)
    {
        if (empty($journal_id)) {
            return ['success' => false, 'message' => 'Journal does not exist.'];
        }

        $deleted_journal =  $this->repo->deleteJournal($journal_id);

        if ($deleted_journal) {
            return ['success' => true, 'message' => 'Journal deleted successfully.'];
        }

        return ['success' => false, 'message' => 'Error in deleting journal.'];
    }
}
