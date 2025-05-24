<?php

class Users extends Controller
{
    public function index()
    {
        $data['judul'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('users/register');
        $this->view('templates/footer');
    }
    public function auth()
    {
        $data['judul'] = 'Sign In';
        $this->view('templates/header', $data);
        $this->view('users/auth');
        $this->view('templates/footer');
    }
    public function signIn()
    {
        $signIn = $this->model('Users_model')->signIn($_POST);
        if ($signIn['success'] == true) {
            header('Location: ' . BASEURL . '/');
            exit;
        } else {
            Flasher::setFlash($signIn['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/users/auth?error=' . $signIn['error']);
            exit;
        }
    }
    public function signOut()
    {
        session_destroy();
        session_unset();
        header('Location: ' . BASEURL);
    }
    public function register()
    {
        $data['judul'] = 'Register';
        $this->view('templates/header', $data);
        $this->view('users/register');
        $this->view('templates/footer');
    }
    public function submitRegistration()
    {
        $registration = $this->model('Users_model')->registerAccount($_POST);
        if ($registration['success'] == true) {
            Flasher::setFlash('Your account has been successfully registered. <br> You may sign in to your account.', 'success');
            header('Location: ' . BASEURL . '/users/auth');
            exit;
        } else {
            Flasher::setFlash($registration['error_msg'],  "danger");
            header('Location: ' . BASEURL . '/users/register?error=' . $registration['error'] . '&role=' . $registration['role']);
            exit;
        }
    }
}
