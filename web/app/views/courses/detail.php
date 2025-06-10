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
                <?php if ($_SESSION['user_role'] === 'instructor'): ?>
                <button id="editBtn" class="btn  btn-primary float-end ms-2">Edit</button>
                <button id="deleteBtn" class="btn  btn-outline-danger float-end">Delete</button>
                <?php endif; ?>
                <h1><?= $title ?></h1>
                <p class="m-0">Author: <?= $author ?> </p>
                <p class="m-0">Created at: <?= $createDate ?> </p>
                <p>Students Enrolled: <?= $data['enrolled_students_count'] ?? 0 ?> </p>
            </div>

            <hr>

            <h2>Descriptions</h2>

            <?= $desc ?>
            <div>
                <?php if ($_SESSION['user_role'] === 'instructor'): ?>
                <a href="<?= BASEURL ?>/courses/create" class="btn  btn-primary float-end">Add Module</a>
                <?php endif; ?>
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

            <div>
                <?php if ($_SESSION['user_role'] === 'instructor'): ?>

                <h3 class="my-4">Enrolled Students</h3>

                <div class="p-3 bg-white rounded shadow-sm mb-3" style="min-height: 200px;">
                    <table class="table table-striped m-0">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Date Enrolled</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['enrolled_students'])): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($data['enrolled_students'] as $student): ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><?= htmlspecialchars($student['first_name']); ?></td>
                                <td><?= htmlspecialchars($student['last_name']); ?></td>
                                <td><?= date('Y-m-d H:i', strtotime($student['enrolled_at'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No students enrolled in this course yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-5 text-center">
                    <a href="<?= BASEURL ?>/courses" class="btn btn-outline-primary">Kembali ke Daftar Kursus</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
    document.title = "<?= $title ?>"

    var detailContent = $('#detailContent');
    var courseId = <?= $_GET['courseId'] ?>;

    $('#deleteBtn').on('click', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("SweetAlert result:", result);
                $.ajax({
                    url: window.APP_CONFIG.BASEURL + "/courses/deleteCourse/" + courseId,
                    type: "POST",
                    dataType: "json",
                    success: function(response) {
                        console.log("AJAX Success:", response);
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message ||
                                    "Course has been deleted.",
                                icon: "success"
                            }).then(() => {
                                // Sign out and redirect to homepage
                                window.location.href = window.APP_CONFIG
                                    .BASEURL + "/courses";
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message ||
                                    "Failed to delete your account.",
                                icon: "error"
                            });
                        }
                    },

                });
            }
        });
    })

    $('#editBtn').on('click', function() {
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