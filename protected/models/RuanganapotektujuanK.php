<?php

/**
 * This is the model class for table "ruanganapotektujuan_k".
 *
 * The followings are the available columns in table 'ruanganapotektujuan_k':
 * @property integer $ruanganapotektujuan_id
 * @property integer $ruanganpelayanan_id
 * @property boolean $is_alih
 */
class RuanganapotektujuanK extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ruanganapotektujuan_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruanganapotektujuan_id, ruanganpelayanan_id', 'required'),
			array('ruanganapotektujuan_id, ruanganpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('is_alih', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ruanganapotektujuan_id, ruanganpelayanan_id, is_alih', 'safe', 'on'=>'search'),
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
			'ruanganapotektujuan_id' => 'Ruanganapotektujuan',
			'ruanganpelayanan_id' => 'Ruanganpelayanan',
			'is_alih' => 'Is Alih',
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

		$criteria->compare('ruanganapotektujuan_id',$this->ruanganapotektujuan_id);
		$criteria->compare('ruanganpelayanan_id',$this->ruanganpelayanan_id);
		$criteria->compare('is_alih',$this->is_alih);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RuanganapotektujuanK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
