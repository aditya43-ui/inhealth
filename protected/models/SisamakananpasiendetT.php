<?php

/**
 * This is the model class for table "sisamakananpasiendet_t".
 *
 * The followings are the available columns in table 'sisamakananpasiendet_t':
 * @property integer $sisamakananpasiendet_id
 * @property integer $sisamakananpasien_id
 * @property integer $jenismakanan_id
 * @property integer $persensisamakanan_id
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SisamakananpasienT $sisamakananpasien
 * @property JenismakananM $jenismakanan
 * @property PersensisamakananM $persensisamakanan
 */
class SisamakananpasiendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SisamakananpasiendetT the static model class
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
		return 'sisamakananpasiendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sisamakananpasien_id, create_time, create_loginpemakai_id', 'required'),
			array('sisamakananpasien_id, jenismakanan_id, persensisamakanan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sisamakananpasiendet_id, sisamakananpasien_id, jenismakanan_id, persensisamakanan_id, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sisamakananpasien' => array(self::BELONGS_TO, 'SisamakananpasienT', 'sisamakananpasien_id'),
			'jenismakanan' => array(self::BELONGS_TO, 'JenismakananM', 'jenismakanan_id'),
			'persensisamakanan' => array(self::BELONGS_TO, 'PersensisamakananM', 'persensisamakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sisamakananpasiendet_id' => 'Sisamakananpasiendet',
			'sisamakananpasien_id' => 'Sisamakananpasien',
			'jenismakanan_id' => 'Jenismakanan',
			'persensisamakanan_id' => '% Sisa Makanan',
			'keterangan' => 'Keterangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('sisamakananpasiendet_id',$this->sisamakananpasiendet_id);
		$criteria->compare('sisamakananpasien_id',$this->sisamakananpasien_id);
		$criteria->compare('jenismakanan_id',$this->jenismakanan_id);
		$criteria->compare('persensisamakanan_id',$this->persensisamakanan_id);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}