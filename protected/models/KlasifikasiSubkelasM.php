<?php

/**
 * This is the model class for table "klasifikasisubkelas_m".
 *
 * The followings are the available columns in table 'klasifikasisubkelas_m':
 * @property integer $klasifikasisubkelas_id
 * @property integer $subkelas_id
 * @property string $klasifikasisubkelas_kode
 * @property string $klasifikasisubkelas_noterperinci
 * @property string $klasifikasisubkelas_nama
 * @property string $klasifikasisubkelas_nama2
 * @property boolean $klasifikasisubkelas_aktif
 *
 * The followings are the available model relations:
 * @property IdntM[] $idntMs
 */
class KlasifikasiSubkelasM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasisubkelasM the static model class
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
		return 'klasifikasisubkelas_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkelas_id', 'numerical', 'integerOnly'=>true),
			array('klasifikasisubkelas_kode', 'length', 'max'=>10),
			array('klasifikasisubkelas_noterperinci, klasifikasisubkelas_nama', 'length', 'max'=>100),
			array('klasifikasisubkelas_nama2', 'length', 'max'=>101),
			array('klasifikasisubkelas_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasisubkelas_id, subkelas_id, klasifikasisubkelas_kode, klasifikasisubkelas_noterperinci, klasifikasisubkelas_nama, klasifikasisubkelas_nama2, klasifikasisubkelas_aktif', 'safe', 'on'=>'search'),
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
			'subkelas' => array(self::BELONGS_TO, 'SubkelasM', 'subkelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'klasifikasisubkelas_id' => 'Klasifikasi subkelas',
			'subkelas_id' => 'Subkelas',
			'klasifikasisubkelas_kode' => 'Klasifikasi subkelas Kode',
			'klasifikasisubkelas_noterperinci' => 'Klasifikasi subkelas No terperinci',
			'klasifikasisubkelas_nama' => 'Klasifikasi subkelas Nama',
			'klasifikasisubkelas_nama2' => 'Klasifikasi subkelas Nama Lainya',
			'klasifikasisubkelas_aktif' => 'Klasifikasi subkelas Aktif',
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

		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('klasifikasisubkelas_kode',$this->klasifikasisubkelas_kode,true);
		$criteria->compare('klasifikasisubkelas_noterperinci',$this->klasifikasisubkelas_noterperinci,true);
		$criteria->compare('klasifikasisubkelas_nama',$this->klasifikasisubkelas_nama,true);
		$criteria->compare('klasifikasisubkelas_nama2',$this->klasifikasisubkelas_nama2,true);
		$criteria->compare('klasifikasisubkelas_aktif',$this->klasifikasisubkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('klasifikasisubkelas_kode',$this->klasifikasisubkelas_kode,true);
		$criteria->compare('klasifikasisubkelas_noterperinci',$this->klasifikasisubkelas_noterperinci,true);
		$criteria->compare('klasifikasisubkelas_nama',$this->klasifikasisubkelas_nama,true);
		$criteria->compare('klasifikasisubkelas_nama2',$this->klasifikasisubkelas_nama2,true);
		$criteria->compare('klasifikasisubkelas_aktif',$this->klasifikasisubkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}