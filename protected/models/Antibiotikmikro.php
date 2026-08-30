<?php

/**
 * This is the model class for table "antibiotikmikro_m".
 *
 * The followings are the available columns in table 'antibiotikmikro_m':
 * @property integer $antibiotikmikro_id
 * @property string $antibiotikmikro_nama
 * @property string $antibiotikmikro_namalain
 * @property string $antibiotikmikro_kode
 * @property string $antibiotikmikro_urutan
 * @property boolean $antibiotikmikro_aktif
 */
class Antibiotikmikro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'antibiotikmikro_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('antibiotikmikro_nama, antibiotikmikro_jenis', 'required'),
			array('antibiotikmikro_nama, antibiotikmikro_jenis', 'length', 'max'=>100),
			array('antibiotikmikro_kode, antibiotikmikro_urutan', 'length', 'max'=>20),
			array('antibiotikmikro_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('antibiotikmikro_id, antibiotikmikro_nama, antibiotikmikro_jenis, antibiotikmikro_kode, antibiotikmikro_urutan, antibiotikmikro_aktif', 'safe', 'on'=>'search'),
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
			'antibiotikmikro_id' => 'Antibiotik Mikro',
			'antibiotikmikro_nama' => 'Nama Antibiotik',
			'antibiotikmikro_jenis' => 'Jenis Antibiotik',
			'antibiotikmikro_kode' => 'Kode',
			'antibiotikmikro_urutan' => 'Urutan',
			'antibiotikmikro_aktif' => 'Aktif',
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

		$criteria->compare('antibiotikmikro_id',$this->antibiotikmikro_id);
		$criteria->compare('antibiotikmikro_nama',$this->antibiotikmikro_nama,true);
		$criteria->compare('antibiotikmikro_jenis',$this->antibiotikmikro_jenis,true);
		$criteria->compare('antibiotikmikro_kode',$this->antibiotikmikro_kode,true);
		$criteria->compare('antibiotikmikro_urutan',$this->antibiotikmikro_urutan,true);
		$criteria->compare('antibiotikmikro_aktif',$this->antibiotikmikro_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntibiotikmikroM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
