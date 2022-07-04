<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends Auth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", "admin");
    }

    public function index()
    {
        redirect(base_url("auth/login"));
    }

    public function login()
    {
        $this->loadView('auth/login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url("auth"));
    }

    public function login_proses()
    {
        $username   = $this->input->post('username');
        $password   = md5($this->input->post('password'));

        $data       = $this->admin->where(["email" => $username, "password" => $password])->get();
        if ($data) {
            $this->session->set_userdata(SESSION, $data);
            redirect(base_url("dashboard"));
        } else {
            $this->session->set_flashdata("gagal", "Email atau password yang kamu masukan salah !. Silahkan coba lagi");
            redirect(base_url("auth/login"));
        }
    }
}
