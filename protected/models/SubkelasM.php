<?php

/**
 * This is the model class for table "subkelas_m".
 *
 * The followings are the available columns in table 'subkelas_m':
 * @property integer $subkelas_id
 * @property integer $kelas_id
 * @property string $subkelas_kode
 * @property string $subkelas_noterperinci
 * @property string $subkelas_nama
 * @property string $subkelas_nama2
 * @property boolean $subkelas_aktif
 *
 * The followings are the available model relations:
 * @property IdntM[] $idntMs
 */
class SubkelasM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubkelasM the static model class
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
		return 'subkelas_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelas_id', 'numerical', 'integerOnly'=>true),
			array('subkelas_kode', 'length', 'max'=>10),
			array('subkelas_noterperinci, subkelas_nama', 'length', 'max'=>100),
			array('subkelas_nama2', 'length', 'max'=>101),
			array('subkelas_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subkelas_id, kelas_id, subkelas_kode, subkelas_noterperinci, subkelas_nama, subkelas_nama2, subkelas_aktif', 'safe', 'on'=>'search'),
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
			'kelas' => array(self::BELONGS_TO, 'KelasM', 'kelas_id'),
			// 'idnt' => array(self::BELONGS_TO, 'Idnt', 'subkelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subkelas_id' => 'Sub Kelas',
			'kelas_id' => 'Kelas',
			'subkelas_kode' => 'Sub Kelas Kode',
			'subkelas_noterperinci' => 'Sub Kelas No terperinci',
			'subkelas_nama' => 'Sub kelas Nama',
			'subkelas_nama2' => 'Sub kelas Nama Lainya',
			'subkelas_aktif' => 'Sub kelas Aktif',
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

		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('kelas_id',$this->kelas_id);
		$criteria->compare('subkelas_kode',$this->subkelas_kode,true);
		$criteria->compare('subkelas_noterperinci',$this->subkelas_noterperinci,true);
		$criteria->compare('subkelas_nama',$this->subkelas_nama,true);
		$criteria->compare('subkelas_nama2',$this->subkelas_nama2,true);
		$criteria->compare('subkelas_aktif',$this->subkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('kelas_id',$this->kelas_id);
		$criteria->compare('subkelas_kode',$this->subkelas_kode,true);
		$criteria->compare('subkelas_noterperinci',$this->subkelas_noterperinci,true);
		$criteria->compare('subkelas_nama',$this->subkelas_nama,true);
		$criteria->compare('subkelas_nama2',$this->subkelas_nama2,true);
		$criteria->compare('subkelas_aktif',$this->subkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}