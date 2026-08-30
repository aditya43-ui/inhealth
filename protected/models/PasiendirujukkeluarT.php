<?php

/**
 * This is the model class for table "pasiendirujukkeluar_t".
 *
 * The followings are the available columns in table 'pasiendirujukkeluar_t':
 * @property integer $pasiendirujukkeluar_id
 * @property integer $pasien_id
 * @property integer $rujukankeluar_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $nosuratrujukan
 * @property string $tgldirujuk
 * @property string $kepadayth
 * @property string $dirujukkebagian
 * @property string $alasandirujuk
 * @property string $hasilpemeriksaan_ruj
 * @property string $diagnosasementara_ruj
 * @property string $pengobatan_ruj
 * @property string $lainlain_ruj
 * @property string $catatandokterperujuk
 * @property integer $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $tglberlakusurat
 * @property string $sampaidengan
 * @property string $lampiransurat
 * @property string $dokterpemeriksa
 *
 * The followings are the available model relations:
 * @property RuanganM $ruanganasal
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property RujukankeluarM $rujukankeluar
 */
class PasiendirujukkeluarT extends CActiveRecord
{
	public $rujukankeluar_nama, $rumahsakitrujukan, $alamatrsrujukan;
	public $ppkrujukan,$ppkrujukan_nama,$dirujukkebagian_nama,$dirujukkebagian_kode;
	public $diagnosa_awal;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiendirujukkeluarT the static model class
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
		return 'pasiendirujukkeluar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rujukankeluar_id, pegawai_id, nosuratrujukan, tgldirujuk, ruanganasal_id, create_time, create_loginpemakai_id, tglberlakusurat, sampaidengan', 'required'),
			array('pasien_id, rujukankeluar_id, pasienadmisi_id, pegawai_id, pendaftaran_id, ruanganasal_id', 'numerical', 'integerOnly'=>true),
			array('nosuratrujukan', 'length', 'max'=>50),
			array('kepadayth', 'length', 'max'=>100),
			array('dirujukkebagian', 'length', 'max'=>30),
			array('lampiransurat', 'length', 'max'=>20),
			array('alasandirujuk, hasilpemeriksaan_ruj, diagnosasementara_ruj, pengobatan_ruj, lainlain_ruj, catatandokterperujuk, update_time, update_loginpemakai_id, dokterpemeriksa', 'safe'),
			array('penerimarujukan_dihubungipada, penerimatelepon character, penerimatelepon_unit, alasandirujuk_nonklinis, alasandirujuk_nonklinislainnya, diagnosa_sekunder, keluhanutama, riwayatpenyakit, isalergi_status, riwayatalergi_obat,riwayatalergi_makanan,riwayatalergi_lainnya,suhutubuh,respiartoryrate,td_systolic,td_diastolic,detaknadi,keadaanumum,kesadaranpasien,gcs_eye,gcs_verbal,gcs_motorik,temuanpemeriksaan_fisik,alatygterpasang_isinfus,infus_jalur character,infus_lokasi character,alatygterpasang_isurinecatether,alatygterpasang_isdrain,drain_lokasi,alatygterpasang_isngt,alatygterpasang_iskanuloksigennasal,alatygterpasang_isopa,alatygterpasang_isnpa,alatygterpasang_issungkuprm,alatygterpasang_issungkupnrm,alatygterpasang_isett,alatygterpasang_islainnya,alatygterpasang_lainnya,derajatpasien,kompetensipendamping,penerimaan_stafpenerima,penerimaan_unit,penerimaan_waktu','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasiendirujukkeluar_id, pasien_id, rujukankeluar_id, pasienadmisi_id, pegawai_id, pendaftaran_id, nosuratrujukan, tgldirujuk, kepadayth, dirujukkebagian, alasandirujuk, hasilpemeriksaan_ruj, diagnosasementara_ruj, pengobatan_ruj, lainlain_ruj, catatandokterperujuk, ruanganasal_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, tglberlakusurat, sampaidengan, lampiransurat,dokterpemeriksa', 'safe', 'on'=>'search'),
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
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'rujukankeluar' => array(self::BELONGS_TO, 'RujukankeluarM', 'rujukankeluar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasiendirujukkeluar_id' => 'Pasien Dirujuk Keluar',
			'pasien_id' => 'Pasien',
			'rujukankeluar_id' => 'Rujukan Keluar',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'nosuratrujukan' => 'No. Surat Rujukan',
			'tgldirujuk' => 'Tgl. Dirujuk',
			'kepadayth' => 'Yth. Dokter',
			'dirujukkebagian' => 'Dirujuk Ke Bagian',
			'alasandirujuk' => 'Alasan Dirujuk',
			'hasilpemeriksaan_ruj' => 'Hasil Pemeriksaan Rujukan',
			'diagnosasementara_ruj' => 'Diagnosa Sementara Rujukan',
			'pengobatan_ruj' => 'Pengobatan Rujukan',
			'lainlain_ruj' => 'Lain-lain',
			'catatandokterperujuk' => 'Catatan Dokter Perujuk',
			'ruanganasal_id' => 'Ruangan Asal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'tglberlakusurat' => 'Tgl. Surat Berlaku',
			'sampaidengan' => 'Sampai Dengan',
			'lampiransurat' => 'Lampiran Surat',
			'dokterpemeriksa' => 'Dokter Pemeriksa',
			'penerimarujukan_dihubungipada'=>'Dihubungi pada', 
			'penerimatelepon'=>'Penerima Telepon', 
			'penerimatelepon_unit'=>'Unit Penerima Telepon', 
			'alasandirujuk_nonklinis', 
			'alasandirujuk_nonklinislainnya', 
			'diagnosa_sekunder', 
			'keluhanutama'=>'Keluhan Utama', 
			'riwayatpenyakit'=>'Riwayat Penyakit', 
			'isalergi_status', 
			'riwayatalergi_obat'=>'Riwayat Alergi Obat',
			'riwayatalergi_makanan'=>'Riwayat Alergi Makanan',
			'riwayatalergi_lainnya'=>'Riwayat Alergi Lainnya',
			'tglrencanakunjungan_bpjs'=>'Tgl. Rencana Kunjungan BPJS',
			'suhutubuh'=>'Suhu',
			'respiartoryrate'=>'RR',
			'td_systolic'=>'Suhu',
			'td_diastolic',
			'detaknadi'=>'Nadi',
			'keadaanumum'=>'Keadaan Umum',
			'kesadaranpasien'=>'Kesadaran',
			'gcs_eye',
			'gcs_verbal',
			'gcs_motorik',
			'temuanpemeriksaan_fisik'=>'Temuan Pemeriksaan Fisik',
			'alatygterpasang_isinfus',
			'infus_jalur character',
			'infus_lokasi character',
			'alatygterpasang_isurinecatether',
			'alatygterpasang_isdrain',
			'drain_lokasi',
			'alatygterpasang_isngt',
			'alatygterpasang_iskanuloksigennasal',
			'alatygterpasang_isopa',
			'alatygterpasang_isnpa',
			'alatygterpasang_issungkuprm',
			'alatygterpasang_issungkupnrm',
			'alatygterpasang_isett',
			'alatygterpasang_islainnya',
			'alatygterpasang_lainnya',
			'derajatpasien',
			'kompetensipendamping',
			'penerimaan_stafpenerima',
			'penerimaan_unit',
			'penerimaan_waktu'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasiendirujukkeluar_id)){
			$criteria->addCondition('pasiendirujukkeluar_id = '.$this->pasiendirujukkeluar_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->rujukankeluar_id)){
			$criteria->addCondition('rujukankeluar_id = '.$this->rujukankeluar_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(nosuratrujukan)',strtolower($this->nosuratrujukan),true);
		$criteria->compare('LOWER(tgldirujuk)',strtolower($this->tgldirujuk),true);
		$criteria->compare('LOWER(kepadayth)',strtolower($this->kepadayth),true);
		$criteria->compare('LOWER(dirujukkebagian)',strtolower($this->dirujukkebagian),true);
		$criteria->compare('LOWER(alasandirujuk)',strtolower($this->alasandirujuk),true);
		$criteria->compare('LOWER(hasilpemeriksaan_ruj)',strtolower($this->hasilpemeriksaan_ruj),true);
		$criteria->compare('LOWER(diagnosasementara_ruj)',strtolower($this->diagnosasementara_ruj),true);
		$criteria->compare('LOWER(pengobatan_ruj)',strtolower($this->pengobatan_ruj),true);
		$criteria->compare('LOWER(lainlain_ruj)',strtolower($this->lainlain_ruj),true);
		$criteria->compare('LOWER(catatandokterperujuk)',strtolower($this->catatandokterperujuk),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(tglberlakusurat)',strtolower($this->tglberlakusurat),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('LOWER(lampiransurat)',strtolower($this->lampiransurat),true);
		$criteria->compare('LOWER(dokterpemeriksa)',strtolower($this->dokterpemeriksa),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		
		/**
         * Mengambil daftar semua rujukankeluar
         * @return CActiveDataProvider 
         */
        public function getRujukanItems()
        {
            return RujukankeluarM::model()->findAllByAttributes(array('rujukankeluar_aktif'=>true),array('order'=>'rumahsakitrujukan'));
        }
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
        /**
         * Mengambil daftar semua ruangan dari instalasi
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasiItems($idInstalasi)
        {
            if(!empty($idInstalasi))
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$idInstalasi,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            else
                return RuanganM::model()->findAllByAttributes(array('ruangan_id'=>$this->ruanganasal_id));
        }
    
        public function getDiagnosaSementara($pendaftaran_id)
        {
            $modMorbiditas = PasienmorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $diagnosa = '';
            foreach ($modMorbiditas as $i => $morbiditas) {
                $diagnosa .= $morbiditas->diagnosa->diagnosa_nama.', ';
            }

            return $diagnosa;
        }
}