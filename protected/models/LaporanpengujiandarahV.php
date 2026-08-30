<?php

/**
 * This is the model class for table "laporanpengujiandarah_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'laporanpengujiandarah_v':
 * @property integer $kantongdarah_id
 * @property string $tglpengujian
 * @property string $no_kantongdarah
 * @property string $gol_darah
 * @property string $rhesus
 * @property string $gol_darah_awal
 * @property string $rhesus_awal
 * @property string $hasil_uji
 */
class LaporanpengujiandarahV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengujiandarahV the static model class
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
		return 'laporanpengujiandarah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kantongdarah_id', 'numerical', 'integerOnly'=>true),
			array('no_kantongdarah', 'length', 'max'=>100),
			array('gol_darah, gol_darah_awal', 'length', 'max'=>2),
			array('rhesus, rhesus_awal', 'length', 'max'=>20),
			array('hasil_uji', 'length', 'max'=>50),
			array('tglpengujian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kantongdarah_id, tglpengujian, no_kantongdarah, gol_darah, rhesus, gol_darah_awal, rhesus_awal, hasil_uji', 'safe', 'on'=>'search'),
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
			'kantongdarah_id' => 'Kantongdarah',
			'tglpengujian' => 'Tglpengujian',
			'no_kantongdarah' => 'No Kantongdarah',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'gol_darah_awal' => 'Gol Darah Awal',
			'rhesus_awal' => 'Rhesus Awal',
			'hasil_uji' => 'Hasil Uji',
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

		$criteria->compare('kantongdarah_id',$this->kantongdarah_id);
		$criteria->compare('tglpengujian',$this->tglpengujian,true);
		$criteria->compare('no_kantongdarah',$this->no_kantongdarah,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('gol_darah_awal',$this->gol_darah_awal,true);
		$criteria->compare('rhesus_awal',$this->rhesus_awal,true);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}