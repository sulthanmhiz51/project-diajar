<?php

class Courses extends Controller
{
    protected $middleware = [
        ['InstructorsMiddleware', ['create']]
    ];
    public function index()
    {
        $data['judul'] = 'Courses';
        $page = $_GET['page'] ?? 1;
        $cards = $this->model('Courses_model')->loadCoursesCards($page);

        $this->view('templates/header', $data);
        $this->view('courses/index', $cards);
        $this->view('templates/footer');
    }

    public function detail()
    {
        if (!isset($_GET['courseId'])) {
            header('Location: ' . BASEURL . '/courses/index');
        }
        $course = $this->model('Courses_model')->loadCourse($_GET['courseId']);
        $data['judul'] = 'Course Detail';
        $data['enrolled'] = $this->model('Courses_model')->isUserEnrolled($_SESSION['user_id'], $_GET['courseId']);
        $data['course'] = $course['course'];

        if ($course['success'] == false) {
            Flasher::setFlash($course['message'],  "danger");
            header('Location: ' . BASEURL . '/courses');
            exit;
        }

        $this->view('templates/header', $data);
        $this->view('courses/detail', $data);
        $this->view('templates/footer');
    }
    public function create()
    {
        $data['judul'] = 'Create Course';

        $this->view('templates/header', $data);
        $this->view('courses/create');
        $this->view('templates/footer');
    }

    public function createCourse()
    {
        $result = $this->model('Courses_model')->createNewCourse($_POST, $_FILES['thumbnail'], $_SESSION['user_id']);
        if ($result['success'] == true) {
            Flasher::setFlash('Course has been successfully created.', 'success');
            header('Location: ' . BASEURL . '/courses/detail?courseId=' . $result['courseId']);
            exit;
        } else {
            Flasher::setFlash($result['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/courses/create?error=' . $result['error']);
            exit;
        }
    }
    public function enroll()
    {
        $result = $this->model('Courses_model')->enrollCourse($_SESSION['user_id'], $_GET['courseId']);
        if ($result['success'] == true) {
            Flasher::setFlash($result['message'], 'success');
            header('Location: ' . BASEURL . '/courses/detail?courseId=' . $result['courseId']);
            exit;
        } else {
            Flasher::setFlash($result['message'],  "danger");
            header('Location: ' . BASEURL . '/courses?error=' . $result['error']);
            exit;
        }
    }
    public function editCourse($courseId)
    {
        // Fetch existing course data to pre-fill the form
        $courseData = $this->model('Courses_model')->loadCourse($courseId); // Re-use your loadCourse method

        if ($courseData['success'] && $courseData['course']) {
            $this->view('courses/edit', ['course' => $courseData['course'], 'courseId' => $courseData['courseId']]);
        } else {
            // Handle case where course is not found, perhaps render an error message partial
            echo '<div class="alert alert-warning">Course not found for editing.</div>';
        }
    }
    public function addModule($courseId) {}
}
