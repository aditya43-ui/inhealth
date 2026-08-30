<?php

/**
 * This is the model class for table "pelamar_t".
 *
 * The followings are the available columns in table 'pelamar_t':
 * @property integer $pelamar_id
 * @property integer $pendkualifikasi_id
 * @property integer $profilrs_id
 * @property integer $suku_id
 * @property integer $pendidikan_id
 * @property string $tgllowongan
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $nama_pelamar
 * @property string $nama_keluarga
 * @property string $tempatlahir_pelamar
 * @property string $tgl_lahirpelamar
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property integer $jmlanak
 * @property string $alamat_pelamar
 * @property string $kodepos
 * @property string $agama
 * @property string $alamatemail
 * @property string $notelp_pelamar
 * @property string $nomobile_pelamar
 * @property string $warganegara_pelamar
 * @property string $photopelamar
 * @property double $gajiygdiharapkan
 * @property string $tglditerima
 * @property string $tglmulaibekerja
 * @property string $ingintunjangan
 * @property string $keterangan_pelamar
 * @property string $minatpekerjaan
 * @property string $filelamaran
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $berlaku_s_d
 *
 * The followings are the available model relations:
 * @property PendidikankualifikasiM $pendkualifikasi
 * @property PendidikanM $pendidikan
 * @property ProfilrumahsakitM $profilrs
 * @property SukuM $suku
 * @property LingkungankerjaR[] $lingkungankerjaRs
 * @property KemampuanbahasaR[] $kemampuanbahasaRs
 */
class PelamarT extends CActiveRecord
{
    public $nomor_valid;
    public $lampiran;
    public $seleksi;
    public $umur_awal;
    public $umur_akhir;
    public $pilih, $statuspengangkatan, $statusseleksi;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelamarT the static model class
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
		return 'pelamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, nama_pelamar, jeniskelamin, statusperkawinan, agama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendkualifikasi_id, profilrs_id, suku_id, pendidikan_id, jmlanak, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
			array('gajiygdiharapkan', 'numerical'),
			array('jenisidentitas, jeniskelamin, statusperkawinan, agama', 'length', 'max'=>20),
			array('noidentitas,surattandaregistrasi,suratizinpraktek, nama_pelamar, alamatemail, minatpekerjaan, suratizinpraktek_2, instansi_sip_2, instansi_sip', 'length', 'max'=>100),
			array('nama_keluarga, kodepos, notelp_pelamar, nomobile_pelamar, asalpelamar', 'length', 'max'=>50),
			array('tempatlahir_pelamar', 'length', 'max'=>30),
			array('warganegara_pelamar', 'length', 'max'=>25),
			array('photopelamar', 'length', 'max'=>200),
			array('tgl_lahirpelamar,masa_sip,masa_str, alamat_pelamar, tglditerima, tglmulaibekerja, ingintunjangan, keterangan_pelamar, filelamaran, update_time, update_loginpemakai_id, berlaku_s_d, statuspenilaian, tanggalpenilaian, menyetujui_tgl, mengetahui_tgl, masa_sip_2, tglmelamar, tgllowongan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglmelamar, pelamar_id, pendkualifikasi_id, profilrs_id, suku_id, pendidikan_id, tgllowongan, jenisidentitas, noidentitas, nama_pelamar, nama_keluarga, tempatlahir_pelamar, tgl_lahirpelamar, jeniskelamin, statusperkawinan, jmlanak, alamat_pelamar, kodepos, agama, alamatemail, notelp_pelamar, nomobile_pelamar, warganegara_pelamar, photopelamar, gajiygdiharapkan, tglditerima, tglmulaibekerja, ingintunjangan, keterangan_pelamar, minatpekerjaan, filelamaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, berlaku_s_d, statuspenilaian, tanggalpenilaian, menyetujui_id, menyetujui_tgl, mengetahui_id, mengetahui_tgl, asalpelamar, suratizinpraktek_2, instansi_sip_2, instansi_sip, masa_sip_2', 'safe', 'on'=>'search'),
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
			'pendkualifikasi' => array(self::BELONGS_TO, 'PendidikankualifikasiM', 'pendkualifikasi_id'),
			'pendidikan' => array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'suku' => array(self::BELONGS_TO, 'SukuM', 'suku_id'),
			'lingkungankerjaRs' => array(self::HAS_MANY, 'LingkungankerjaR', 'pelamar_id'),
			'kemampuanbahasaRs' => array(self::HAS_MANY, 'KemampuanbahasaR', 'pelamar_id'),
			'pegawaiMengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'mengetahui_id'),
			'pegawaiMenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'menyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pelamar_id' => 'ID Pelamar',
			'pendkualifikasi_id' => 'Pendidikan Kualifikasi',
			'profilrs_id' => 'Profil RS',
			'suku_id' => 'Suku',
			'pendidikan_id' => 'Pendidikan',
			'tgllowongan' => 'Tanggal Lowongan',
			'jenisidentitas' => 'Jenis Identitas',
			'noidentitas' => 'No. Identitas',
			'nama_pelamar' => 'Nama Pelamar',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pelamar' => 'Tempat Lahir',
			'tgl_lahirpelamar' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Status Perkawinan',
			'jmlanak' => 'Jumlah Anak',
			'alamat_pelamar' => 'Alamat Pelamar',
			'kodepos' => 'Kode Pos',
			'agama' => 'Agama',
			'alamatemail' => 'Email',
			'notelp_pelamar' => 'No. Telepon',
			'nomobile_pelamar' => 'No. Hp',
			'warganegara_pelamar' => 'Warga Negara',
			'photopelamar' => 'Photo',
			'gajiygdiharapkan' => 'Gaji yang diharapkan',
			'tglditerima' => 'Tanggal Diterima',
			'tglmulaibekerja' => 'Tanggal Mulai Bekerja',
			'ingintunjangan' => 'Tunjangan yang diinginkan',
			'keterangan_pelamar' => 'Keterangan Pelamar',
			'minatpekerjaan' => 'Minat Pekerjaan',
			'filelamaran' => 'File Lamaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'berlaku_s_d' => 'Berlaku Sampai Dengan',
            'tglmelamar' => 'Tanggal Melamar',
			'masa_sip' => 'Masa Berlaku Surat Izin Praktek',
			'masa_str' => 'Masa Berlaku Surat Tanda Registrasi',
			'surattandaregistrasi' => 'Surat Tanda Registrasi',
			'suratizinpraktek' => 'Surat Izin Praktik',
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

		if(!empty($this->pelamar_id)){
			$criteria->addCondition('pelamar_id = '.$this->pelamar_id);
		}
		if(!empty($this->pendkualifikasi_id)){
			$criteria->addCondition('pendkualifikasi_id = '.$this->pendkualifikasi_id);
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->suku_id)){
			$criteria->addCondition('suku_id = '.$this->suku_id);
		}
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition('pendidikan_id = '.$this->pendidikan_id);
		}
		$criteria->compare('LOWER(tgllowongan)',strtolower($this->tgllowongan),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nama_pelamar)',strtolower($this->nama_pelamar),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pelamar)',strtolower($this->tempatlahir_pelamar),true);
		$criteria->compare('LOWER(tgl_lahirpelamar)',strtolower($this->tgl_lahirpelamar),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		if(!empty($this->jmlanak)){
			$criteria->addCondition('jmlanak = '.$this->jmlanak);
		}
		$criteria->compare('LOWER(alamat_pelamar)',strtolower($this->alamat_pelamar),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pelamar)',strtolower($this->notelp_pelamar),true);
		$criteria->compare('LOWER(nomobile_pelamar)',strtolower($this->nomobile_pelamar),true);
		$criteria->compare('LOWER(warganegara_pelamar)',strtolower($this->warganegara_pelamar),true);
		$criteria->compare('LOWER(photopelamar)',strtolower($this->photopelamar),true);
		$criteria->compare('gajiygdiharapkan',$this->gajiygdiharapkan);
		$criteria->compare('LOWER(tglditerima)',strtolower($this->tglditerima),true);
		$criteria->compare('LOWER(tglmulaibekerja)',strtolower($this->tglmulaibekerja),true);
		$criteria->compare('LOWER(ingintunjangan)',strtolower($this->ingintunjangan),true);
		$criteria->compare('LOWER(keterangan_pelamar)',strtolower($this->keterangan_pelamar),true);
		$criteria->compare('LOWER(minatpekerjaan)',strtolower($this->minatpekerjaan),true);
		$criteria->compare('LOWER(filelamaran)',strtolower($this->filelamaran),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(berlaku_s_d)',strtolower($this->berlaku_s_d),true);

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
         * Pencarian dialog untuk proses kirim sms gateway.
         * @return CActiveDataProvider
         */
        public function searchDialogSms()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;

            $tgl_lowongan = $this->tglmelamar;
            $Tgl = (explode(" - ",$tgl_lowongan));
            
            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');

            $criteria->addBetweenCondition('DATE(tglmelamar)', $Tgl[0], $Tgl[1]);
            $criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
            $criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
            $criteria->compare('LOWER(nama_pelamar)',strtolower($this->nama_pelamar),true);
            $criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
            $criteria->compare('LOWER(tempatlahir_pelamar)',strtolower($this->tempatlahir_pelamar),true);
            $criteria->compare('LOWER(tgl_lahirpelamar)',strtolower($this->tgl_lahirpelamar),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            if(!empty($this->statusperkawinan)){
                    $criteria->addCondition("statusperkawinan = '".$this->statusperkawinan."'");
            }
            if(!empty($this->jmlanak)){
                    $criteria->addCondition('jmlanak = '.$this->jmlanak);
            }
            $criteria->compare('LOWER(alamat_pelamar)',strtolower($this->alamat_pelamar),true);
            $criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
            $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
            $criteria->compare('LOWER(notelp_pelamar)',strtolower($this->notelp_pelamar),true);
            $criteria->compare('LOWER(nomobile_pelamar)',strtolower($this->nomobile_pelamar),true);
            $criteria->compare('LOWER(warganegara_pelamar)',strtolower($this->warganegara_pelamar),true);
            $criteria->compare('LOWER(photopelamar)',strtolower($this->photopelamar),true);
            $criteria->compare('gajiygdiharapkan',$this->gajiygdiharapkan);
            $criteria->compare('LOWER(tglditerima)',strtolower($this->tglditerima),true);
            $criteria->compare('LOWER(tglmulaibekerja)',strtolower($this->tglmulaibekerja),true);
            $criteria->compare('LOWER(ingintunjangan)',strtolower($this->ingintunjangan),true);
            $criteria->compare('LOWER(keterangan_pelamar)',strtolower($this->keterangan_pelamar),true);
            $criteria->compare('LOWER(minatpekerjaan)',strtolower($this->minatpekerjaan),true);
            $criteria->compare('LOWER(filelamaran)',strtolower($this->filelamaran),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('LOWER(berlaku_s_d)',strtolower($this->berlaku_s_d),true);
            if($this->nomor_valid==1){
                $criteria->addCondition("length(nomobile_pelamar) >= 9 OR LEFT(nomobile_pelamar, 2) = '08' OR LEFT(nomobile_pelamar, 4) = '+628'");
            }

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}