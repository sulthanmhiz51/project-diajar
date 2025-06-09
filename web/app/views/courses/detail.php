<?php
$course = $data['course'];
$thumbnail = $course['thumbnail_url'] ?? 'default-thumbnail.webp';
$title = $course['title'];
$createDate = $course['created_at'];
$author = $course['first_name'] || $course['last_name'] ? $course['first_name'] . ' ' . $course['last_name'] : $course['instr_uname'];
$desc = $course['description'];
?>
<div id="detailContent" class="h-100">
    <div class="profile d-flex justify-content-center align-content-center h-100">
        <div class="bg-body w-75 p-5">
            <!-- Konten Kursus -->
            <div class="course-header">
                <img src="<?= BASEURL ?>/img/thumbnail/<?= $thumbnail ?>" alt="Thumbnail" class="w-100 mb-4"
                    style="height: 250px; object-fit: cover;">
                <button id="editBtn" class="btn  btn-primary float-end">Edit</button>
                <h1><?= $title ?></h1>
                <p class="m-0">Author: <?= $author ?> </p>
                <p>Created at: <?= $createDate ?> </p>
            </div>

            <hr>

            <h2>Descriptions</h2>

            <?= $desc ?>
            <div>
                <a href="<?= BASEURL ?>/courses/create" class="btn  btn-primary float-end">Add Module</a>
                <h3 class="my-4">Modules</h3>
            </div>

            <!-- Kuliah 1 -->
            <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
                <div class="announcement-item">
                    <strong>KULIAH-1:</strong> PENDAHULUAN: 20-08-2024 →<br>
                    <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
                </div>
            </div>

            <!-- Kuliah 2 -->
            <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
                <div class="announcement-item">
                    <strong>KULIAH-2:</strong> HARDWARE BASIC: 27-08-2024 →<br>
                    <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
                </div>
            </div>

            <!-- Kuliah 3 -->
            <div class="kuliah-card p-3 bg-white rounded shadow-sm mb-3">
                <div class="announcement-item">
                    <strong>KULIAH-3:</strong> SISTEM BILANGAN: 03-09-2024 →<br>
                    <span class="file-indicator" style="display: inline-block; width: 20px;">↑</span>
                </div>
            </div>

            <div class="mt-5 text-center">
                <a href="<?= BASEURL ?>/courses" class="btn btn-outline-primary">Kembali ke Daftar Kursus</a>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "<?= $title ?>"

    var detailContent = $('#detailContent');
    $('#editBtn').on('click', function() {
        var courseId = <?= $_GET['courseId'] ?>; // Get the course ID from data attribute

        // Show a loading indicator in the container
        detailContent.html(
            '<div class="text-center py-5"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Loading edit form...</span></div><p>Loading edit form...</p></div>'
        );

        $.ajax({
            url: '<?= BASEURL ?>/courses/editCourse/' + courseId, // Your URL to the partial form
            method: 'GET',
            dataType: 'html', // Expect HTML content back
            success: function(responseHtml) {
                detailContent.html(responseHtml); // Replace the content
                // If the loaded form has its own JavaScript, ensure it re-initializes or is set up correctly
            },
            error: function(xhr, status, error) {
                detailContent.html('<div class="alert alert-danger">Failed to load edit form: ' +
                    status + '</div>');
                console.error('AJAX Error:', status, error, xhr.responseText);
            }
        });
    });
</script>