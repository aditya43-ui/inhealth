<?php

/**
 * This is the model class for table "informasisaldoawal_v".
 *
 * The followings are the available columns in table 'informasisaldoawal_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $tiperekening_id
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property double $jmlsaldoawald
 * @property double $jmlsaldoawalk
 */
class KUInformasisaldoawalV extends InformasisaldoawalV
{
    
	public $debit, $kredit, $jmlrekening;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisaldoawalV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}