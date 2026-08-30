<?php

/**
 * This is the model class for table "kiepasiendet_t".
 *
 * The followings are the available columns in table 'kiepasiendet_t':
 * @property integer $kiepasiendet_id
 * @property integer $kiepasien_id
 * @property string $jeniskie
 * @property integer $listkie_id
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property string $create_time
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property KiepasienT $kiepasien
 * @property ListkieM $listkie
 */
class KiepasiendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KiepasiendetT the static model class
	 */
	public $is_pilih,$listkie_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kiepasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kiepasien_id, listkie_id, create_loginpemakai, update_loginpemakai', 'numerical', 'integerOnly'=>true),
			array('jeniskie', 'length', 'max'=>100),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kiepasiendet_id, kiepasien_id, jeniskie, listkie_id, create_loginpemakai, update_loginpemakai, create_time, update_time', 'safe', 'on'=>'search'),
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
			'kiepasien' => array(self::BELONGS_TO, 'KiepasienT', 'kiepasien_id'),
			'listkie' => array(self::BELONGS_TO, 'ListkieM', 'listkie_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kiepasiendet_id' => 'Kiepasiendet',
			'kiepasien_id' => 'Kiepasien',
			'jeniskie' => 'Jeniskie',
			'listkie_id' => 'Listkie',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('kiepasiendet_id',$this->kiepasiendet_id);
		$criteria->compare('kiepasien_id',$this->kiepasien_id);
		$criteria->compare('jeniskie',$this->jeniskie,true);
		$criteria->compare('listkie_id',$this->listkie_id);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}