<?php

class KategoriUmur_model extends Custom_model
{
    public $table                   = 'kategori_umur';
    public $primary_key             = 'id_kategori_umur';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
