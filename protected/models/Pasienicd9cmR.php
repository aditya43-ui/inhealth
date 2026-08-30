<?php

/**
 * This is the model class for table "pasienicd9cm_r".
 *
 * The followings are the available columns in table 'pasienicd9cm_r':
 * @property integer $pasienicd9cm_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $diagnosaicdix_id
 * @property integer $pasienmorbiditas_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property integer $kelompokdiagnosa_id
 * @property integer $pegawai_id
 * @property string $tglpasienicd9cm
 * @property string $keterangan
 * @property integer $riwayatpasienicd9cm_id
 * @property boolean $is_verifikasidiagnosa
 * @property integer $created_by
 */
class Pasienicd9cmR extends CActiveRecord
{
	public $tglmorbiditas, $pegawai_id, $ruangan_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pasienicd9cm_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienicd9cm_id, pendaftaran_id, diagnosaicdix_id, pasienmorbiditas_id, create_time, create_loginpemakai_id, create_ruangan_id', 'required'),
			array('pasienadmisi_id, pendaftaran_id, diagnosaicdix_id, pasienmorbiditas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, kelompokdiagnosa_id, pegawai_id, created_by', 'numerical', 'integerOnly'=>true),
			array('update_time, tglpasienicd9cm, keterangan, is_verifikasidiagnosa', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('riwayatpasienicd9cm_id, pasienicd9cm_id, pasienadmisi_id, pendaftaran_id, diagnosaicdix_id, pasienmorbiditas_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, kelompokdiagnosa_id, pegawai_id, tglpasienicd9cm, keterangan, riwayatpasienicd9cm_id, is_verifikasidiagnosa, created_by', 'safe', 'on'=>'search'),
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
			'diagnosatindakan'=>array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'kelompokdiagnosa'=>array(self::BELONGS_TO,  'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
			'pegawai'=>array(self::BELONGS_TO,  'PegawaiM', 'pegawai_id'),
			'ruangan'=>array(self::BELONGS_TO,  'RuanganM', 'create_ruangan_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienicd9cm_id' => 'Pasienicd9cm',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'pegawai_id' => 'Pegawai',
			'tglpasienicd9cm' => 'Tglpasienicd9cm',
			'keterangan' => 'Keterangan',
			'riwayatpasienicd9cm_id' => 'Riwayatpasienicd9cm',
			'is_verifikasidiagnosa' => 'Is Verifikasidiagnosa',
			'created_by' => 'Created By',
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

		$criteria->compare('pasienicd9cm_id',$this->pasienicd9cm_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglpasienicd9cm',$this->tglpasienicd9cm,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('riwayatpasienicd9cm_id',$this->riwayatpasienicd9cm_id);
		$criteria->compare('is_verifikasidiagnosa',$this->is_verifikasidiagnosa);
		$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pasienicd9cmR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function catat($model, $verifikasi = false) {
		
		$record = new Pasienicd9cmR;
		$record->attributes = $model->attributes;
		$record->create_time = date('Y-m-d H:i:s');
		$record->update_time = date('Y-m-d H:i:s');
		$record->is_verifikasidiagnosa = $verifikasi;
		$record->created_by = Yii::app()->user->getState('pegawai_id');
		$record->create_ruangan_id = Yii::app()->user->getState('ruangan_id') ?? $record->create_ruangan;
		if(empty($record->tglpasienicd9cm)) {
			$record->tglpasienicd9cm = date('Y-m-d H:i:s');
		}
		$record->save();
		
		// var_dump($record->attributes, $model->attributes); die;

		return $record;

	}

	public function updateRiwayat($model, $verifikasi = false) {
		
		$record = Pasienicd9cmR::model()->findByPk($model->pasienicd9cm_id);
		if(!empty($record)) {
			$record->attributes = $model->attributes;
			$record->update_time = date('Y-m-d H:i:s');
			$record->is_verifikasidiagnosa = $verifikasi;
			$record->update();
		}
		
		// var_dump($record->attributes, $model->attributes); die;

		return $record;

	}

	public function catatTransaksi($model)
	{

		$record = new Pasienicd9cmT;
		$record->attributes = $model->attributes;
		$record->create_time = date('Y-m-d H:i:s');
		$record->update_time = date('Y-m-d H:i:s');
		$record->create_ruangan_id = Yii::app()->user->getState('ruangan_id') ?? $record->create_ruangan;
		$record->save();

		// var_dump($record->attributes, $model->attributes); die;

		return $record;
	}
}
