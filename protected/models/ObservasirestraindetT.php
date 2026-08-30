<?php

/**
 * This is the model class for table "observasirestraindet_t".
 *
 * The followings are the available columns in table 'observasirestraindet_t':
 * @property integer $observasirestraindet_id
 * @property integer $observasirestrain_id
 * @property string $tiperestrain
 * @property string $lamarestrain
 * @property string $frekuensirestrain
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property ObservasirestrainT $observasirestrain
 */
class ObservasirestraindetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasirestraindetT the static model class
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
		return 'observasirestraindet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('observasirestrain_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('observasirestrain_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tiperestrain, lamarestrain, frekuensirestrain', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasirestraindet_id, observasirestrain_id, tiperestrain, lamarestrain, frekuensirestrain, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'observasirestrain' => array(self::BELONGS_TO, 'ObservasirestrainT', 'observasirestrain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasirestraindet_id' => 'Observasirestraindet',
			'observasirestrain_id' => 'Observasirestrain',
			'tiperestrain' => 'Tiperestrain',
			'lamarestrain' => 'Lamarestrain',
			'frekuensirestrain' => 'Frekuensirestrain',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('observasirestraindet_id',$this->observasirestraindet_id);
		$criteria->compare('observasirestrain_id',$this->observasirestrain_id);
		$criteria->compare('tiperestrain',$this->tiperestrain,true);
		$criteria->compare('lamarestrain',$this->lamarestrain,true);
		$criteria->compare('frekuensirestrain',$this->frekuensirestrain,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}