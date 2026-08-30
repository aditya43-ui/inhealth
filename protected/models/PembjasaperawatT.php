<?php

/**
 * This is the model class for table "pembjasaperawat_t".
 *
 * The followings are the available columns in table 'pembjasaperawat_t':
 * @property integer $pembjasaperawat_id
 * @property integer $pembayaranjasa_id
 * @property integer $pegawai_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PembayaranjasaT $pembayaranjasa
 */
class PembjasaperawatT extends CActiveRecord
{
	public $kelompokpegawai_nama;
	public $jabatan_nama;
	public $nama_pegawai;
	public $lookup_name;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembjasaperawatT the static model class
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
		return 'pembjasaperawat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranjasa_id, pegawai_id', 'required'),
			array('pembayaranjasa_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembjasaperawat_id, pembayaranjasa_id, pegawai_id', 'safe', 'on'=>'search'),
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
			'pembayaranjasa' => array(self::BELONGS_TO, 'PembayaranjasaT', 'pembayaranjasa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembjasaperawat_id' => 'Pembjasaperawat',
			'pembayaranjasa_id' => 'Pembayaranjasa',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('pembjasaperawat_id',$this->pembjasaperawat_id);
		$criteria->compare('pembayaranjasa_id',$this->pembayaranjasa_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}