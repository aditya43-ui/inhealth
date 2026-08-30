<?php

/**
 * This is the model class for table "laporankonsultasigizirekap_v".
 *
 * The followings are the available columns in table 'laporankonsultasigizirekap_v':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $no_masukpenunjang
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property string $jmlkonsulgizi
 * @property string $tglmasukpenunjang
 */
class LaporankonsultasigizirekapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankonsultasigizirekapV the static model class
	 */
	public $tgl_awal,$tgl_akhir,$bulan, $instalasi;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporankonsultasigizirekap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmasukpenunjang_id, ruanganasal_id, kelaspelayanan_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('ruanganasal_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('no_masukpenunjang, daftartindakan_kode', 'length', 'max'=>20),
			array('daftartindakan_nama', 'length', 'max'=>200),
			array('jmlkonsulgizi, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmasukpenunjang_id, ruanganasal_id, ruanganasal_nama, kelaspelayanan_id, kelaspelayanan_nama, no_masukpenunjang, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, jmlkonsulgizi, tglmasukpenunjang', 'safe', 'on'=>'search'),
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
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'no_masukpenunjang' => 'No. Masukpenunjang',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'jmlkonsulgizi' => 'Jmlkonsulgizi',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
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

		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('jmlkonsulgizi',$this->jmlkonsulgizi,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}