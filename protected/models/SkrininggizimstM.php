<?php

/**
 * This is the model class for table "skrininggizimst_m".
 *
 * The followings are the available columns in table 'skrininggizimst_m':
 * @property integer $skrininggizimst_id
 * @property string $skrininggizimst_nama
 * @property boolean $skrininggizimst_aktif
 * @property string $skrininggizimst_jenis
 *
 * The followings are the available model relations:
 * @property JawabanskrininggizimstM[] $jawabanskrininggizimstMs
 */
class SkrininggizimstM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'skrininggizimst_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('skrininggizimst_nama', 'length', 'max'=>300),
			array('skrininggizimst_jenis', 'length', 'max'=>150),
			array('skrininggizimst_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('skrininggizimst_id, skrininggizimst_nama, skrininggizimst_aktif, skrininggizimst_jenis', 'safe', 'on'=>'search'),
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
			'jawabanskrininggizimstMs' => array(self::HAS_MANY, 'JawabanskrininggizimstM', 'skrininggizimst_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skrininggizimst_id' => 'Skrininggizimst',
			'skrininggizimst_nama' => 'Skrininggizimst Nama',
			'skrininggizimst_aktif' => 'Skrininggizimst Aktif',
			'skrininggizimst_jenis' => 'Skrininggizimst Jenis',
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

		$criteria->compare('skrininggizimst_id',$this->skrininggizimst_id);
		$criteria->compare('skrininggizimst_nama',$this->skrininggizimst_nama,true);
		$criteria->compare('skrininggizimst_aktif',$this->skrininggizimst_aktif);
		$criteria->compare('skrininggizimst_jenis',$this->skrininggizimst_jenis,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SkrininggizimstM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
