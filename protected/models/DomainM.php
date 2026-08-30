<?php

/**
 * This is the model class for table "domain_m".
 *
 * The followings are the available columns in table 'domain_m':
 * @property integer $domain_i
 * @property string $terminologi
 * @property string $domain_kode
 * @property string $domain_kelas
 * @property string $domain_nama
 * @property string $domain_nama2
 * @property boolean $domain_aktif
 */
class DomainM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DomainM the static model class
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
		return 'domain_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terminologi, domain_kelas', 'length', 'max'=>100),
			array('domain_kode', 'length', 'max'=>10),
			array('domain_nama, domain_nama2', 'length', 'max'=>101),
			array('domain_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('domain_id, terminologi, domain_kode, domain_kelas, domain_nama, domain_nama2, domain_aktif', 'safe', 'on'=>'search'),
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
			'domain_id' => 'Domain ID',
			'terminologi' => 'Terminologi',
			'domain_kode' => 'Domain Kode',
			'domain_kelas' => 'Domain Kelas',
			'domain_nama' => 'Domain Nama',
			'domain_nama2' => 'Domain Lainya',
			'domain_aktif' => 'Domain Aktif',
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

		$criteria->compare('domain_id',$this->domain_id);
		$criteria->compare('terminologi',$this->terminologi,true);
		$criteria->compare('domain_kode',$this->domain_kode,true);
		$criteria->compare('domain_kelas',$this->domain_kelas,true);
		$criteria->compare('domain_nama',$this->domain_nama,true);
		$criteria->compare('domain_nama2',$this->domain_nama2,true);
		$criteria->compare('domain_aktif',$this->domain_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('domain_id',$this->domain_id);
		$criteria->compare('terminologi',$this->terminologi,true);
		$criteria->compare('domain_kode',$this->domain_kode,true);
		$criteria->compare('domain_kelas',$this->domain_kelas,true);
		$criteria->compare('domain_nama',$this->domain_nama,true);
		$criteria->compare('domain_nama2',$this->domain_nama2,true);
		$criteria->compare('domain_aktif',$this->domain_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}