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
