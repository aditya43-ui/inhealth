<?php

/**
 * This is the model class for table "informasipasiensudahbayar_v".
 *
 * The followings are the available columns in table 'informasipasiensudahbayar_v':
 * @property integer $pembayaranpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property string $instalasi
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalbayartindakan
 * @property integer $tandabuktibayar_id
 * @property integer $returbayarpelayanan_id
 * @property integer $closingkasir_id
 * @property string $ruangan_nama
 * @property integer $ruangan_id
 * @property integer $ruangankasir_id
 * @property string $ruangankasir_nama
 * @property string $tglselesaiperiksa
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $tgl_meninggal
 * @property boolean $ispasienluar
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property integer $petugasadministrasi_id
 * @property string $petugasadministrasi_gelardepan
 * @property string $petugasadministrasi_nama
 * @property string $petugasadministrasi_gelarbelakang
 * @property integer $dokterpendaftaran_id
 * @property string $dokterpendaftaran_gelardepan
 * @property string $dokterpendaftaran_nama
 * @property string $dokterpendaftaran_gelarbelakang
 * @property integer $dokteradmisi_id
 * @property string $dokteradmisi_gelardepan
 * @property string $dokteradmisi_nama
 * @property string $dokteradmisi_gelarbelakang
 * @property integer $instalasi_id
 * @property string $tgl_pendaftaran
 * @property string $tgladmisi
 */
class InformasipasiensudahbayarV extends CActiveRecord
{      
	
	public $ruanganakhir_id;
	public $instalasiakhir_id;
	public $instalasiakhir_nama;
	public $ruanganakhir_nama;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipasiensudahbayarV the static model class
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
		return 'informasipasiensudahbayar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembayaranpelayanan_id, pendaftaran_id, pasienadmisi_id, tandabuktibayar_id, returbayarpelayanan_id, closingkasir_id, ruangan_id, ruangankasir_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, anakke, jumlah_bersaudara, petugasadministrasi_id, dokterpendaftaran_id, dokteradmisi_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			array('totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan, totalbayartindakan', 'numerical'),
			array('nobuktibayar, instalasi, nama_pasien, carabayar_nama, penjamin_nama, ruangan_nama, ruangankasir_nama, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, petugasadministrasi_nama, dokterpendaftaran_nama, dokteradmisi_nama', 'length', 'max'=>50),
			array('no_pendaftaran, jenisidentitas, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien', 'length', 'max'=>20),
			array('no_rekam_medik, statusrekammedis, petugasadministrasi_gelardepan, dokterpendaftaran_gelardepan, dokteradmisi_gelardepan', 'length', 'max'=>10),
			array('nama_bin, no_identitas_pasien', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien, petugasadministrasi_gelarbelakang, dokterpendaftaran_gelarbelakang, dokteradmisi_gelarbelakang', 'length', 'max'=>15),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail', 'length', 'max'=>100),
			array('kamarruangan_id, kelaspelayanan_id, kelastanggungan_id, nopembayaran, tglbuktibayar, tglselesaiperiksa, tanggal_lahir, alamat_pasien, tgl_meninggal, ispasienluar, tgl_pendaftaran, tgladmisi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kamarruangan_id, kelaspelayanan_id, kelastanggungan_id, nopembayaran, pembayaranpelayanan_id, pendaftaran_id, pasienadmisi_id, tglbuktibayar, nobuktibayar, instalasi, no_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, carabayar_nama, penjamin_nama, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totaldiscount, totalpembebasan, totalbayartindakan, tandabuktibayar_id, returbayarpelayanan_id, closingkasir_id, ruangan_nama, ruangan_id, ruangankasir_id, ruangankasir_nama, tglselesaiperiksa, jenisidentitas, no_identitas_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, statusrekammedis, tgl_meninggal, ispasienluar, nama_ibu, nama_ayah, petugasadministrasi_id, petugasadministrasi_gelardepan, petugasadministrasi_nama, petugasadministrasi_gelarbelakang, dokterpendaftaran_id, dokterpendaftaran_gelardepan, dokterpendaftaran_nama, dokterpendaftaran_gelarbelakang, dokteradmisi_id, dokteradmisi_gelardepan, dokteradmisi_nama, dokteradmisi_gelarbelakang, instalasi_id, tgl_pendaftaran, tgladmisi', 'safe', 'on'=>'search'),
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
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'instalasi' => 'Instalasi',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_nama' => 'Penjamin',
			'totalbiayapelayanan' => 'Totalbiayapelayanan',
			'totalsubsidiasuransi' => 'Totalsubsidiasuransi',
			'totalsubsidipemerintah' => 'Totalsubsidipemerintah',
			'totalsubsidirs' => 'Totalsubsidirs',
			'totaliurbiaya' => 'Totaliurbiaya',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Totalpembebasan',
			'totalbayartindakan' => 'Totalbayartindakan',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'closingkasir_id' => 'Status Closing',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_id' => 'Ruangan',
			'ruangankasir_id' => 'Ruangankasir',
			'ruangankasir_nama' => 'Ruangankasir Nama',
			'tglselesaiperiksa' => 'Tglselesaiperiksa',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'tgl_meninggal' => 'Tgl. Meninggal',
			'ispasienluar' => 'Ispasienluar',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'petugasadministrasi_id' => 'Petugas Kasir',
			'petugasadministrasi_gelardepan' => 'Petugasadministrasi Gelardepan',
			'petugasadministrasi_nama' => 'Nama Petugas Administrasi',
			'petugasadministrasi_gelarbelakang' => 'Petugasadministrasi Gelarbelakang',
			'dokterpendaftaran_id' => 'Dokterpendaftaran',
			'dokterpendaftaran_gelardepan' => 'Dokterpendaftaran Gelardepan',
			'dokterpendaftaran_nama' => 'Nama Dokter Pendaftaran',
			'dokterpendaftaran_gelarbelakang' => 'Dokterpendaftaran Gelarbelakang',
			'dokteradmisi_id' => 'Dokteradmisi',
			'dokteradmisi_gelardepan' => 'Dokteradmisi Gelardepan',
			'dokteradmisi_nama' => 'Nama Dokter Admisi',
			'dokteradmisi_gelarbelakang' => 'Dokteradmisi Gelarbelakang',
			'instalasi_id' => 'Instalasi',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'tgladmisi' => 'Tgladmisi',
            'ruanganakhir_id' => 'Ruangan',
			'instalasiakhir_id'=>'Instalasi',
            'nopembayaran'=>'No. Pembayaran',
            'kamarruangan_id'=>'Kamar',
            'kelaspelayanan_id'=>'Kelas Pelayanan',
            'kelastanggungan_id'=>'Kelas Tanggungan',
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

		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(instalasi)',strtolower($this->instalasi),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('totalpembebasan',$this->totalpembebasan);
		$criteria->compare('totalbayartindakan',$this->totalbayartindakan);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangankasir_id',$this->ruangankasir_id);
		$criteria->compare('LOWER(ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->compare('petugasadministrasi_id',$this->petugasadministrasi_id);
		$criteria->compare('LOWER(petugasadministrasi_gelardepan)',strtolower($this->petugasadministrasi_gelardepan),true);
		$criteria->compare('LOWER(petugasadministrasi_nama)',strtolower($this->petugasadministrasi_nama),true);
		$criteria->compare('LOWER(petugasadministrasi_gelarbelakang)',strtolower($this->petugasadministrasi_gelarbelakang),true);
		$criteria->compare('dokterpendaftaran_id',$this->dokterpendaftaran_id);
		$criteria->compare('LOWER(dokterpendaftaran_gelardepan)',strtolower($this->dokterpendaftaran_gelardepan),true);
		$criteria->compare('LOWER(dokterpendaftaran_nama)',strtolower($this->dokterpendaftaran_nama),true);
		$criteria->compare('LOWER(dokterpendaftaran_gelarbelakang)',strtolower($this->dokterpendaftaran_gelarbelakang),true);
		$criteria->compare('dokteradmisi_id',$this->dokteradmisi_id);
		$criteria->compare('LOWER(dokteradmisi_gelardepan)',strtolower($this->dokteradmisi_gelardepan),true);
		$criteria->compare('LOWER(dokteradmisi_nama)',strtolower($this->dokteradmisi_nama),true);
		$criteria->compare('LOWER(dokteradmisi_gelarbelakang)',strtolower($this->dokteradmisi_gelarbelakang),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);

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
        
        public function getKasirRuanganItems()
        {
            $criteria = new CDbCriteria();    
            $criteria->with = array('pegawai');
            $criteria->compare('t.ruangan_id', array(Params::RUANGAN_ID_KASIR));           
            $criteria->order = "pegawai.nama_pegawai ASC";           
            return RuanganpegawaiM::model()->findAll($criteria);
        }
        
         public function getCekBayar($tandabuktibayar_id)
        {
           $cek  = TandabuktibayarT::model()->findAll("tandabuktibayar_id = '$tandabuktibayar_id' AND closingkasir_id IS NOT NULL ");         
           
           if (empty($cek)):
               return false;
           else:
               return true;
           endif;                      
                       
        }
        
        public function getCekPrint($pendaftaran_id)
        {   
            $pendaftaran = RincianCetakan::model()->findAll("pendaftaran_id = '$pendaftaran_id' AND jenis_cetakan = 'KWITANSI' AND create_loginpemakai_id IS NOT NULL ");                      
            
            if (empty($pendaftaran)):
                $data = 1;
            else:
                foreach($pendaftaran as $pendaftaran):
                    $data = $pendaftaran->jumlah;
                endforeach;
            endif;
            
            return $data;
        }
        
         public function getRincianCetak($pendaftaran_id)
        {   
            $pendaftaran = RincianCetakan::model()->findAll("pendaftaran_id = '$pendaftaran_id' AND jenis_cetakan = 'KWITANSI' AND create_loginpemakai_id IS NOT NULL ");            
           
            $data = array();
            if (empty($pendaftaran)):               
                    $data['nama'] = '';
                    $data['tanggal'] = '';
                    $data['ruangan'] = '';                    
            else:                    
                foreach($pendaftaran as $cek):
                    if ($cek->update_loginpemakai_id === null):                    
                        $data['nama'] = '<b>'.LoginpemakaiK::model()->pegawaiLoginPemakaiById($cek->create_loginpemakai_id).'</b>';
                        $data['tanggal'] = '<b>'.MyFormatter::formatDateTimeForUser($cek->create_time).'</b>';
                        $data['ruangan'] = '<b>'.RuanganM::model()->ruanganNamaById($cek->create_ruangan).'</b>';                       
                    else:
                        $data['nama'] = '<b>'.LoginpemakaiK::model()->pegawaiLoginPemakaiById($cek->update_loginpemakai_id).'</b>';
                        $data['tanggal'] = '<b>'.MyFormatter::formatDateTimeForUser($cek->update_time).'</b>';
                        $data['ruangan'] = '<b>'.RuanganM::model()->ruanganNamaById($cek->update_ruangan).'</b>';                        
                    endif;                                
                endforeach;                
            endif;
            
            return $data;
        }
        
        public function getNamaUsername($pegawai_id)
        {
            $user = LoginpemakaiK::model()->findAllByAttributes(array('pegawai_id'=>$pegawai_id));
            
            if (empty($user)):
                $data = '';
            else:
                foreach($user as $user):
                    $data = $user->nama_pemakai;
                endforeach;
            endif;
            
            return $data;
        }
            
        
                                
}