<?php

/**
 * This is the model class for table "asesmentriase_t".
 *
 * The followings are the available columns in table 'asesmentriase_t':
 * @property integer $asesmentriase_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 * @property InstalasiM $instalasi
 * @property AsesmentriasedetT[] $asesmentriasedetTs
 */
class AsesmentriaseT extends CActiveRecord
{
    public $trauma;
    public $nontrauma;
	public $gcs_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentriaseT the static model class
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
		return 'asesmentriase_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglasesmentriase, pegawai_id, create_time, create_loginpemakai_id, create_ruangan, instalasi_id, ruangan_id', 'required'),
			array('pendaftaran_id, pasien_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, instalasi_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('gcs_eye, gcs_verbal, gcs_motorik, gcs_nilai, isobstetri, istrauma, ishitam, ishijau, iskuning, ismerah, tglasesmentriase, update_time', 'safe'),
			['is_truemergency, is_falseemergency, caradatang_sendiri, caradatang_ambulance, caradatang_diantarpolisi, caradatang_rujukan, pengantar_pasien, kecelakaan_lalulintas, kecelakaan_kerja, kecelakaan_rumahtangga, kecelakaan_pejalankaki, kecelakaan_kecelakaanair, sad_gejalapernapasan, sad_demam, sad_riwayat, sad_erupsi, sad_eritema','safe'],
                        ['sad_riwayatkontak boolean, jeniskasus_nontrauma, jeniskasus_trauma, jeniskasus_obstetri, jeniskasus_neonatus, jeniskasus_pediatrik, jeniskasus_geriatrik, tandakehidupan, denyutnadi, rc, ekg, riwayatalergi_makanan, riwayatalergi_makanan_keterangan, riwayatalergi_obat, riwayatalergi_obat_keterangan, kesadaran_composmentis, kesadaran_apatis','safe'],
                        ['jamdoa, kesadaran_somolen boolean, pupil_isokor, pupil_anisokor, diameter, reaksi_cahaya, jeniskasus_obstetri, jeniskasus_neonatus, kategori_i, kategori_ii, kategori_iii, kategori_iv, kategori_v','safe'],
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentriase_id, pendaftaran_id, pasien_id, pegawai_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, instalasi_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'asesmentriasedetTs' => array(self::HAS_MANY, 'AsesmentriasedetT', 'asesmentriase_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentriase_id' => 'Asesmentriase',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'tglasesmentriase' => 'Tanggal Asesmen Triase',
			'gcs_nilai' => 'Skor GCS',
			'gcs_eye' => 'Mata',
			'gcs_verbal' => 'Verbal',
			'gcs_motorik' => 'Motorik',
			'gcs_nama' => 'Keterangan',
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

		$criteria->compare('asesmentriase_id',$this->asesmentriase_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * 
         * @param type $model
         * @param type $post
         * @return type
         */
        public static function simpanData($model, $post){
            
            $format = new MyFormatter();
            $ok  = true;
            $pesan = '';
            
            $model->attributes = $post;
            $model->tglasesmentriase = !empty($model->tglasesmentriase)?$format->formatDateTimeForDb($model->tglasesmentriase):null;
            $model->jamdoa = !empty($model->jamdoa)?$format->formatDateTimeForDb($model->jamdoa):null;
            
            if (empty($model->pegawai_id)) {
                $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
            }            
            
            if (empty($model->asesmentriase_id)){
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $model->create_ruangan = $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $model->ruangan_id = Yii::app()->user->getState('ruangan_id');                
                $model->instalasi_id = Yii::app()->user->getState('instalasi_id');  
            }else{
                $model->update_time = date('Y-m-d H:i:s');
                $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            }
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'asesmen triase '.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'sukses' => $ok,
                'model' => $model,
                'pesan' => $pesan
            ];
        }
}