<?php
require_once __DIR__ . '/../app/Service/JournalService.php';
require_once __DIR__ . '/../app/Entity/Journal.php';

$journal_service = new JournalService();
$journals = $journal_service->getAllJournal();

function excerpt($text, $max = 100)
{
    if (strlen($text) <= $max) {
        return $text;
    }
    return substr($text, 0, $max) . '...';
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My journal</title>

    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    
    <link rel="stylesheet" href="../assets/css/journal.css">

    <script
      defer
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <script defer src="../assets/js/app.js"></script>
  </head>
  <body>
    <div class="container w-50">
      <header class="text-center my-5">
        <h1 class="display-4 fw-bold">My Journal</h1>
        <p class="lead text-muted">Your personal space and escape</p>
      </header>

      <form action="create.php" method="POST">
        <div class="input-group mb-3">
        <span class="input-group-text" id="title-icon"
          ><i class="bi bi-pencil"></i
        ></span>
        <input
          type="text"
          name = "title"
          class="form-control"
          placeholder="Enter jorunal title"
          aria-label="Journal Title"
          aria-describedby="title-icon"
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
        ></textarea>
        <label for="journal-content">Content</label>
      </div>

      <button type="submit" class="btn btn-primary" id="save-journal-btn">
        Save journal
      </button>
      </form>
      
  

      <div class="container mt-3">
        <div class="row">
          <?php if (!empty($journals)): ?>
            <?php foreach ($journals as $journal): ?>
              
                <div class="card h-100 mb-3" id="cards">
                  <div class="card-body w-100 ">
                    <h5 class="card-title"><?= htmlspecialchars($journal->title) ?></h5>
                    <p class="card-text"><?= htmlspecialchars(excerpt($journal->content, 100)) ?></p>
                    <a href="view.php?id=<?= $journal->journal_id ?>" class="btn btn-sm btn-outline-primary">Read More</a>
                  </div>
                </div>
             
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center text-muted my-5">
              <p>No journal entries yet. Start by <a href="create.php">creating one</a>!</p>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
     <?php require_once __DIR__ . '/partials/modal.php';?>
  </body>
</html>
