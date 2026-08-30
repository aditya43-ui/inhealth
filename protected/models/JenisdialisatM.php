<?php

/**
 * This is the model class for table "jenisdialisat_m".
 *
 * The followings are the available columns in table 'jenisdialisat_m':
 * @property integer $jenisdialisat_id
 * @property string $jenisdialisat_nama
 * @property string $jenisdialisat_namalain
 * @property string $jenisdialisat_deskripsi
 * @property boolean $jenisdialisat_aktif
 */
class JenisdialisatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisdialisatM the static model class
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
		return 'jenisdialisat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdialisat_nama, jenisdialisat_namalain, jenisdialisat_aktif', 'required'),
			array('jenisdialisat_nama, jenisdialisat_namalain', 'length', 'max'=>100),
			array('jenisdialisat_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisdialisat_id, jenisdialisat_nama, jenisdialisat_namalain, jenisdialisat_deskripsi, jenisdialisat_aktif', 'safe', 'on'=>'search'),
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
			'jenisdialisat_id' => 'Jenis Dialisat',
			'jenisdialisat_nama' => 'Nama Jenis Dialisat',
			'jenisdialisat_namalain' => 'Nama Lain Jenis Dialisat ',
			'jenisdialisat_deskripsi' => 'Deskripsi Jenis Dialisat ',
			'jenisdialisat_aktif' => 'Jenis Dialisat Aktif',
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

		$criteria->compare('jenisdialisat_id',$this->jenisdialisat_id);
		$criteria->compare('jenisdialisat_nama',$this->jenisdialisat_nama,true);
		$criteria->compare('jenisdialisat_namalain',$this->jenisdialisat_namalain,true);
		$criteria->compare('jenisdialisat_deskripsi',$this->jenisdialisat_deskripsi,true);
		$criteria->compare('jenisdialisat_aktif',$this->jenisdialisat_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}