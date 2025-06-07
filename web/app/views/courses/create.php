<div class="profile d-flex justify-content-center align-content-center h-100">
    <div class="bg-body w-75 p-5">
        <div class="container">
            <h2 class="mt-5">Create a New Course</h2>
            <hr>
            <form action="<?= BASEURL ?>/courses/createCourse" method="POST" enctype="multipart/form-data">
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
                        <a href="./" class="btn btn-outline-danger">Cancel</a>
                        <button type="submit" class="col btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
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
    });
</script>