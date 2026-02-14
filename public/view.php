<?php
require_once __DIR__ . '/../app/Service/JournalService.php';

// Get journal ID from URL
$journal_id = $_GET['id'] ?? null;

if (!$journal_id) {
    header('Location: index.php');
    exit;
}

$journal_service = new JournalService();
$result = $journal_service->getJournalById($journal_id);

// Check if journal exists
if (!$result['success'] || !isset($result['journal'])) {
    header('Location: index.php');
    exit;
}

$journal = $result['journal'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($journal->title) ?> - My Journal</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="../assets/css/journal.css" />

    <script
      defer
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script defrer src="../assets/js/app.js"></script>
</head>
<body>
    <div class="container">
        <!-- Header with Back Button -->
        <div class="d-flex align-items-center justify-content-between my-4">
            <a href="index.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Journal
            </a>
            <div class="d-flex gap-2">
                <a href="edit.php?id=<?= $journal->journal_id ?>" id="edit-btn" class="btn btn-outline-primary btn-sm" title="Edit">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button 
                    id="delete-btn" 
                    class="btn btn-outline-danger btn-sm" 
                    title="Delete"
                    onclick="showDeleteModal(<?= $journal->journal_id ?>, '<?= htmlspecialchars($journal->title, ENT_QUOTES) ?>')"
                >
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>

        <!-- Journal Entry Card -->
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <!-- Title -->
                <h1 class="card-title display-5 fw-bold mb-3">
                    <?= htmlspecialchars($journal->title) ?>
                </h1>

                <!-- Metadata -->
                <div class="text-muted mb-4 d-flex align-items-center gap-3">
                    <span>
                        <i class="bi bi-calendar3"></i>
                        <?= date('F j, Y', strtotime($journal->created_at)) ?>
                    </span>
                    <span>
                        <i class="bi bi-clock"></i>
                        <?= date('g:i A', strtotime($journal->created_at)) ?>
                    </span>
                </div>

                <hr class="my-4">

                <!-- Content -->
                <div class="journal-content">
                    <?= nl2br(htmlspecialchars(trim($journal->content))) ?>
                </div>

                <!-- Footer Info -->
                <?php if (isset($journal->updated_at) && $journal->updated_at !== $journal->created_at): ?>
                    <div class="text-muted mt-4 pt-3 border-top">
                        <small>
                            <i class="bi bi-pencil-square"></i>
                            Last updated: <?= date('F j, Y \a\t g:i A', strtotime($journal->updated_at)) ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/partials/modal.php'; ?>
</body>
</html>