<?php

/**
 * This is the model class for table "klasifikasisubsubkelas_m".
 *
 * The followings are the available columns in table 'klasifikasisubsubkelas_m':
 * @property integer $klasifikasisubsubkelas_id
 * @property integer $klasifikasisubkelas_id
 * @property string $klasifikasisubsubkelas_kode
 * @property string $klasifikasisubsubkelas_nama
 * @property string $klasifikasisubsubkelas_nama2
 * @property boolean $klasifikasisubsubkelas_aktif
 */
class KlasifikasiSubsubkelasM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasisubsubkelasM the static model class
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
		return 'klasifikasisubsubkelas_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('klasifikasisubkelas_id', 'numerical', 'integerOnly'=>true),
			array('klasifikasisubsubkelas_kode', 'length', 'max'=>10),
			array('klasifikasisubsubkelas_nama, klasifikasisubsubkelas_nama2', 'length', 'max'=>100),
			array('klasifikasisubsubkelas_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasisubsubkelas_id, klasifikasisubkelas_id, klasifikasisubsubkelas_kode, klasifikasisubsubkelas_nama, klasifikasisubsubkelas_nama2, klasifikasisubsubkelas_aktif', 'safe', 'on'=>'search'),
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
			'klasifikasisubkelas' => array(self::BELONGS_TO, 'KlasifikasiSubkelasM', 'klasifikasisubkelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'klasifikasisubsubkelas_id' => 'Klasifikasisubsubkelas',
			'klasifikasisubkelas_id' => 'Klasifikasi sub kelas',
			'klasifikasisubsubkelas_kode' => 'Kode Klasifikasi',
			'klasifikasisubsubkelas_nama' => 'Nama Klasifikasi',
			'klasifikasisubsubkelas_nama2' => 'Nama Lainya',
			'klasifikasisubsubkelas_aktif' => 'Aktif',
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

		$criteria->compare('klasifikasisubsubkelas_id',$this->klasifikasisubsubkelas_id);
		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('klasifikasisubsubkelas_kode',$this->klasifikasisubsubkelas_kode,true);
		$criteria->compare('klasifikasisubsubkelas_nama',$this->klasifikasisubsubkelas_nama,true);
		$criteria->compare('klasifikasisubsubkelas_nama2',$this->klasifikasisubsubkelas_nama2,true);
		$criteria->compare('klasifikasisubsubkelas_aktif',$this->klasifikasisubsubkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('klasifikasisubsubkelas_id',$this->klasifikasisubsubkelas_id);
		$criteria->compare('klasifikasisubkelas_id',$this->klasifikasisubkelas_id);
		$criteria->compare('klasifikasisubsubkelas_kode',$this->klasifikasisubsubkelas_kode,true);
		$criteria->compare('klasifikasisubsubkelas_nama',$this->klasifikasisubsubkelas_nama,true);
		$criteria->compare('klasifikasisubsubkelas_nama2',$this->klasifikasisubsubkelas_nama2,true);
		$criteria->compare('klasifikasisubsubkelas_aktif',$this->klasifikasisubsubkelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}