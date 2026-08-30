<?php

/**
 * This is the model class for table "perhitunganbalancecairan_t".
 *
 * The followings are the available columns in table 'perhitunganbalancecairan_t':
 * @property integer $perhitunganbalancecairan_id
 * @property integer $pasienadmisi_id
 * @property string $balancecairan_tanggal
 * @property string $waktu_perhitungan
 * @property integer $petugaspengisi_id
 * @property double $totalcairanmasuk
 * @property double $totalcairankeluar
 * @property double $totaliwl
 * @property double $balancecairan_sekarang
 * @property double $balancecairan_sebelumnya
 * @property double $balancecairan_komulatif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $petugaspengisi
 */
class PerhitunganbalancecairanT extends CActiveRecord
{
	public $petugaspengisi_nama;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerhitunganbalancecairanT the static model class
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
		return 'perhitunganbalancecairan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienadmisi_id, balancecairan_tanggal, waktu_perhitungan, petugaspengisi_id, totalcairanmasuk, totalcairankeluar, totaliwl, balancecairan_sekarang, create_time, create_loginpemakai_id', 'required'),
			array('pasienadmisi_id, petugaspengisi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('totalcairanmasuk, totalcairankeluar, totaliwl, balancecairan_sekarang, balancecairan_sebelumnya, balancecairan_komulatif', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perhitunganbalancecairan_id, pasienadmisi_id, balancecairan_tanggal, waktu_perhitungan, petugaspengisi_id, totalcairanmasuk, totalcairankeluar, totaliwl, balancecairan_sekarang, balancecairan_sebelumnya, balancecairan_komulatif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perhitunganbalancecairan_id' => 'Perhitunganbalancecairan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'balancecairan_tanggal' => 'Balance Cairan Tanggal',
			'waktu_perhitungan' => 'Tanggal & Jam Perhitungan Balance Cairan',
			'petugaspengisi_id' => 'Petugaspengisi',
			'totalcairanmasuk' => 'Total Cairan Masuk (Dalam 24 Jam)',
			'totalcairankeluar' => 'Total Cairan Keluar (Dalam 24 Jam)',
			'totaliwl' => 'Total IWL (Dalam 24 Jam)',
			'balancecairan_sekarang' => 'Balance Cairan Sekarang (Dalam 24 Jam)',
			'balancecairan_sebelumnya' => 'Balance Cairan Sebelumnya',
			'balancecairan_komulatif' => 'Balance Cairan Komulatif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('perhitunganbalancecairan_id',$this->perhitunganbalancecairan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('balancecairan_tanggal',$this->balancecairan_tanggal,true);
		$criteria->compare('waktu_perhitungan',$this->waktu_perhitungan,true);
		$criteria->compare('petugaspengisi_id',$this->petugaspengisi_id);
		$criteria->compare('totalcairanmasuk',$this->totalcairanmasuk);
		$criteria->compare('totalcairankeluar',$this->totalcairankeluar);
		$criteria->compare('totaliwl',$this->totaliwl);
		$criteria->compare('balancecairan_sekarang',$this->balancecairan_sekarang);
		$criteria->compare('balancecairan_sebelumnya',$this->balancecairan_sebelumnya);
		$criteria->compare('balancecairan_komulatif',$this->balancecairan_komulatif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
