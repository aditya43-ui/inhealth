<?php

/**
 * This is the model class for table "informasipengajuanklaimpiutang_v".
 *
 * The followings are the available columns in table 'informasipengajuanklaimpiutang_v':
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalsisapiutang
 * @property string $tgljatuhtempo
 */
class InformasipengajuanklaimpiutangV extends CActiveRecord
{
	public $pegawai_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipengajuanklaimpiutangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasipengajuanklaimpiutang_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanklaimpiutang_id, carabayar_id, penjamin_id, petugasoperator_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalsisapiutang, jumlahpembayar, totaltagihan, jmlpiutangtaktertagih', 'numerical'),
			array('carabayar_nama, penjamin_nama, nopengajuanklaimanklaim', 'length', 'max'=>50),
			array('tglpengajuanklaimanklaim, tgljatuhtempo, petugasoperator_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanklaimpiutang_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, totalsisapiutang, tgljatuhtempo, petugasoperator_nama, petugasoperator_id, jumlahpembayar, totaltagihan, jmlpiutangtaktertagih', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanklaimpiutang_id' => 'Pengajuan Klaim Piutang',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Cara Bayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Nama Penjamin',
			'tglpengajuanklaimanklaim' => 'Tanggal Pengajuan Klaim',
			'nopengajuanklaimanklaim' => 'No. Pengajuan Klaim',
			'totalpiutang' => 'Total Piutang',
			'totalsisapiutang' => 'Total Sisa Piutang',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
