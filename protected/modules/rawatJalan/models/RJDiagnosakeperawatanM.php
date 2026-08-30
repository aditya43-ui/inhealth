<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RJDiagnosakeperawatanM extends DiagnosakeperawatanM
{
    public $diagnosa_nama;
    public $diagnosakeperawatan_kode;
    public $kriteriahasil_nama;
    public $kriteriahasil_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosatindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

?>
