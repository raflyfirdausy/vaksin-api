<?php

class Desa_model extends Custom_model
{
    public $table                   = 'l_desa';
    public $primary_key             = 'id';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
        $this->has_one["kecamatan"]  = [
            'foreign_model'     => 'Kecamatan_model',
            'foreign_table'     => 'l_kecamatan',
            'foreign_key'       => 'id_kecamatan',
            'local_key'         => 'id_kecamatan'
        ];
    }
}
