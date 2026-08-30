<?php

/**
 * This is the model class for table "jenisform_m".
 *
 * The followings are the available columns in table 'jenisform_m':
 * @property integer $jenisform_id
 * @property string $jenisform_nama
 * @property string $jenisform_namalainnya
 * @property string $jenisform_kelompok
 * @property string $jenisform_aktif
 * 
 */
class JenisformM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenisform_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisform_nama,jenisform_kelompok', 'required'),
			array('jenisform_id', 'numerical', 'integerOnly'=>true),
			array('jenisform_nama,jenisform_namalainnya,jenisform_kelompok', 'length', 'max'=>255),
		
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenisform_id, jenisform_nama, jenisform_namalainnya, jenisform_kelompok, jenisform_aktif ', 'safe', 'on'=>'search'),
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
			'jenisform_id' => 'Jenis Form',
			'jenisform_nama' => 'Nama Jenis Form',
			'jenisform_namalainnya'=>'Nama Jenis Form Lainnya',
			'jenisform_kelompok'=>'Kelompok',
			'jenisform_aktif'=>'Jenis Form Aktif',
			
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisform_id',$this->jenisform_id);
		$criteria->compare('jenisform_nama',$this->jenisform_nama,true);
		$criteria->compare('jenisform_namalainnya',$this->jenisform_namalainnya,true);
		$criteria->compare('jenisform_kelompok',$this->jenisform_kelompok,true);
     	$criteria->compare('jenisform_aktif',isset($this->jenisform_aktif)?$this->jenisform_aktif:true);
	

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenisformM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
