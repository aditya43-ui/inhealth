<?php

/**
 * This is the model class for table "pasienkirimkeunitlain_t".
 *
 * The followings are the available columns in table 'pasienkirimkeunitlain_t':
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $kelaspelayanan_id
 * @property integer $instalasi_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $nourut
 * @property string $tgl_kirimpasien
 * @property string $catatandokterpengirim
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PasienkirimkeunitlainT extends CActiveRecord
{
        public $pegawai_nama,$opsmenerima_nama,$opsmenyerahkan_nama, $antibiotikygdiberi_tidakada,
               $diagnosa,$tgl_pendaftaran, $pasienanastesi_id, $noanestesi, $hasilpemeriksaanpa_id,$ppds_id,$ppds_nama,
               $no_rekam_medik, $umur, $jeniskasuspenyakit_id, $jeniskasuspenyakit_nama, 
               $nama_pegawai, $alamat_pasien, $nama_pasien, $jeniskelamin, $pekerjaan_id, $pekerjaan_nama, $kelaspelayanan_nama;
	    public $no_pendaftaran, $namadepan,$nama_bin, $carabayar_nama, $penjamin_nama, $ruangan_nama, $pembayaranpelayanan_id, $instalasi_nama, $statusperiksa, $totaltagihan;
        public $diagnosis_id, $diagnosis_nama;
        public $tanggalpermintaan, $dpjp, $namappds, $diagnosaklinis;
        public $daftartindakan_nama, $tarif_satuan, $qty_tindakan;
        public $tarif_medis, $subsidiasuransi_tindakan, $subsidipemerintah_tindakan, $subsisidirumahsakit_tindakan, $iurbiaya_tindakan;
        public $tindakanpelayanan_id;
		public $diagnosa_nama, $vitalsignterakhir, $tglrencanaoperasi, $sifatoperasi, $indikasioperasi, $petugasruangan_id, $petugasok_id;
		public $pegawaioperator_id;
        public $pemeriksaanlab_nama, $default;

		public $estimasioperasi;
		public $tglrencanapemeriksaan, $is_elektif, $carabayar_id, $penjamin_id,$noperminatanpenujang,$ruangan_id, $is_cito, $jenisanastesi_id, $shift_id, $kamarruangan_id, $keterangan_hd;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlainT the static model class
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
		return 'pasienkirimkeunitlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, instalasi_id, pasien_id, ruangan_id, pegawai_id, nourut, tgl_kirimpasien', 'required'),
			array('kelaspelayanan_id,ppds_id, instalasi_id, pasien_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, pendaftaran_id, ahligizi', 'numerical', 'integerOnly'=>true),
			array('nourut', 'length', 'max'=>3),
			array('no_ppds,estimasioperasi', 'safe'),
			array('is_cyto, ops_kamarruangan_id,ppds_id, pasienkirimkeunitlainparent_id, catatandokterpengirim, update_time,tglrencanapemeriksaan, create_loginpemakai_id, isbayarkekasirpenunjang, iskirimwa_pasien, samplelab_id, caraambilsampel_id, waktuambilspesimen, temp_aksiler, jenispemeriksaanmikro_id, pemeriksaanmikro_id, antibiotikygdiberi, antibiotik_hari, pegawai_id, ppds_id, catatandokterpengirim, petugas_jadwal_id, tgl_jadwalpemeriksaan', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
            array('klinis_penunjang_infeksi, keteranganklinislain, no_permintaan, diagnosis', 'safe'),        
//                        NILAI BERIKUT DIATUR DI CONTROLLER / BUGS KETIKA DIGUNAKAN DI MOBILE (BRIDGING)
//                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
//                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienkirimkeunitlain_id, kelaspelayanan_id, instalasi_id, pasien_id,ppds_id, pasienmasukpenunjang_id, ruangan_id, pegawai_id, pendaftaran_id, nourut, tgl_kirimpasien, catatandokterpengirim, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isbayarkekasirpenunjang, is_cyto, iskirimwa_pasien', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,  'PendaftaranT', 'pendaftaran_id'),
                    'pasien'=>array(self::BELONGS_TO,  'PasienM', 'pasien_id'),
                    'instalasi'=>array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    'kelaspelayanan'=>array(self::BELONGS_TO,'KelaspelayananM','kelaspelayanan_id'),
                    'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
					'petugasok'=>array(self::BELONGS_TO,'PegawaiM','petugasok_id'),
					'petugasruangan'=>array(self::BELONGS_TO,'PegawaiM','petugasruangan_id'),
					'petugas'=>array(self::BELONGS_TO,'PegawaiM','petugas_jadwal_id'),
					'permintaanpenunjang'=>array(self::BELONGS_TO,'PermintaankepenunjangT','pasienkirimkeunitlain_id'),
					'banyakpermintaanpenunjang'=>array(self::HAS_MANY,'PermintaankepenunjangT','pasienkirimkeunitlain_id'),
                    'ppds'=>array(self::BELONGS_TO,'PpdsM','ppds_id'),
			'jenisanastesi' => array(self::BELONGS_TO,'JenisAnastesiM','jenisanastesi_id'),
			'createruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
			'samplelab'=>array(self::BELONGS_TO,'SamplelabM','samplelab_id'),
			'jeniskomponendarah' => array(self::BELONGS_TO, 'JeniskomponendarahM', 'jeniskomponendarah_id'),
			'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'instalasi_id' => 'Instalasi',
			'pasien_id' => 'Pasien',
			'ppds_id'=> 'PPDS',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'ruangan_id' => 'Jenis Pemeriksaan',
			'pegawai_id' => 'Dokter DPJP',
			'pendaftaran_id' => 'Pendaftaran',
			'nourut' => 'Nourut',
			'tgl_kirimpasien' => 'Tanggal Rencana Operasi',
			'catatandokterpengirim' => 'Catatan Permintaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'ahligizi' => 'Ahli Gizi',
			'isbayarkekasirpenunjang' => 'Bayar Ke Kasir',
			'samplelab_id' => 'Sample Lab',
			'caraambilsampel_id' => 'Cara Ambil Sample',
			'waktuambilspesimen' => 'Waktu Ambil Spesimen',
			'temp_aksiler' => 'Temperatur Aksiler',
			'jenispemeriksaanmikro_id' => 'Jenis Pemeriksaan mikro',
			'pemeriksaanmikro_id' => 'pemeriksaan mikro id',
			'antibiotikygdiberi' => 'antibiotikygdiberi',
			'antibiotik_hari' => 'antibiotik_hari',
			'petugasruangan_id' => 'Petugas Ruangan',
			'petugasok_id' => 'Petugas OK',
			'tgl_jadwalpemeriksaan' => 'Tanggal Jadwal Pemeriksaan',
			'petugas_jadwal_id' => 'Petugas',
			'no_ppds' => 'No. Telepon PPDS',
			'noperminatanpenujang'=>'No Permintaan Penunjang',
			'estimasioperasi'=>'Estimasi Operasi',
			'tglrencanapemeriksaan' => 'Tgl. Rencana Pemeriksaan',
			'jeniskomponendarah_id' => 'jeniskomponendarah_id'
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

		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('LOWER(ppds_nama)',strtolower($this->ppds_nama),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);
		$criteria->order = 'tgl_kirimpasien desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('ppds_nama',$this->ppds_nama);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('ahligizi',$this->ahligizi);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
//        FUNGSI YANG SUDAH TIDAK DIGUNAKAN
//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date'){
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }elseif ($column->dbType == 'timestamp without time zone'){
//                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                    }
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {          
//            return parent::beforeSave();
//        }
//                
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems($ruangan_id=null){
//            tampilkan semua dokter
//            if (Yii::app()->user->getState('dokterruangan')==true){
//				if(empty($ruangan_id))
//					$ruangan_id = Yii::app()->user->getState('ruangan_id');
//                if(!empty($ruangan_id))
//                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
//                else
//                    return array();
//            }else{
//              DATA YANG DILOAD TERLALU BANYAK (BERAT) >>  return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true),array('order'=>'nama_pegawai'));
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('t.kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("t.pegawai_aktif = TRUE");
                                $criteria->join = "join ruanganpegawai_m r on r.pegawai_id = t.pegawai_id";
                                if (!empty($ruangan_id)) {
                                    $criteria->compare('r.ruangan_id', $ruangan_id);
                                } else {
                                    $criteria->compare('r.ruangan_id', Yii::app()->user->getState('ruangan_id'));
                                }
                                
				$criteria->order = 't.nama_pegawai';
                $peg = PegawaiM::model()->findAll($criteria);

				return $peg;
//            }
        }



		public function getPPDS(){
						
			// $login = Yii::app()->user->getState('loginpemakai_id');
			// $lp = LoginpemakaiK::model()->findByPk($login);
	       //   $ppds_id = !empty($lp->ppds_id) ? $lp->ppds_id : 0;
			$ppds = PpdsM::model()->findAllByAttributes(array(),array('order'=>'ppds_nama ASC'));
			// var_dump('Loginpe: ' . ($login)); die;

			return $ppds;

		}
        



        /**
         * Mengambil daftar semua ruangan gizi
         * @return CActiveDataProvider 
         */
        public function getRuanganGiziItems()
        {
            return RuanganinstalasigiziV::model()->findAllByAttributes(array('ruangan_aktif'=>true),array('order'=>'ruangan_nama ASC'));
        }
        public function getAhliGiziItems()
        {
			return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_AHLI_GIZI), array('order'=>'nama_pegawai ASC'));
            //return DokterV::model()->findAll();
        }
}