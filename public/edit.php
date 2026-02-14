<?php
// edit.php
require_once __DIR__ . '/../app/Service/JournalService.php';

$journal_service = new JournalService();
$journal_id = $_GET['id'] ?? null;

if (!$journal_id) {
    header('Location: index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $result = $journal_service->udpateJournal($journal_id, $title, $content);

    if ($result['success']) {
        header("Location: view.php?id=$journal_id&updated=1");
        exit;
    } else {
        $error = $result['message'];
    }
}

// Get journal data
$result = $journal_service->getJournalById($journal_id);

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
    <title>Edit Journal - My Journal</title>

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
    <script defer src="../assets/js/app.js"></script>
</head>
<body>
    <div class="container w-50">
        <header class="text-center my-5">
            <h1 class="display-4 fw-bold">Edit Journal</h1>
            <p class="lead text-muted">Update your thoughts</p>
        </header>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group mb-3">
                <span class="input-group-text" id="title-icon">
                    <i class="bi bi-pencil"></i>
                </span>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Enter journal title"
                    aria-label="Journal Title"
                    aria-describedby="title-icon"
                    value="<?= htmlspecialchars($journal->title) ?>"
                    required
                />
            </div>

            <div class="form-floating mb-3">
                <textarea
                    class="form-control"
                    name="content"
                    id="journal-content"
                    placeholder="Let your feelings out"
                    required
                ><?= htmlspecialchars($journal->content) ?></textarea>
                <label for="journal-content">Content</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update Journal
                </button>
                <a href="view.php?id=<?= $journal_id ?>" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</body>
</html>