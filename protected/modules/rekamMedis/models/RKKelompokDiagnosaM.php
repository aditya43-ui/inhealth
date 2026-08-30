<?php
/**
 * This is the model class for table "kelompokdiagnosa_m".
 *
 * The followings are the available columns in table 'kelompokdiagnosa_m':
 * @property integer $kelompokdiagnosa_id
 * @property string $kelompokdiagnosa_nama
 * @property string $kelompokdiagnosa_namalainnya
 * @property boolean $kelompokdiagnosa_aktif
 */
Class RKKelompokDiagnosaM extends KelompokdiagnosaM{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokdiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

