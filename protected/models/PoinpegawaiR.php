<?php

/**
 * This is the model class for table "poinpegawai_r".
 *
 * The followings are the available columns in table 'poinpegawai_r':
 * @property integer $poinpegawai_id
 * @property string $poinpegawai_alasan
 * @property string $poinpegawai_tgl
 * @property integer $pegawai_id
 * @property integer $pegpembuat_id
 * @property integer $poinpegawai_totpoin
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property PegawaiM $pegpembuat
 */
class PoinpegawaiR extends CActiveRecord
{
    public $nama_pegawai;
    public $pegpembuat_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PoinpegawaiR the static model class
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
		return 'poinpegawai_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('poinpegawai_alasan, poinpegawai_tgl, pegawai_id, pegpembuat_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pegpembuat_id, poinpegawai_totpoin, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('poinpegawai_id, poinpegawai_alasan, poinpegawai_tgl, pegawai_id, pegpembuat_id, poinpegawai_totpoin, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegpembuat' => array(self::BELONGS_TO, 'PegawaiM', 'pegpembuat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'poinpegawai_id' => 'ID',
			'poinpegawai_alasan' => 'Alasan',
			'poinpegawai_tgl' => 'Tanggal',
			'pegawai_id' => 'Pegawai',
			'pegpembuat_id' => 'Pencatat',
			'poinpegawai_totpoin' => 'Total Poin',
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

		$criteria->compare('poinpegawai_id',$this->poinpegawai_id);
		$criteria->compare('poinpegawai_alasan',$this->poinpegawai_alasan,true);
		$criteria->compare('poinpegawai_tgl',$this->poinpegawai_tgl,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegpembuat_id',$this->pegpembuat_id);
		$criteria->compare('poinpegawai_totpoin',$this->poinpegawai_totpoin);
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