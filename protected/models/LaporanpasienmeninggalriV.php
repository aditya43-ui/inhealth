<?php

/**
 * This is the model class for table "laporanpasienmeninggalri_v".
 *
 * The followings are the available columns in table 'laporanpasienmeninggalri_v':
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $alamat_pasien
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $umur
 * @property string $tanggal_lahir
 * @property string $golongandarah
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $kunjungan
 * @property string $nama_pegawai
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $no_urutantri
 * @property string $kelompokumur_nama
 * @property string $golonganumur_nama
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $kelompokumur_id
 * @property integer $golonganumur_id
 * @property string $statusperiksa
 * @property integer $pegawai_id
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $agama
 * @property string $statusperkawinan
 * @property string $rhesus
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property string $transportasi
 * @property string $kondisipulang
 * @property string $carakeluar
 * @property integer $pasienpulang_id
 * @property integer $pasienadmisi_id
 * @property string $tglpasienpulang
 * @property integer $rt
 * @property integer $rw
 * @property string $tgl_meninggal
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $satuanlamarawat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class LaporanpasienmeninggalriV extends CActiveRecord
{
           public $tgl_awal;
        public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpasienmeninggalriV the static model class
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
		return 'laporanpasienmeninggalri_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, anakke, jumlah_bersaudara, ruangan_id, carabayar_id, penjamin_id, kelompokumur_id, golonganumur_id, pegawai_id, propinsi_id, kabupaten_id, kecamatan_id, kelurahan_id, instalasi_id, caramasuk_id, pasienpulang_id, pasienadmisi_id, rt, rw, lamarawat', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, jeniskelamin, no_mobile_pasien, agama, statusperkawinan, rhesus, namadepan', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, carabayar_nama, penjamin_nama, kunjungan, nama_pegawai, ruangan_nama, statusperiksa, propinsi_nama, kabupaten_nama, kecamatan_nama, kelurahan_nama, instalasi_nama, caramasuk_nama, transportasi, kondisipulang, carakeluar, satuanlamarawat', 'length', 'max'=>50),
			array('nama_bin, umur, no_identitas_pasien', 'length', 'max'=>30),
			array('tempat_lahir, kelompokumur_nama, golonganumur_nama', 'length', 'max'=>25),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('golongandarah', 'length', 'max'=>2),
			array('no_urutantri', 'length', 'max'=>6),
			array('penerimapasien', 'length', 'max'=>100),
			array('kondisikeluar_id, tgl_pendaftaran, alamat_pasien, tanggal_lahir, tglpasienpulang, tgl_meninggal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kondisikeluar_id, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, alamat_pasien, no_telepon_pasien, no_mobile_pasien, anakke, jumlah_bersaudara, umur, tanggal_lahir, golongandarah, carabayar_nama, penjamin_nama, kunjungan, nama_pegawai, ruangan_id, ruangan_nama, no_urutantri, kelompokumur_nama, golonganumur_nama, carabayar_id, penjamin_id, kelompokumur_id, golonganumur_id, statusperiksa, pegawai_id, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kecamatan_id, kecamatan_nama, kelurahan_id, kelurahan_nama, agama, statusperkawinan, rhesus, instalasi_id, instalasi_nama, caramasuk_id, caramasuk_nama, transportasi, kondisipulang, carakeluar, pasienpulang_id, pasienadmisi_id, tglpasienpulang, rt, rw, tgl_meninggal, no_identitas_pasien, namadepan, penerimapasien, lamarawat, satuanlamarawat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'umur' => 'Umur',
			'tanggal_lahir' => 'Tanggal Lahir',
			'golongandarah' => 'Golongandarah',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'kunjungan' => 'Kunjungan',
			'nama_pegawai' => 'Nama Pegawai',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'no_urutantri' => 'No. Urutantri',
			'kelompokumur_nama' => 'Kelompokumur Nama',
			'golonganumur_nama' => 'Golonganumur Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'kelompokumur_id' => 'Kelompokumur',
			'golonganumur_id' => 'Golonganumur',
			'statusperiksa' => 'Statusperiksa',
			'pegawai_id' => 'Pegawai',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'rhesus' => 'Rhesus',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Cara Masuk',
			'transportasi' => 'Transportasi',
			'kondisipulang' => 'Kondisi Pulang',
			'carakeluar' => 'Carakeluar',
			'pasienpulang_id' => 'Pasienpulang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tglpasienpulang' => 'Tglpasienpulang',
			'rt' => 'RT',
			'rw' => 'RW',
			'tgl_meninggal' => 'Tanggal Meninggal',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'satuanlamarawat' => 'Satuanlamarawat',
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
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
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelompokumur_id',$this->kelompokumur_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
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
}