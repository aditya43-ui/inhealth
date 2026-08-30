<?php
/**
 * This is the model class for table "perdatarif_m".
 *
 * The followings are the available columns in table 'perdatarif_m':
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property boolean $perda_aktif
 */
Class SAPerdaTarifM extends PerdatarifM {
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}