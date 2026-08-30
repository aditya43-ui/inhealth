<?php

/**
 * This is the model class for table "konfigkoperasi_k".
 *
 * The followings are the available columns in table 'konfigkoperasi_k':
 * @property integer $konfigkoperasi_id
 * @property integer $persjasasimpanan
 * @property integer $persjasapinjaman
 * @property integer $persdanapengurus
 * @property integer $persdanakaryawan
 * @property integer $persdanapendidikan
 * @property integer $persdanasosial
 * @property integer $persdanacadangan
 * @property integer $persbiayaprovisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property integer $pimpinankoperasi_id
 * @property integer $penguruskoperasi_id
 * @property integer $bendaharakoperasi_id
 * @property integer $bendaharars_id
 * @property boolean $isberlaku
 */
class KonfigkoperasiK extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	//public $nama_pegawai,$nama_pegawai2,$gelardepan,$gelarbelakang;
	public $pimpinan_nama,$pengurus_nama,$bendahara_nama,$bendahara_rs_nama;
	public function tableName()
	{
		return 'konfigkoperasi_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id', 'required'),
			array('konfigkoperasi_id, bendaharakoperasi_id, bendaharars_id, pimpinankoperasi_id, penguruskoperasi_id', 'numerical', 'integerOnly'=>true),
			array('persbiayaprovisasi, persjasasimpanan, persjasapinjaman, persdanapengurus, persdanakaryawan, persdanapendidikan, persdanasosial, persdanacadangan, persjasadeposito, persbiayaprovisasi', 'numerical'),
			array('create_loginpemakai_id, update_loginpemakai_id', 'length', 'max'=>100),
			array('update_time, isberlaku', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('konfigkoperasi_id, bendahara_id, persbiayaprovisasi, persjasasimpanan, persjasapinjaman, persdanapengurus, persdanakaryawan, persdanapendidikan, persdanasosial, persdanacadangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, pimpinankoperasi_id, penguruskoperasi_id, isberlaku', 'safe', 'on'=>'search'),
			
			array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
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
				'pimpinan'=>array(self::BELONGS_TO,'PegawaiM','pimpinankoperasi_id'),
				'pengurus'=>array(self::BELONGS_TO,'PegawaiM','penguruskoperasi_id'),
				'bendahara'=>array(self::BELONGS_TO,'PegawaiM','bendaharakoperasi_id'),
				'bendahara_rs'=>array(self::BELONGS_TO,'PegawaiM','bendaharars_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konfigkoperasi_id' => 'ID',
			'persjasasimpanan' => 'Jasa Simpanan (%)',
			'persjasapinjaman' => 'Jasa Pinjaman (%)',
			'persdanapengurus' => 'Dana Pengurus (%)',
			'persdanakaryawan' => 'Dana Karyawan (%)',
			'persdanapendidikan' => 'Dana Pendidikan (%)',
			'persdanasosial' => 'Dana Sosial (%)',
			'persdanacadangan' => 'Dana Cadangan (%)',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login',
			'update_loginpemakai_id' => 'Update Login',
			'pimpinankoperasi_id' => 'Pimpian Koperasi',
			'penguruskoperasi_id' => 'Pengurus Koperasi',
			// 'isberlaku' => 'Berlaku',
			'persbiayaprovisasi' => 'Biaya Provisasi (%)',
			'bendaharakoperasi_id' => 'Bendahara Koperasi',
			'bendaharars_id' => 'Bendahara Rumah Sakit',
  			'persjasadeposito' => 'Jasa Deposito (%)',
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
		$criteria->with=array('pimpinan','pengurus','bendahara', 'bendahara_rs');
		$criteria->compare('LOWER(pimpinan.nama_pegawai)',strtolower($this->pimpinan),true);
		$criteria->compare('LOWER(pengurus.nama_pegawai)',strtolower($this->pengurus),true);
		$criteria->compare('LOWER(bendahara.nama_pegawai)',strtolower($this->bendahara),true);
		$criteria->compare('LOWER(bendahara_rs.nama_pegawai)',strtolower($this->bendahara_rs),true);
		$criteria->compare('t.konfigkoperasi_id',$this->konfigkoperasi_id);
		$criteria->compare('t.persjasasimpanan',$this->persjasasimpanan);
		$criteria->compare('t.persjasapinjaman',$this->persjasapinjaman);
		$criteria->compare('t.persdanapengurus',$this->persdanapengurus);
		$criteria->compare('t.persdanakaryawan',$this->persdanakaryawan);
		$criteria->compare('t.persdanapendidikan',$this->persdanapendidikan);
		$criteria->compare('t.persdanasosial',$this->persdanasosial);
		$criteria->compare('t.persdanacadangan',$this->persdanacadangan);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.pimpinankoperasi_id',$this->pimpinankoperasi_id);
		$criteria->compare('t.penguruskoperasi_id',$this->penguruskoperasi_id);
		// $criteria->compare('t.isberlaku',$this->isberlaku);
		$criteria->compare('t.persbiayaprovisasi',$this->persbiayaprovisasi);
		$criteria->compare('t.bendaharars_id',$this->bendaharars_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KonfigkoperasiK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
