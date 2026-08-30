<?php

/**
 * This is the model class for table "eresep_t".
 *
 * The followings are the available columns in table 'eresep_t':
 * @property integer $eresep_id
 * @property integer $reseptur_id
 * @property string $eresep_image
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $create_iphost
 */
class EresepT extends CActiveRecord
{
        public $eresep_text;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EresepT the static model class
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
		return 'eresep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eresep_image, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('reseptur_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('create_iphost', 'length', 'max'=>20),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eresep_id, reseptur_id, eresep_image, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, create_iphost', 'safe', 'on'=>'search'),
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
			'eresep_id' => 'Eresep',
			'reseptur_id' => 'Reseptur',
			'eresep_image' => 'Eresep Image',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_iphost' => 'Create Iphost',
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

		$criteria->compare('eresep_id',$this->eresep_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('eresep_image',$this->eresep_image,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_iphost',$this->create_iphost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}