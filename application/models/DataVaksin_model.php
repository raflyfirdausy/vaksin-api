<?php

class DataVaksin_model extends Custom_model
{
    public $table                   = 'data_vaksin';
    public $primary_key             = 'id';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one["desa"]  = [
            'foreign_model'     => 'Desa_model',
            'foreign_table'     => 'l_desa',
            'foreign_key'       => 'id_desa',
            'local_key'         => 'id_desa'
        ];
    }
}
