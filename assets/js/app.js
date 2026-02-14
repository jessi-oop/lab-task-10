document.addEventListener("DOMContentLoaded", function () {
  const createBtn = document.getElementById("save-journal-btn");

  if (createBtn) {
    createBtn.addEventListener("click", function () {
      fetch("/journals/create.php")
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("modal-title").innerText = "Create Journal";
          document.getElementById("modal-content").innerHTML = data;

          let modal = new bootstrap.Modal(document.getElementById("appModal"));
          modal.show();
        })
        .catch((error) => {
          console.error("Error loading modal:", error);
        });
    });
  }

  // Check for success messages in URL
  const urlParams = new URLSearchParams(window.location.search);

  if (urlParams.has("created")) {
    showSuccessModal(
      "Journal Created!",
      "Your journal entry has been saved successfully.",
    );
  }

  if (urlParams.has("updated")) {
    showSuccessModal(
      "Journal Updated!",
      "Your journal entry has been updated successfully.",
    );
  }

  if (urlParams.has("deleted")) {
    showSuccessModal(
      "Journal Deleted!",
      "Your journal entry has been deleted successfully.",
    );
  }
});

// Delete modal function
function showDeleteModal(journalId, journalTitle) {
  document.getElementById("modal-title").textContent = "Delete Journal Entry";

  document.getElementById("modal-content").innerHTML = `
        <p>Are you sure you want to delete "<strong>${journalTitle}</strong>"?</p>
        <p class="text-danger">This action cannot be undone.</p>
        <div class="d-flex gap-2 justify-content-end mt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <form action="delete.php" method="POST" style="display: inline;">
                <input type="hidden" name="id" value="${journalId}">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    `;

  const modal = new bootstrap.Modal(document.getElementById("appModal"));
  modal.show();
}

// Success modal function
function showSuccessModal(title, message) {
  document.getElementById("modal-title").textContent = title;

  document.getElementById("modal-content").innerHTML = `
        <div class="text-center">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
            <p class="mt-3 mb-0">${message}</p>
        </div>
    `;

  const modal = new bootstrap.Modal(document.getElementById("appModal"));
  modal.show();
}
