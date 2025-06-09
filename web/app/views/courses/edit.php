<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 p-5">
        <div class="container">
            <h2 class="mt-5">Edit Course</h2>
            <hr>
            <form id="editForm" action="<?= BASEURL ?>/courses/updateCourse" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="courseId" id="courseId" value="<?= $data['courseId'] ?>">
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
            window.location.href = "<?= BASEURL ?>/courses/detail/" + courseId;
        });

        $('#title').val('<?= $data['course']['title'] ?>');
        $('#description').summernote('code', courseDescriptionContent);

        // You'd also attach an AJAX submit handler to #editCourseForm here
        $('#editCourseForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Get form data, including files

            $.ajax({
                url: '<?= BASEURL ?>/courses/updateCourse/' +
                    courseId, // Your endpoint to handle form submission
                method: 'POST',
                data: formData,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                dataType: 'json', // Expect JSON response from server
                success: function(response) {
                    if (response.success) {
                        alert('Course updated successfully!');
                        // Optionally reload the course details view after successful update
                        // loadCourseDetails(response.courseId); // Assuming response contains course ID
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred during form submission.');
                    console.error('Form Submit Error:', status, error, xhr.responseText);
                }
            });
        });
    });
</script>