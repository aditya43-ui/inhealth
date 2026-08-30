<?php

/**
 * This is the model class for table "laporankinerjadinkes_v".
 *
 * The followings are the available columns in table 'laporankinerjadinkes_v':
 * @property double $tahun
 * @property double $bulan
 * @property string $namars
 * @property string $pasien_keluar
 * @property string $hariperawatan
 * @property string $lamadirawat
 */
class LaporankinerjadinkesV extends CActiveRecord
{
	public $jumlah_kamar;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankinerjadinkesV the static model class
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
		return 'laporankinerjadinkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tahun, bulan', 'numerical'),
			array('namars', 'length', 'max'=>50),
			array('pasien_keluar, hariperawatan, lamadirawat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, bulan, namars, pasien_keluar, hariperawatan, lamadirawat', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'bulan' => 'Bulan',
			'namars' => 'Namars',
			'pasien_keluar' => 'Pasien Keluar',
			'hariperawatan' => 'Hariperawatan',
			'lamadirawat' => 'Lamadirawat',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('namars',$this->namars,true);
		$criteria->compare('pasien_keluar',$this->pasien_keluar,true);
		$criteria->compare('hariperawatan',$this->hariperawatan,true);
		$criteria->compare('lamadirawat',$this->lamadirawat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}