<?php

/**
 * This is the model class for table "hasilpemeriksaanmikro_m".
 *
 * The followings are the available columns in table 'hasilpemeriksaanmikro_m':
 * @property integer $hasilpemeriksaanmikro_id
 * @property string $kelompok_mikroorganisme
 * @property string $hasilpemeriksaan
 * @property boolean $hasilpemeriksaan_aktif
 */
class Hasilpemeriksaanmikro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hasilpemeriksaanmikro_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		//	array('hasilpemeriksaanmikro_id', 'required'),
			array('hasilpemeriksaanmikro_id', 'numerical', 'integerOnly'=>true),
			array('kelompok_mikroorganisme, hasilpemeriksaan', 'length', 'max'=>100),
			array('hasilpemeriksaan_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hasilpemeriksaanmikro_id, kelompok_mikroorganisme, hasilpemeriksaan, hasilpemeriksaan_aktif', 'safe', 'on'=>'search'),
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
			'hasilpemeriksaanmikro_id' => 'Hasilpemeriksaanmikro',
			'kelompok_mikroorganisme' => 'Kelompok Mikroorganisme',
			'hasilpemeriksaan' => 'Hasilpemeriksaan',
			'hasilpemeriksaan_aktif' => 'Hasilpemeriksaan Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('hasilpemeriksaanmikro_id',$this->hasilpemeriksaanmikro_id);
		$criteria->compare('kelompok_mikroorganisme',$this->kelompok_mikroorganisme,true);
		$criteria->compare('hasilpemeriksaan',$this->hasilpemeriksaan,true);
		$criteria->compare('hasilpemeriksaan_aktif',$this->hasilpemeriksaan_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanmikroM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
