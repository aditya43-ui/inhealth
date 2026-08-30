<?php

/**
 * This is the model class for table "jenismakanan_m".
 *
 * The followings are the available columns in table 'jenismakanan_m':
 * @property integer $jenismakanan_id
 * @property integer $jeniswaktu_id
 * @property string $jenismakanan_nama
 * @property string $jenismakanan_namalainnya
 * @property integer $urutan
 * @property boolean $jenismakanan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property JeniswaktuM $jeniswaktu
 */
class JenismakananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenismakananM the static model class
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
		return 'jenismakanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniswaktu_id, jenismakanan_nama, urutan, create_time, create_loginpemakai_id', 'required'),
			array('jeniswaktu_id, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jenismakanan_nama, jenismakanan_namalainnya', 'length', 'max'=>255),
			array('jenismakanan_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenismakanan_id, jeniswaktu_id, jenismakanan_nama, jenismakanan_namalainnya, urutan, jenismakanan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jeniswaktu' => array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenismakanan_id' => 'Jenismakanan',
			'jeniswaktu_id' => 'Jenis Waktu Makan',
			'jenismakanan_nama' => 'Nama Jenis Makanan',
			'jenismakanan_namalainnya' => 'Nama Lain',
			'urutan' => 'Urutan',
			'jenismakanan_aktif' => 'Status',
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

		$criteria->compare('jenismakanan_id',$this->jenismakanan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jenismakanan_nama',$this->jenismakanan_nama,true);
		$criteria->compare('jenismakanan_namalainnya',$this->jenismakanan_namalainnya,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('jenismakanan_aktif',$this->jenismakanan_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenismakanan_id',$this->jenismakanan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jenismakanan_nama',$this->jenismakanan_nama,true);
		$criteria->compare('jenismakanan_namalainnya',$this->jenismakanan_namalainnya,true);
		$criteria->compare('urutan',$this->urutan);
		// $criteria->compare('jenismakanan_aktif',isset($this->jenismakanan_aktif)?$this->jenismakanan_aktif:true);
		// $criteria->compare('jenismakanan_aktif', isset($this->jenismakanan_aktif) ? $this->jenismakanan_aktif : true);
		// $criteria->compare('create_time',$this->create_time,true);
		// $criteria->compare('update_time',$this->update_time,true);
		// $criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		// $criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		// $criteria->compare('create_ruangan',$this->create_ruangan);
			// $criteria->addCondition('jenismakanan_aktif is true');
			$criteria->order="jenismakanan_nama ASC";
			$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}