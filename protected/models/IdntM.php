<?php

/**
 * This is the model class for table "idnt_m".
 *
 * The followings are the available columns in table 'idnt_m':
 * @property integer $idnt_id
 * @property integer $subkelas_id
 * @property integer $klasifikasisubkelas_id
 * @property string $idnt_kode
 * @property string $idnt_nama
 * @property boolean $idnt_aktif
 *
 * The followings are the available model relations:
 * @property SubkelasM $subkelas
 * @property KlasifikasisubkelasM $klasifikasisubkelas
 */
class IdntM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IdntM the static model class
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
		return 'idnt_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkelas_id, klasifikasisubkelas_id,klasifikasisubsubkelas_id', 'numerical', 'integerOnly'=>true),
			array('idnt_kode', 'length', 'max'=>10),
			array('idnt_nama', 'length', 'max'=>100),
			array('idnt_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idnt_id, subkelas_id, klasifikasisubkelas_id, idnt_kode, idnt_nama, idnt_aktif', 'safe', 'on'=>'search'),
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
			'klasifikasisubkelas' => array(self::BELONGS_TO, 'KlasifikasiSubkelasM', 'klasifikasisubkelas_id'),
			'klasifikasisubsubkelas' => array(self::BELONGS_TO, 'KlasifikasiSubsubkelasM', 'klasifikasisubsubkelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idnt_id' => 'Idnt',
			'subkelas_id' => 'Subkelas',
			'klasifikasisubkelas_id' => 'Klasifikasi sub kelas',
			'klasifikasisubsubkelas_id' => 'Klasifikasi sub sub kelas',
			'idnt_kode' => 'Idnt Kode',
			'idnt_nama' => 'Idnt Nama',
			'idnt_aktif' => 'Idnt Aktif',
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

		$criteria->compare('idnt_id',$this->idnt_id);
		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('klasifikasisubsubkelas_id',$this->klasifikasisubsubkelas_id);
		$criteria->compare('idnt_kode',$this->idnt_kode,true);
		$criteria->compare('idnt_nama',$this->idnt_nama,true);
		$criteria->compare('idnt_aktif',$this->idnt_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('idnt_id',$this->idnt_id);
		$criteria->compare('subkelas_id',$this->subkelas_id);
		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('klasifikasisubsubkelas_id',$this->klasifikasisubsubkelas_id);
		$criteria->compare('idnt_kode',$this->idnt_kode,true);
		$criteria->compare('idnt_nama',$this->idnt_nama,true);
		$criteria->compare('idnt_aktif',$this->idnt_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}