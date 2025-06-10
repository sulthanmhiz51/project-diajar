<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 p-5">
        <div class="container">
            <h2 class="mt-5">Edit Course</h2>
            <hr>
            <form id="editForm" action="<?= BASEURL ?>/courses/updateCourse/<?= $data['courseId'] ?>" method="POST"
                enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="mb-3 row">
                    <div class="col-md col-12 mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input class="form-control" type="file" id="thumbnail" name="thumbnail">
                    </div>
                    <div class="col-auto align-self-end mb-3">
                        <button type="button" id="cancelBtn" class="btn btn-outline-danger">Cancel</button>
                        <button type="submit" class="col btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var courseDescriptionContent = <?= json_encode($data['course']['description']) ?>;
        var courseId = <?= $data['courseId'] ?>;

        $('#description').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            placeholder: "Write course's description",
            tabsize: 2,
            height: 300,
            tabDisable: true
        });


        $('#cancelBtn').on('click', function() {
            Swal.fire({
                title: "Discard changes you made?",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?= BASEURL ?>/courses/detail?courseId=" + courseId;
                }
            });

        });

        $('#title').val('<?= $data['course']['title'] ?>');
        $('#description').summernote('code', courseDescriptionContent);

        // You'd also attach an AJAX submit handler to #editCourseForm here
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Get form data, including files

            $.ajax({
                url: $(this).attr('action'), // Your endpoint to handle form submission
                method: 'POST',
                data: formData,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                dataType: 'json', // Expect JSON response from server
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Success!', response.message, 'success').then(() => {
                            window.location.href =
                                "<?= BASEURL ?>/courses/detail?courseId=" + courseId;
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error').then(() => {
                            window.location.href =
                                "<?= BASEURL ?>/courses/detail?courseId=" + courseId;
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('AJAX Error!', 'Could not update course: ' + error, 'error');
                }
            });
        });
    });
</script>