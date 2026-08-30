<?php

class MAPenyusutanasetT extends PenyusutanasetT{
	public $namaBarang;
	public $kodeInventarisasi, $noRegister, $tglPerolehanBarang;
	public $inv_id;
	public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}