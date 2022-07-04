<?php

class Kecamatan_model extends Custom_model
{
    public $table                   = 'l_kecamatan';
    public $primary_key             = 'id_kecamatan';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
