<?php

require_once __DIR__ . '/../app/Service/JournalService.php';

$journal_service = new JournalService();
$journal_id = $_POST['id'] ?? $_GET['id'] ?? null;

if (!$journal_id) {
    header('Location: index.php');
    exit;
}

$result = $journal_service->deleteJournalEntry($journal_id);

if ($result['success']) {
    header('Location: index.php?deleted=1');
    exit;
} else {
    header("Location: view.php?id=$journal_id&error=delete_failed");
    exit;
}
