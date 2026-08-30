<?php

/**
 * This is the model class for table "invkalibrasidet_t".
 *
 * The followings are the available columns in table 'invkalibrasidet_t':
 * @property integer $invkalibrasidet_id
 * @property integer $invkalibrasi_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property InvkalibarasiT $invkalibrasi
 */
class InvkalibrasidetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvkalibrasidetT the static model class
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
		return 'invkalibrasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_pegawai', 'required'),
			array('invkalibrasi_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nama_pegawai', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invkalibrasidet_id, invkalibrasi_id, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'invkalibrasi' => array(self::BELONGS_TO, 'InvkalibarasiT', 'invkalibrasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invkalibrasidet_id' => 'Invkalibrasidet',
			'invkalibrasi_id' => 'Invkalibrasi',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
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

		$criteria->compare('invkalibrasidet_id',$this->invkalibrasidet_id);
		$criteria->compare('invkalibrasi_id',$this->invkalibrasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}