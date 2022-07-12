<?php
defined('BASEPATH') or exit('No direct script access allowed');
header('Content-Type: application/json');
class Api extends RFLController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("DataVaksin_model", "dataVaksin");
        $this->load->model("Login_model", "login");
        $this->load->model("Desa_model", "desa");
        $this->load->model("Kecamatan_model", "kecamatan");
        $this->load->model("KategoriUmur_model", "kategoriUmur");
    }


    public function index()
    {
        echo json_encode([
            "code"      => 200,
            "message"   => "RAFLY WAS HERE !!"
        ]);
    }

    public function register()
    {
        $username           = $this->input->post("username");
        $password           = $this->input->post("password");
        $nama               = $this->input->post("nama");
        $id_jenis_kelamin   = $this->input->post("id_jenis_kelamin");

        //TODO : CEK USERNAME IF EXIST OR NOT
        $cek = $this->login->where(["username" => $username])->get();
        if ($cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Username $username telah terdaftar, silahkan gunakan username yang lain",
                "data"      => NULL
            ]);
            die;
        }

        if (empty($password) || $password == "") {
            echo json_encode([
                "code"      => 404,
                "message"   => "Password tidak boleh kosong",
                "data"      => NULL
            ]);
            die;
        }

        if (empty($nama) || $nama == "") {
            echo json_encode([
                "code"      => 404,
                "message"   => "Nama tidak boleh kosong",
                "data"      => NULL
            ]);
            die;
        }

        if (empty($id_jenis_kelamin) || $id_jenis_kelamin == "") {
            echo json_encode([
                "code"      => 404,
                "message"   => "Jenis Kelamin tidak boleh kosong",
                "data"      => NULL
            ]);
            die;
        }

        //TODO : INSERT INTO DB
        $insert = $this->login->insert([
            "nama"              => $nama,
            "id_jenis_kelamin"  => $id_jenis_kelamin,
            "username"          => $username,
            "password"          => md5($password),
        ]);

        if (!$insert) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Terjadi kesalahan saat melakukan pendaftaran",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Pendaftaran berhasil",
        ]);
        die;
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $cek = $this->login->where(["username" => $username, "password" => $password])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Username atau password yang kamu masukan salah, Silahkan coba lagi",
                "data"      => NULL
            ]);
            die;
        }

        echo json_encode([
            "code"      => 200,
            "message"   => "Data ditemukan",
            "data"      => $cek
        ]);
        die;
    }

    public function ubah_password()
    {
        $id_user                    = $this->input->post("id_user");
        $password_lama              = $this->input->post("password_lama");
        $password_baru              = $this->input->post("password_baru");
        $password_baru_konfirmasi   = $this->input->post("password_baru_konfirmasi");

        if (empty($password_lama)) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Password lama tidak boleh kosong",
            ]);
            die;
        }

        if (empty($password_baru)) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Password Baru tidak boleh kosong",
            ]);
            die;
        }

        if (empty($password_baru_konfirmasi)) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Konfirmasi password Baru tidak boleh kosong",
            ]);
            die;
        }

        if ($password_baru != $password_baru_konfirmasi) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Konfirmasi password Baru tidak sama",
            ]);
            die;
        }

        $cek = $this->login->where(["id_user" => $id_user, "password" => md5($password_lama)])->get();
        if (!$cek) {
            echo json_encode([
                "code"      => 404,
                "message"   => "Password Lama yang kamu masukan salah",
            ]);
            die;
        }

        $this->login->where(["id_user" => $id_user])->update(["password" => md5($password_baru)]);
        echo json_encode([
            "code"      => 200,
            "message"   => "Password Berhasil diubah. Silahkan login ulang menggunakan password yang baru",
        ]);
    }

    public function data_vaksin()
    {
        $id_desa = $this->input->get('id_desa');

        $where = [];
        if (!empty($id_desa)) {
            $where["id_desa"]   = $id_desa;
        }

        $data = $this->dataVaksin->as_array()->with_desa()->where($where)->get_all() ?: [];
        echo json_encode([
            "code"      => 200,
            "message"   => "Data ditemukan",
            "data"      => $data
        ]);
    }

    public function kategori_umur()
    {
        $data = $this->kategoriUmur->as_array()->get_all() ?: [];
        echo json_encode([
            "code"      => 200,
            "message"   => "Data ditemukan",
            "data"      => $data
        ]);
    }

    public function desa()
    {
        $id_desa = $this->input->get('id_desa');

        $where = [];
        if (!empty($id_desa)) {
            $where["id_desa"]   = $id_desa;
        }

        $data = $this->desa->with_kecamatan()->as_array()->where($where)->get_all() ?: [];
        echo json_encode([
            "code"      => 200,
            "message"   => "Data ditemukan",
            "data"      => $data
        ]);
    }

    public function kecamatan()
    {
        $id_kecamatan = $this->input->get('id_kecamatan');

        $where = [];
        if (!empty($id_kecamatan)) {
            $where["id_kecamatan"]   = $id_kecamatan;
        }

        $data = $this->kecamatan->as_array()->where($where)->get_all() ?: [];
        echo json_encode([
            "code"      => 200,
            "message"   => "Data ditemukan",
            "data"      => $data
        ]);
    }
}
