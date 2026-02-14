<?php

require_once __DIR__ . '/../app/Service/JournalService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $journal_service = new JournalService();
    $result = $journal_service->saveJournalEntry($title, $content);

    if ($result['success']) {
        header('Location: index.php?created=1');
        exit;
    } else {
        header('Location: index.php?error=' . urlencode($result['message']));
        exit;
    }
}
