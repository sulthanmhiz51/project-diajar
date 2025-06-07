<?php

class Courses extends Controller
{
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
        $course = $this->model('Courses_model')->loadCourse($_GET['courseId']);
        $data['judul'] = 'Course Detail';

        $this->view('templates/header', $data);
        $this->view('courses/detail', $course);
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
}
