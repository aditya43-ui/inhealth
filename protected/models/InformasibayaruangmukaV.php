<?php

/**
 * This is the model class for table "informasibayaruangmuka_v".
 *
 * The followings are the available columns in table 'informasibayaruangmuka_v':
 * @property integer $bayaruangmuka_id
 * @property integer $pembatalanuangmuka_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $pemakaianuangmuka_id
 * @property integer $tandabuktibayar_id
 * @property integer $instalasi_id
 * @property string $tgluangmuka
 * @property double $jumlahuangmuka
 * @property string $keteranganuangmuka
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tglperjanjian
 * @property string $keterangan_perjanjian
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $no_identitas_pasien
 * @property string $jenisidentitas
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $statusperkawinan
 * @property integer $kabupaten_id
 * @property integer $kelurahan_id
 * @property string $kabupaten_nama
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $no_rekam_medik
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $tgladmisi
 * @property string $tgl_pendaftaran
 * @property string $nobuktibayar
 * @property string $tglbuktibayar
 * @property string $carapembayaran
 * @property string $dengankartu
 * @property string $bankkartu
 * @property string $nokartu
 * @property string $nostrukkartu
 * @property string $darinama_bkm
 * @property double $jmlpembulatan
 * @property double $jmlpembayaran
 * @property double $biayaadministrasi
 * @property double $biayamaterai
 * @property double $uangditerima
 * @property double $uangkembalian
 * @property string $tglpembatalan
 * @property string $keterangan_batal
 * @property string $tglpemakaian
 * @property double $totaluangmuka
 * @property double $pemakaianuangmuka
 * @property double $sisauangmuka
 * @property string $ruangan_nama
 * @property string $instalasi_nama
 * @property string $no_pendaftaran
 */
class InformasibayaruangmukaV extends CActiveRecord
{
	
	public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasibayaruangmukaV the static model class
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
		return 'informasibayaruangmuka_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bayaruangmuka_id, pembatalanuangmuka_id, pasienadmisi_id, pasien_id, pendaftaran_id, ruangan_id, pemakaianuangmuka_id, tandabuktibayar_id, instalasi_id, rt, rw, kabupaten_id, kelurahan_id, kecamatan_id, propinsi_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly'=>true),
			array('jumlahuangmuka, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, totaluangmuka, pemakaianuangmuka, sisauangmuka', 'numerical'),
			array('keterangan_perjanjian', 'length', 'max'=>200),
			array('namadepan, jenisidentitas, jeniskelamin, no_mobile_pasien, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, kabupaten_nama, kelurahan_nama, kecamatan_nama, propinsi_nama, carabayar_nama, penjamin_nama, nobuktibayar, carapembayaran, dengankartu, ruangan_nama, instalasi_nama', 'length', 'max'=>50),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('bankkartu, nokartu, nostrukkartu, darinama_bkm', 'length', 'max'=>100),
			array('nouangmuka, tgluangmuka, keteranganuangmuka, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglperjanjian, tanggal_lahir, alamat_pasien, tgladmisi, tgl_pendaftaran, tglbuktibayar, tglpembatalan, keterangan_batal, tglpemakaian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nouangmuka, bayaruangmuka_id, pembatalanuangmuka_id, pasienadmisi_id, pasien_id, pendaftaran_id, ruangan_id, pemakaianuangmuka_id, tandabuktibayar_id, instalasi_id, tgluangmuka, jumlahuangmuka, keteranganuangmuka, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglperjanjian, keterangan_perjanjian, namadepan, nama_pasien, no_identitas_pasien, jenisidentitas, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, no_telepon_pasien, no_mobile_pasien, statusperkawinan, kabupaten_id, kelurahan_id, kabupaten_nama, kelurahan_nama, kecamatan_id, kecamatan_nama, propinsi_id, propinsi_nama, no_rekam_medik, carabayar_id, penjamin_id, carabayar_nama, penjamin_nama, tgladmisi, tgl_pendaftaran, nobuktibayar, tglbuktibayar, carapembayaran, dengankartu, bankkartu, nokartu, nostrukkartu, darinama_bkm, jmlpembulatan, jmlpembayaran, biayaadministrasi, biayamaterai, uangditerima, uangkembalian, tglpembatalan, keterangan_batal, tglpemakaian, totaluangmuka, pemakaianuangmuka, sisauangmuka, ruangan_nama, instalasi_nama, no_pendaftaran', 'safe', 'on'=>'search'),
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
			'bayaruangmuka_id' => 'Bayaruangmuka',
			'pembatalanuangmuka_id' => 'Pembatalanuangmuka',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'pemakaianuangmuka_id' => 'Pemakaianuangmuka',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'instalasi_id' => 'Instalasi',
			'tgluangmuka' => 'Tgluangmuka',
			'jumlahuangmuka' => 'Jumlahuangmuka',
			'keteranganuangmuka' => 'Keteranganuangmuka',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglperjanjian' => 'Tglperjanjian',
			'keterangan_perjanjian' => 'Keterangan Perjanjian',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'statusperkawinan' => 'Statusperkawinan',
			'kabupaten_id' => 'Kabupaten',
			'kelurahan_id' => 'Kelurahan',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'no_rekam_medik' => 'No. Rekam Medik',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'tgladmisi' => 'Tgladmisi',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'nobuktibayar' => 'No. Pembayaran',
			'tglbuktibayar' => 'Tglbuktibayar',
			'carapembayaran' => 'Carapembayaran',
			'dengankartu' => 'Dengankartu',
			'bankkartu' => 'Bankkartu',
			'nokartu' => 'Nokartu',
			'nostrukkartu' => 'Nostrukkartu',
			'darinama_bkm' => 'Darinama Bkm',
			'jmlpembulatan' => 'Jmlpembulatan',
			'jmlpembayaran' => 'Jmlpembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayamaterai' => 'Biayamaterai',
			'uangditerima' => 'Uang Diterima',
			'uangkembalian' => 'Uangkembalian',
			'tglpembatalan' => 'Tglpembatalan',
			'keterangan_batal' => 'Keterangan Batal',
			'tglpemakaian' => 'Tglpemakaian',
			'totaluangmuka' => 'Totaluangmuka',
			'pemakaianuangmuka' => 'Pemakaianuangmuka',
			'sisauangmuka' => 'Sisauangmuka',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'no_pendaftaran' => 'No. Pendaftaran',
            'nouangmuka' => 'No. Pembayaran',
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

		$criteria->addBetweenCondition('t.tgluangmuka::date', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->bayaruangmuka_id)){
			$criteria->addCondition('t.bayaruangmuka_id = '.$this->bayaruangmuka_id);
		}
		if(!empty($this->pembatalanuangmuka_id)){
			$criteria->addCondition('t.pembatalanuangmuka_id = '.$this->pembatalanuangmuka_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('t.pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pemakaianuangmuka_id)){
			$criteria->addCondition('t.pemakaianuangmuka_id = '.$this->pemakaianuangmuka_id);
		}
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('t.tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(t.tgluangmuka)',strtolower($this->tgluangmuka),true);
		$criteria->compare('LOWER(t.nouangmuka)',strtolower($this->nouangmuka),true);
		$criteria->compare('t.jumlahuangmuka',$this->jumlahuangmuka);
		$criteria->compare('LOWER(t.keteranganuangmuka)',strtolower($this->keteranganuangmuka),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(t.tglperjanjian)',strtolower($this->tglperjanjian),true);
		$criteria->compare('LOWER(t.keterangan_perjanjian)',strtolower($this->keterangan_perjanjian),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(t.jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('t.rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('t.rw = '.$this->rw);
		}
		$criteria->compare('LOWER(t.no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(t.no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(t.statusperkawinan)',strtolower($this->statusperkawinan),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(t.tglbuktibayar)',strtolower($this->tglbuktibayar),true);
		$criteria->compare('LOWER(t.carapembayaran)',strtolower($this->carapembayaran),true);
		$criteria->compare('LOWER(t.dengankartu)',strtolower($this->dengankartu),true);
		$criteria->compare('LOWER(t.bankkartu)',strtolower($this->bankkartu),true);
		$criteria->compare('LOWER(t.nokartu)',strtolower($this->nokartu),true);
		$criteria->compare('LOWER(t.nostrukkartu)',strtolower($this->nostrukkartu),true);
		$criteria->compare('LOWER(t.darinama_bkm)',strtolower($this->darinama_bkm),true);
		$criteria->compare('t.jmlpembulatan',$this->jmlpembulatan);
		$criteria->compare('t.jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.biayamaterai',$this->biayamaterai);
		$criteria->compare('t.uangditerima',$this->uangditerima);
		$criteria->compare('t.uangkembalian',$this->uangkembalian);
		$criteria->compare('LOWER(t.tglpembatalan)',strtolower($this->tglpembatalan),true);
		$criteria->compare('LOWER(t.keterangan_batal)',strtolower($this->keterangan_batal),true);
		$criteria->compare('LOWER(t.tglpemakaian)',strtolower($this->tglpemakaian),true);
		$criteria->compare('t.totaluangmuka',$this->totaluangmuka);
		$criteria->compare('t.pemakaianuangmuka',$this->pemakaianuangmuka);
		$criteria->compare('t.sisauangmuka',$this->sisauangmuka);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(t.instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);

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
}