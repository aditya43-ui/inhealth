<?php

/**
 * This is the model class for table "persalinan_t".
 *
 * The followings are the available columns in table 'persalinan_t':
 * @property integer $persalinan_id
 * @property integer $kegiatanpersalinan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $kelsebababortus_id
 * @property integer $ruangan_id
 * @property integer $sebababortus_id
 * @property integer $pegawai_id
 * @property string $jeniskegiatanpersalinan
 * @property string $tglmulaipersalinan
 * @property string $tglselesaipersalinan
 * @property integer $lamapersalinan_jam
 * @property string $carapersalinan
 * @property string $posisijanin
 * @property boolean $islahirdirs
 * @property string $tglmelahirkan
 * @property string $keadaanlahir
 * @property integer $masagestasi_minggu
 * @property string $paritaske
 * @property integer $jmlkelahiranhidup
 * @property integer $jmlkelahiranmati
 * @property string $sebabkematian
 * @property string $tglabortus
 * @property integer $jmlabortus
 * @property string $catatan_dokter
 * @property string $bidan_id
 * @property string $paramedis_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PersalinanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersalinanT the static model class
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
		return 'persalinan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, jeniskegiatanpersalinan, tglmulaipersalinan, paritaske', 'required'),//carapersalinan, posisijanin, masagestasi_minggu, 
			array('kegiatanpersalinan_id, pasien_id, pendaftaran_id, kelsebababortus_id, ruangan_id, sebababortus_id, pegawai_id, lamapersalinan_jam, masagestasi_minggu, jmlkelahiranhidup, jmlkelahiranmati, jmlabortus', 'numerical', 'integerOnly'=>true),
			array('jeniskegiatanpersalinan, carapersalinan', 'length', 'max'=>50),
			array('keadaanlahir, sebabkematian', 'length', 'max'=>100),
			array('paritaske', 'length', 'max'=>30),
            array('lokasi_persalinan, alamat_persalinan, is_rujuk, rujuk_kala, rujuk_alasan, rujuk_tempat, rujuk_pendamping, masalah_kehamilan', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			array('tglselesaipersalinan, islahirdirs, tglmelahirkan, tglabortus, catatan_dokter, bidan_id, paramedis_id, update_time, update_loginpemakai_id, penyulit_kehamilan_persalinan, pmtct, posisijanin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('persalinan_id, kegiatanpersalinan_id, pasien_id, pendaftaran_id, kelsebababortus_id, ruangan_id, sebababortus_id, pegawai_id, jeniskegiatanpersalinan, tglmulaipersalinan, tglselesaipersalinan, lamapersalinan_jam, carapersalinan, posisijanin, islahirdirs, tglmelahirkan, keadaanlahir, masagestasi_minggu, paritaske, jmlkelahiranhidup, jmlkelahiranmati, sebabkematian, tglabortus, jmlabortus, catatan_dokter, bidan_id, paramedis_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penyulit_kehamilan_persalinan, pmtct', 'safe', 'on'=>'search'),
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
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),                        
                        'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),                        
                        'paramedis'=>array(self::BELONGS_TO,'PegawaiM','paramedis_id'),                        
                        'bidan'=>array(self::BELONGS_TO,'PegawaiM','bidan_id'),                        
                        'bidan2'=>array(self::BELONGS_TO,'PegawaiM','bidan2_id'),
                        'bidan3'=>array(self::BELONGS_TO,'PegawaiM','bidan3_id'),
                        'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),                        
                        'tipePaket'=>array(self::BELONGS_TO,'TipepaketM','tipepaket_id'),
                        'kelsebababortus'=>array(self::BELONGS_TO,'KelsebababortusM','kelsebababortus_id'),
                        'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                        'sebababortus'=>array(self::BELONGS_TO,'SebababortusM','sebababortus_id'),
                        'kegiatanpersalinan'=>array(self::BELONGS_TO,'KegiatanpersalinanM','kegiatanpersalinan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persalinan_id' => 'ID',
			'kegiatanpersalinan_id' => 'Kegiatan Persalinan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'kelsebababortus_id' => 'Kelompok Sebab Abortus',
			'ruangan_id' => 'Ruangan',
			'sebababortus_id' => 'Sebab Abortus',
			'pegawai_id' => 'Dokter',
			'jeniskegiatanpersalinan' => 'Jenis Kegiatan Persalinan',
			'tglmulaipersalinan' => 'Tanggal Mulai Persalinan',
			'tglselesaipersalinan' => 'Tanggal Selesai Persalinan',
			'lamapersalinan_jam' => 'Lama Persalinan',
			'carapersalinan' => 'Cara persalinan',
			'posisijanin' => 'Posisi Janin',
			'islahirdirs' => 'Lahir Di RS',
			'tglmelahirkan' => 'Tanggal Melahirkan',
			'keadaanlahir' => 'Keadaan Lahir',
			'masagestasi_minggu' => 'Masa Gestasi',
			'paritaske' => 'Paritas',
			'jmlkelahiranhidup' => 'Jumlah Kelahiran Hidup',
			'jmlkelahiranmati' => 'Jumlah Kelahiran Mati',
			'sebabkematian' => 'Sebab Kematian',
			'tglabortus' => 'Tanggal Abortus',
			'jmlabortus' => 'Jumlah Abortus',
			'catatan_dokter' => 'Catatan Dokter',
			'bidan_id' => 'Bidan',
			'bidan2_id' => 'Bidan 2',
			'bidan3_id' => 'Bidan 3',
			'paramedis_id' => 'Paramedis',
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

		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('kegiatanpersalinan_id',$this->kegiatanpersalinan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('sebababortus_id',$this->sebababortus_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(jeniskegiatanpersalinan)',strtolower($this->jeniskegiatanpersalinan),true);
		$criteria->compare('LOWER(tglmulaipersalinan)',strtolower($this->tglmulaipersalinan),true);
		$criteria->compare('LOWER(tglselesaipersalinan)',strtolower($this->tglselesaipersalinan),true);
		$criteria->compare('lamapersalinan_jam',$this->lamapersalinan_jam);
		$criteria->compare('LOWER(carapersalinan)',strtolower($this->carapersalinan),true);
		$criteria->compare('LOWER(posisijanin)',strtolower($this->posisijanin),true);
		$criteria->compare('islahirdirs',$this->islahirdirs);
		$criteria->compare('LOWER(tglmelahirkan)',strtolower($this->tglmelahirkan),true);
		$criteria->compare('LOWER(keadaanlahir)',strtolower($this->keadaanlahir),true);
		$criteria->compare('masagestasi_minggu',$this->masagestasi_minggu);
		$criteria->compare('LOWER(paritaske)',strtolower($this->paritaske),true);
		$criteria->compare('jmlkelahiranhidup',$this->jmlkelahiranhidup);
		$criteria->compare('jmlkelahiranmati',$this->jmlkelahiranmati);
		$criteria->compare('LOWER(sebabkematian)',strtolower($this->sebabkematian),true);
		$criteria->compare('LOWER(tglabortus)',strtolower($this->tglabortus),true);
		$criteria->compare('jmlabortus',$this->jmlabortus);
		$criteria->compare('LOWER(catatan_dokter)',strtolower($this->catatan_dokter),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('persalinan_id',$this->persalinan_id);
		$criteria->compare('kegiatanpersalinan_id',$this->kegiatanpersalinan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kelsebababortus_id',$this->kelsebababortus_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('sebababortus_id',$this->sebababortus_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(jeniskegiatanpersalinan)',strtolower($this->jeniskegiatanpersalinan),true);
		$criteria->compare('LOWER(tglmulaipersalinan)',strtolower($this->tglmulaipersalinan),true);
		$criteria->compare('LOWER(tglselesaipersalinan)',strtolower($this->tglselesaipersalinan),true);
		$criteria->compare('lamapersalinan_jam',$this->lamapersalinan_jam);
		$criteria->compare('LOWER(carapersalinan)',strtolower($this->carapersalinan),true);
		$criteria->compare('LOWER(posisijanin)',strtolower($this->posisijanin),true);
		$criteria->compare('islahirdirs',$this->islahirdirs);
		$criteria->compare('LOWER(tglmelahirkan)',strtolower($this->tglmelahirkan),true);
		$criteria->compare('LOWER(keadaanlahir)',strtolower($this->keadaanlahir),true);
		$criteria->compare('masagestasi_minggu',$this->masagestasi_minggu);
		$criteria->compare('LOWER(paritaske)',strtolower($this->paritaske),true);
		$criteria->compare('jmlkelahiranhidup',$this->jmlkelahiranhidup);
		$criteria->compare('jmlkelahiranmati',$this->jmlkelahiranmati);
		$criteria->compare('LOWER(sebabkematian)',strtolower($this->sebabkematian),true);
		$criteria->compare('LOWER(tglabortus)',strtolower($this->tglabortus),true);
		$criteria->compare('jmlabortus',$this->jmlabortus);
		$criteria->compare('LOWER(catatan_dokter)',strtolower($this->catatan_dokter),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        public function beforeSave() {
            if($this->tglabortus===null || trim($this->tglabortus)==''){
	        $this->setAttribute('tglabortus', null);
            }
            
            if($this->tglmelahirkan===null || trim($this->tglmelahirkan)==''){
	        $this->setAttribute('tglmelahirkan', null);
            }
            if($this->tglmulaipersalinan===null || trim($this->tglmulaipersalinan)==''){
	        $this->setAttribute('tglmulaipersalinan', null);
            }
            if($this->tglselesaipersalinan===null || trim($this->tglselesaipersalinan)==''){
	        $this->setAttribute('tglselesaipersalinan', null);
            }
            return parent::beforeSave();
        }
        
}