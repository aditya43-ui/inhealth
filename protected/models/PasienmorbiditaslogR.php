<?php

/**
 * This is the model class for table "pasienmorbiditaslog_r".
 *
 * The followings are the available columns in table 'pasienmorbiditaslog_r':
 * @property integer $pasienmorbiditaslog_id
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $log_data
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 */
class PasienmorbiditaslogR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasienmorbiditaslog_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_loginpemakai_id, create_ruangan, pendaftaran_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('create_time, log_data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasienmorbiditaslog_id, create_time, create_loginpemakai_id, create_ruangan, log_data, pendaftaran_id, pasien_id', 'safe', 'on'=>'search'),
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
			'pasienmorbiditaslog_id' => 'Pasienmorbiditaslog',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'log_data' => 'Log Data',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
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

		$criteria->compare('pasienmorbiditaslog_id',$this->pasienmorbiditaslog_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('log_data',$this->log_data,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PasienmorbiditaslogR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
