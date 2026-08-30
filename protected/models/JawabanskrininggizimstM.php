<?php

/**
 * This is the model class for table "jawabanskrininggizimst_m".
 *
 * The followings are the available columns in table 'jawabanskrininggizimst_m':
 * @property integer $jawabanskrininggizimst_id
 * @property integer $skrininggizimst_id
 * @property string $jawabanskrininggizimst_nilai
 * @property boolean $jawabanskrininggizimst_aktif
 *
 * The followings are the available model relations:
 * @property SkrininggizimstM $skrininggizimst
 */
class JawabanskrininggizimstM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jawabanskrininggizimst_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('skrininggizimst_id', 'required'),
			array('skrininggizimst_id', 'numerical', 'integerOnly'=>true),
			array('jawabanskrininggizimst_nilai', 'length', 'max'=>300),
			array('jawabanskrininggizimst_aktif, jawabanskrininggizimst_nama', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jawabanskrininggizimst_id, skrininggizimst_id, jawabanskrininggizimst_nilai, jawabanskrininggizimst_aktif, jawabanskrininggizimst_nama', 'safe', 'on'=>'search'),
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
			'skrininggizimst' => array(self::BELONGS_TO, 'SkrininggizimstM', 'skrininggizimst_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jawabanskrininggizimst_id' => 'Jawabanskrininggizimst',
			'skrininggizimst_id' => 'Skrininggizimst',
			'jawabanskrininggizimst_nilai' => 'Jawabanskrininggizimst Nilai',
			'jawabanskrininggizimst_aktif' => 'Jawabanskrininggizimst Aktif',
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

		$criteria->compare('jawabanskrininggizimst_id',$this->jawabanskrininggizimst_id);
		$criteria->compare('skrininggizimst_id',$this->skrininggizimst_id);
		$criteria->compare('jawabanskrininggizimst_nilai',$this->jawabanskrininggizimst_nilai,true);
		$criteria->compare('jawabanskrininggizimst_aktif',$this->jawabanskrininggizimst_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JawabanskrininggizimstM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
