<div class="profile d-flex justify-content-center align-content-center h-100">
  <div class="bg-body w-75 p-5">
    
    <!-- Header Submission -->
    <div class="module-header">
      <h1>Submission</h1>
      <p class="m-0">📂 Dibuka: <?= $data['open_date_formatted'] ?></p>
      <p class="m-0">📅 Tenggat: <?= $data['due_date_formatted'] ?></p>
    </div>

    <hr>

    <!-- Action -->
    <div class="d-flex gap-2 mb-4">
      <a href="#" class="btn btn-outline-secondary">Edit submission</a>
      <a href="#" class="btn btn-outline-danger">Remove submission</a>
    </div>

    <!-- Status Tabel -->
    <h4 class="fw-semibold mb-3">Status Pengumpulan</h4>
    <div class="table-responsive">
      <table class="table align-middle border-top">
        <tr class="<?= $data['submission'] ? 'bg-success-subtle' : '' ?>">
          <th class="w-25">Submission status</th>
          <td>
            <?= $data['submission']
              ? "✔ <strong>Submitted for grading</strong>"
              : "✖ <strong class='text-danger'>Not submitted</strong>" ?>
          </td>
        </tr>
        <tr>
          <th>Grading status</th>
          <td>
            <?php if ($data['submission']): ?>
              <?= $data['submission']['status'] === 'dinilai'
                ? "✔ <strong>Graded</strong> (Score: {$data['submission']['nilai']})"
                : "Not graded" ?>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
        </tr>
        <tr class="<?= $data['submitted_early'] ? 'bg-success-subtle' : 'bg-danger-subtle' ?>">
          <th>Time remaining</th>
          <td>
            <?php if ($data['submission']): ?>
              <?= $data['submitted_early']
                ? "✔ Assignment was submitted {$data['time_early_text']}"
                : "✖ Assignment was submitted {$data['time_late_text']}" ?>
            <?php else: ?>
              -
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <th>Last modified</th>
          <td><?= $data['last_modified'] ?? '-' ?></td>
        </tr>
        <tr>
          <th>File submissions</th>
          <td>
            <form action="<?= BASEURL ?>/submission/upload/<?= $data['modul']['id'] ?>" method="post" enctype="multipart/form-data">
              <div class="mb-2">
                <label for="tugasFile" class="form-label">Upload File Tugas (boleh lebih dari 1):</label>
                <input type="file" name="tugas[]" id="tugasFile" class="form-control" multiple required>
              </div>
              <button type="submit" class="btn btn-success btn-sm">Submit</button>
            </form>
          </td>
        </tr>
        <tr>
          <th>Submission comments</th>
          <td>
            <details>
              <summary>Komentar (<?= count($data['comments']) ?>)</summary>
              <div class="mt-2">
                <?php if (!empty($data['comments'])): ?>
                  <?php foreach ($data['comments'] as $c): ?>
                    <div class="border rounded p-2 mb-2">
                      <div class="d-flex justify-content-between">
                        <strong><?= htmlspecialchars($c['author_name']) ?></strong>
                        <small class="text-muted"><?= date('M j, Y g:i a', strtotime($c['created_at'])) ?></small>
                      </div>
                      <div><?= htmlspecialchars($c['content']) ?></div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <p class="text-muted">Belum ada komentar</p>
                <?php endif; ?>

                <!-- Form komentar -->
                <?php if ($data['submission']): ?>
                  <form action="<?= BASEURL ?>/submission/addComment/<?= $data['modul']['id'] ?>" method="post" class="mt-3">
                    <textarea class="form-control mb-2" name="comment" rows="3" required placeholder="Tulis komentar..."></textarea>
                    <button type="submit" class="btn btn-sm btn-primary">Kirim Komentar</button>
                  </form>
                <?php endif; ?>
              </div>
            </details>
          </td>
        </tr>
      </table>
    </div>

    <div class="text-center mt-4">
      <a href="<?= BASEURL ?>/courses" class="btn btn-outline-primary">← Kembali ke Kursus</a>
    </div>
  </div>
</div>

<script>
  document.title = "Submission Modul";
</script>
