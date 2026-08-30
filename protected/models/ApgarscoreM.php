<?php

/**
 * This is the model class for table "apgarscore_m".
 *
 * The followings are the available columns in table 'apgarscore_m':
 * @property integer $apgarscore_id
 * @property string $apgarscore_kritera
 * @property string $apgarscore_penilaian
 * @property integer $apgarscore_score
 * @property boolean $apgarscore_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 */
class ApgarscoreM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'apgarscore_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, creale_login, ruangan_id', 'required'),
			array('apgarscore_score, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('apgarscore_kritera', 'length', 'max'=>100),
			array('apgarscore_penilaian', 'length', 'max'=>200),
			array('apgarscore_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('apgarscore_id, apgarscore_kritera, apgarscore_penilaian, apgarscore_score, apgarscore_aktif, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'apgarscore_id' => 'Apgarscore',
			'apgarscore_kritera' => 'Apgarscore Kritera',
			'apgarscore_penilaian' => 'Apgarscore Penilaian',
			'apgarscore_score' => 'Apgarscore Score',
			'apgarscore_aktif' => 'Apgarscore Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'creale_login' => 'Creale Login',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'ruangan_id' => 'Ruangan',
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

		$criteria->compare('apgarscore_id',$this->apgarscore_id);
		$criteria->compare('apgarscore_kritera',$this->apgarscore_kritera,true);
		$criteria->compare('apgarscore_penilaian',$this->apgarscore_penilaian,true);
		$criteria->compare('apgarscore_score',$this->apgarscore_score);
		$criteria->compare('apgarscore_aktif',$this->apgarscore_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ApgarscoreM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
