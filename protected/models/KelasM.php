<?php

/**
 * This is the model class for table "kelas_m".
 *
 * The followings are the available columns in table 'kelas_m':
 * @property integer $kelas_id
 * @property integer $domain_id
 * @property string $kelas_kode
 * @property string $kelas_noterperinci
 * @property string $kelas_nama
 * @property string $kelas_nama2
 * @property boolean $kelas_aktif
 */
class KelasM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelasM the static model class
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
		return 'kelas_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain_id', 'numerical', 'integerOnly'=>true),
			array('kelas_kode', 'length', 'max'=>10),
			array('kelas_noterperinci, kelas_nama', 'length', 'max'=>100),
			array('kelas_nama2', 'length', 'max'=>101),
			array('kelas_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelas_id, domain_id, kelas_kode, kelas_noterperinci, kelas_nama, kelas_nama2, kelas_aktif', 'safe', 'on'=>'search'),
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
			'domain'=>array(self::BELONGS_TO,'DomainM','domain_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelas_id' => 'Kelas',
			'domain_id' => 'Domain',
			'kelas_kode' => 'Kelas Kode',
			'kelas_noterperinci' => 'Kelas Noterperinci',
			'kelas_nama' => 'Kelas Nama',
			'kelas_nama2' => 'Kelas Nama2',
			'kelas_aktif' => 'Kelas Aktif',
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

		$criteria->compare('kelas_id',$this->kelas_id);
		$criteria->compare('domain_id',$this->domain_id);
		$criteria->compare('kelas_kode',$this->kelas_kode,true);
		$criteria->compare('kelas_noterperinci',$this->kelas_noterperinci,true);
		$criteria->compare('kelas_nama',$this->kelas_nama,true);
		$criteria->compare('kelas_nama2',$this->kelas_nama2,true);
		$criteria->compare('kelas_aktif',$this->kelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelas_id',$this->kelas_id);
		$criteria->compare('domain_id',$this->domain_id);
		$criteria->compare('kelas_kode',$this->kelas_kode,true);
		$criteria->compare('kelas_noterperinci',$this->kelas_noterperinci,true);
		$criteria->compare('kelas_nama',$this->kelas_nama,true);
		$criteria->compare('kelas_nama2',$this->kelas_nama2,true);
		$criteria->compare('kelas_aktif',$this->kelas_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}