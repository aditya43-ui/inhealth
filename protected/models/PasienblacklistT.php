<?php

/**
 * This is the model class for table "pasienblacklist_t".
 *
 * The followings are the available columns in table 'pasienblacklist_t':
 * @property integer $pasienblacklist_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $pasienblacklist_no
 * @property string $pasienblacklist_tgl
 * @property string $pasienblacklist_karenakasus
 * @property string $pasienblacklist_ket
 * @property boolean $isblacklist
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pegawai
 */
class PasienblacklistT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienblacklistT the static model class
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
		return 'pasienblacklist_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasienblacklist_no, pasienblacklist_tgl, pasienblacklist_karenakasus, isblacklist, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('pasienblacklist_no', 'length', 'max'=>20),
			array('pasienblacklist_karenakasus', 'length', 'max'=>200),
			array('pasienblacklist_ket, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienblacklist_id, pendaftaran_id, pegawai_id, pasienblacklist_no, pasienblacklist_tgl, pasienblacklist_karenakasus, pasienblacklist_ket, isblacklist, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienblacklist_id' => 'Pasienblacklist',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'pasienblacklist_no' => 'Pasienblacklist No',
			'pasienblacklist_tgl' => 'Pasienblacklist Tgl',
			'pasienblacklist_karenakasus' => 'Pasienblacklist Karenakasus',
			'pasienblacklist_ket' => 'Pasienblacklist Ket',
			'isblacklist' => 'Isblacklist',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pasienblacklist_id',$this->pasienblacklist_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienblacklist_no',$this->pasienblacklist_no,true);
		$criteria->compare('pasienblacklist_tgl',$this->pasienblacklist_tgl,true);
		$criteria->compare('pasienblacklist_karenakasus',$this->pasienblacklist_karenakasus,true);
		$criteria->compare('pasienblacklist_ket',$this->pasienblacklist_ket,true);
		$criteria->compare('isblacklist',$this->isblacklist);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}