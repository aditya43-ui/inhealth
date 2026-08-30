<?php

/**
 * This is the model class for table "jenispengeluaran_m".
 *
 * The followings are the available columns in table 'jenispengeluaran_m':
 * @property integer $jenispengeluaran_id
 * @property string $jenispengeluaran_nama
 * @property string $jenispengeluaran_namalain
 * @property boolean $jenispengeluaran_aktif
 */
class KUJenispengeluaranM extends JenispengeluaranM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenispengeluaranM the static model class
	 */
        public $rekDebit, $rekKredit;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
