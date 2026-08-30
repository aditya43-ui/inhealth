<?php

/**
 * This is the model class for table "laporanangkakematian_v".
 *
 * The followings are the available columns in table 'laporanangkakematian_v':
 * @property string $namars
 * @property double $tahun
 * @property string $pasien_keluar_l
 * @property string $pasien_keluar_p
 * @property string $pasien_meninggal_l
 * @property string $pasien_meninggal_p
 * @property string $pasien_meninggal_24_l
 * @property string $pasien_meninggal_24_p
 */
class LaporanangkakematianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanangkakematianV the static model class
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
		return 'laporanangkakematian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tahun', 'numerical'),
			array('namars', 'length', 'max'=>50),
			array('pasien_keluar_l, bulan, pasien_keluar_p, pasien_meninggal_l, pasien_meninggal_p, pasien_meninggal_24_l, pasien_meninggal_24_p', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('namars, tahun, bulan, pasien_keluar_l, pasien_keluar_p, pasien_meninggal_l, pasien_meninggal_p, pasien_meninggal_24_l, pasien_meninggal_24_p', 'safe', 'on'=>'search'),
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
			'namars' => 'Namars',
			'tahun' => 'Tahun',
			'pasien_keluar_l' => 'Pasien Keluar L',
			'pasien_keluar_p' => 'Pasien Keluar P',
			'pasien_meninggal_l' => 'Pasien Meninggal L',
			'pasien_meninggal_p' => 'Pasien Meninggal P',
			'pasien_meninggal_24_l' => 'Pasien Meninggal 24 L',
			'pasien_meninggal_24_p' => 'Pasien Meninggal 24 P',
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

		$criteria->compare('namars',$this->namars,true);
		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('pasien_keluar_l',$this->pasien_keluar_l,true);
		$criteria->compare('pasien_keluar_p',$this->pasien_keluar_p,true);
		$criteria->compare('pasien_meninggal_l',$this->pasien_meninggal_l,true);
		$criteria->compare('pasien_meninggal_p',$this->pasien_meninggal_p,true);
		$criteria->compare('pasien_meninggal_24_l',$this->pasien_meninggal_24_l,true);
		$criteria->compare('pasien_meninggal_24_p',$this->pasien_meninggal_24_p,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}