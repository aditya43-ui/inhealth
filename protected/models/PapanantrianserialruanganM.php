<?php

/**
 * This is the model class for table "papanantrianserialruangan_m".
 *
 * The followings are the available columns in table 'papanantrianserialruangan_m':
 * @property integer $papanantrianserialruangan_id
 * @property integer $ruangan_id
 * @property string $ip_address
 * @property string $ip_port
 * @property string $serial_port
 * @property string $serial_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PapanantrianserialruanganM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PapanantrianserialruanganM the static model class
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
		return 'papanantrianserialruangan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, ip_address', 'required'),
			array('ruangan_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('ip_address, serial_port, serial_id, poliklinik_nama', 'length', 'max'=>100),
			array('ip_port', 'length', 'max'=>10),
			array('create_time, update_time, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('papanantrianserialruangan_id, ruangan_id, ip_address, ip_port, serial_port, serial_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, poliklinik_nama', 'safe', 'on'=>'search'),
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
			'papanantrianserialruangan_id' => 'Papanantrianserialruangan',
			'ruangan_id' => 'Ruangan',
			'ip_address' => 'IP Address',
			'ip_port' => 'IP Port',
			'serial_port' => 'Serial Port',
			'serial_id' => 'Serial',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'poliklinik_nama' => 'Poliklinik',
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

		$criteria->compare('papanantrianserialruangan_id',$this->papanantrianserialruangan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('ip_port',$this->ip_port,true);
		$criteria->compare('serial_port',$this->serial_port,true);
		$criteria->compare('serial_id',$this->serial_id,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('papanantrianserialruangan_id',$this->papanantrianserialruangan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('ip_port',$this->ip_port,true);
		$criteria->compare('serial_port',$this->serial_port,true);
		$criteria->compare('serial_id',$this->serial_id,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}