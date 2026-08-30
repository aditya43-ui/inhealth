<?php

/**
 * This is the model class for table "gedung_m".
 *
 * The followings are the available columns in table 'gedung_m':
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property boolean $gedung_aktif
 * @property integer $invgedung_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property InvgedungT $invgedung
 * @property RuanganM[] $ruanganMs
 */
class GedungM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GedungM the static model class
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
		return 'gedung_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gedung_kode, gedung_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('invgedung_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('gedung_nama', 'length', 'max'=>100),
			array('gedung_kode, gedung_aktif, update_time', 'safe'),
                        ['gedung_kode','unique'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gedung_id, gedung_nama, gedung_aktif, invgedung_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invgedung' => array(self::BELONGS_TO, 'InvgedungT', 'invgedung_id'),
			'ruanganMs' => array(self::HAS_MANY, 'RuanganM', 'gedung_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gedung_id' => 'ID',
			'gedung_nama' => 'Nama Gedung',
                        'gedung_kode' => 'Kode Gedung',
			'gedung_aktif' => 'Gedung Aktif',
			'invgedung_id' => 'Invgedung',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('gedung_id',$this->gedung_id);
		$criteria->compare('LOWER(gedung_nama)', strtolower($this->gedung_nama),true);
                $criteria->compare('LOWER(gedung_kode)', strtolower($this->gedung_kode),true);                
		$criteria->compare('gedung_aktif',isset($this->gedung_aktif)?$this->gedung_aktif:true);
		$criteria->compare('invgedung_id',$this->invgedung_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}