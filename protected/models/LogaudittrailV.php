<?php

/**
 * This is the model class for table "logaudittrail_v".
 *
 * The followings are the available columns in table 'logaudittrail_v':
 * @property integer $id_log
 * @property string $jenislog
 * @property string $keterangan_log
 * @property string $tgl_log
 * @property string $loginpemakai_id
 * @property string $nama_pemakai
 * @property string $nama_pegawai
 * @property string $ruangan_nama
 */
class LogaudittrailV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogaudittrailV the static model class
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
		return 'logaudittrail_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_log', 'numerical', 'integerOnly'=>true),
			array('nama_pemakai', 'length', 'max'=>20),
			array('nama_pegawai', 'length', 'max'=>50),
			array('jenislog, keterangan_log, tgl_log, loginpemakai_id, ruangan_nama', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_log, jenislog, keterangan_log, tgl_log, loginpemakai_id, nama_pemakai, nama_pegawai, ruangan_nama', 'safe', 'on'=>'search'),
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
			'id_log' => 'Id Log',
			'jenislog' => 'Jenislog',
			'keterangan_log' => 'Keterangan Log',
			'tgl_log' => 'Tgl. Log',
			'loginpemakai_id' => 'Loginpemakai',
			'nama_pemakai' => 'Nama Pemakai',
			'nama_pegawai' => 'Nama Pegawai',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('id_log',$this->id_log);
		$criteria->compare('jenislog',$this->jenislog,true);
		$criteria->compare('keterangan_log',$this->keterangan_log,true);
		$criteria->compare('tgl_log',$this->tgl_log,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id,true);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}