<?php

/**
 * This is the model class for table "pemantauankalaiv_t".
 *
 * The followings are the available columns in table 'pemantauankalaiv_t':
 * @property integer $pemantauankalaiv_id
 * @property integer $pemeriksaankala_id
 * @property string $waktu
 * @property integer $systolic
 * @property integer $diastolic
 * @property integer $nadi
 * @property double $suhu
 * @property string $tinggi_fundus_uteri
 * @property string $kontraksi_uterus
 * @property string $kantung_kemih
 * @property string $darah_yang_keluar
 *
 * The followings are the available model relations:
 * @property PemeriksaankalaT $pemeriksaankala
 */
class PemantauankalaivT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemantauankalaivT the static model class
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
		return 'pemantauankalaiv_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaankala_id, waktu', 'required'),
			array('pemeriksaankala_id, systolic, diastolic, nadi, jam_ke', 'numerical', 'integerOnly'=>true),
			array('suhu', 'numerical'),
			array('tinggi_fundus_uteri, kontraksi_uterus, kantung_kemih, darah_yang_keluar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemantauankalaiv_id, pemeriksaankala_id, waktu, systolic, diastolic, nadi, suhu, tinggi_fundus_uteri, kontraksi_uterus, kantung_kemih, darah_yang_keluar, jam_ke', 'safe', 'on'=>'search'),
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
			'pemeriksaankala' => array(self::BELONGS_TO, 'PemeriksaankalaT', 'pemeriksaankala_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemantauankalaiv_id' => 'Pemantauankalaiv',
			'pemeriksaankala_id' => 'Pemeriksaankala',
			'waktu' => 'Waktu',
			'systolic' => 'Systolic',
			'diastolic' => 'Diastolic',
			'nadi' => 'Nadi',
			'suhu' => 'Suhu',
			'tinggi_fundus_uteri' => 'Tinggi Fundus Uteri',
			'kontraksi_uterus' => 'Kontraksi Uterus',
			'kantung_kemih' => 'Kantung Kemih',
			'darah_yang_keluar' => 'Darah Yang Keluar',
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

		$criteria->compare('pemantauankalaiv_id',$this->pemantauankalaiv_id);
		$criteria->compare('pemeriksaankala_id',$this->pemeriksaankala_id);
		$criteria->compare('waktu',$this->waktu,true);
		$criteria->compare('systolic',$this->systolic);
		$criteria->compare('diastolic',$this->diastolic);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('tinggi_fundus_uteri',$this->tinggi_fundus_uteri,true);
		$criteria->compare('kontraksi_uterus',$this->kontraksi_uterus,true);
		$criteria->compare('kantung_kemih',$this->kantung_kemih,true);
		$criteria->compare('darah_yang_keluar',$this->darah_yang_keluar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}