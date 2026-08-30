<?php

/**
 * This is the model class for table "rencanakontrol_r".
 *
 * The followings are the available columns in table 'rencanakontrol_r':
 * @property integer $rencanakontrol_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienpulang_id
 * @property integer $pasien_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property integer $polikontrol_id
 * @property string $rencanapulang_tgl
 * @property string $rencanakontrol_tgl
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_logipemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RencanakontrolR extends CActiveRecord
{
        public $iskontrol;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanakontrolR the static model class
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
		return 'rencanakontrol_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, instalasi_id, ruangan_id, polikontrol_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasienpulang_id, pasien_id, instalasi_id, ruangan_id, polikontrol_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('rencanapulang_tgl, rencanakontrol_tgl, keterangan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanakontrol_id, pendaftaran_id, pasienadmisi_id, pasienpulang_id, pasien_id, instalasi_id, ruangan_id, polikontrol_id, rencanapulang_tgl, rencanakontrol_tgl, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'rencanakontrol_id' => 'Rencanakontrol',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienpulang_id' => 'Pasienpulang',
			'pasien_id' => 'Pasien',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'polikontrol_id' => 'Poli Kontrol',
			'rencanapulang_tgl' => 'Tanggal Rencana Pulang',
			'rencanakontrol_tgl' => 'Tanggal Kontrol',
			'keterangan' => 'Kembali Ke IGD bila terjadi :',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Logipemakai',
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

		$criteria->compare('rencanakontrol_id',$this->rencanakontrol_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('polikontrol_id',$this->polikontrol_id);
		$criteria->compare('rencanapulang_tgl',$this->rencanapulang_tgl,true);
		$criteria->compare('rencanakontrol_tgl',$this->rencanakontrol_tgl,true);
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