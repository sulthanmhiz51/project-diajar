<?php
class Courses_model
{
    private $table = 'courses';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function createNewCourse($data, $thumbnailFile, $instrId)
    {
        $newThumbnailPhotoName = null; // To store new uploaded photo name

        // --- Handle File Upload ---
        if ($thumbnailFile && $thumbnailFile['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . "/../../public/img/thumbnail/";
            $fileTmpPath = $thumbnailFile['tmp_name'];
            $fileName = $thumbnailFile['name'];
            $fileSize = $thumbnailFile['size'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $newFileName = uniqid() . '_' . basename($fileName); // Generate unique name
            $destPath = $uploadDir . $newFileName;

            // Basic validation for file type and size
            $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($fileExtension, $allowedFileExtensions)) {
                return [
                    'success' => false,
                    'message' => 'Only JPG, JPEG, PNG & WEBP files are allowed'
                ];
            }
            if ($fileSize > 5000000) // Max 5MB
            {
                return [
                    'success' => false,
                    'message' => 'Thumbnail picture is too big (max 5MB)'
                ];
            }
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                error_log("Failed to move uploaded file...");
                return ['success' => false, 'message' => 'Error uploading profile picture. Please try again.'];
            }
            $newThumbnailPhotoName = $newFileName ?? NULL;
        }

        $query = "INSERT INTO " . $this->table . "
                    (title, description, instructor_id, thumbnail_url)
                    VALUES (:title, :desc, :instrId, :thumbnail)";
        $this->db->query($query);
        $this->db->bind('title', $data['title']);
        $this->db->bind('desc', $data['description']);
        $this->db->bind('instrId', $instrId);
        if ($newThumbnailPhotoName) {
            $this->db->bind('thumbnail', $newThumbnailPhotoName);
        }
        try {
            $this->db->execute();
            $courseId = $this->db->lastInsertId(); // Get the newly created user's ID

            return [
                'success' => true,
                'courseId' => $courseId
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
            ];
        }
    }
    public function loadCourse($courseId)
    {
        $query = "SELECT u.username as instr_uname, up.first_name, up.last_name, c.title, c.description, c.created_at, c.thumbnail_url
                FROM courses c
                JOIN users u ON c.instructor_id = u.id
                JOIN users_profile up ON u.id = up.user_id
                WHERE c.id = :courseId;";
        $this->db->query($query);
        $this->db->bind('courseId', $courseId);
        try {
            $result = $this->db->single();
            $result['created_at'] = date('l, d F Y', strtotime($result['created_at']));
            return [
                'success' => true,
                'course' => $result
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->errorInfo[1],
                'error_msg' => 'An unexpected error occurred.',
            ];
        }
    }
    public function loadCoursesCards($start)
    {
        $this->db->query("SELECT * FROM " . $this->table);
        $this->db->resultSet();
        $page_count = ceil($this->db->rowCount() / 6);

        $start = ($start - 1) * 6;
        $query = "SELECT c.id, c.title, c.thumbnail_url, up.first_name, up.last_name, u.username
                    FROM " . $this->table . " c
                    JOIN users u ON c.instructor_id = u.id
                    JOIN users_profile up ON u.id = up.user_id
                    LIMIT 6 OFFSET :start";
        $this->db->query($query);

        $this->db->bind('start', $start);
        $cards = $this->db->resultSet();
        $item_count = $this->db->rowCount();

        return [
            'cards' => $cards,
            'pagesCount' => $page_count,
            'itemsCount' => $item_count
        ];
    }
}
