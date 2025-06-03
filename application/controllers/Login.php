<?php

/**
 *  @property CI_Login_model $Login_model
 * @property CI_Input $input
 * @property CI_Session $session
 */
class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Login_model');
        $this->load->library('session');
    }

    public function index()
    {
        // If already logged in, redirect to home
        if ($this->session->userdata('user')) {
            redirect('home');
        } else {
            $this->load->view('login_form');
        }
    }

    public function login()
    {
        $name = $this->input->post('name');
        $password = $this->input->post('password');

        // Example validation logic (replace with your actual DB check)
        if ($name === 'admin' && $password === '1234') {
            $this->session->set_userdata('logged_in', true);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
    }



    public function home()
    {
        if ($this->session->userdata('user')) {
            $this->load->view('home');
        } else {
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('login');
    }
}
