<?php

/**
 * This is the model class for table "rincianbiayafarmasirawatinap_v".
 *
 * The followings are the available columns in table 'rincianbiayafarmasirawatinap_v':
 * @property integer $profilrs_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $umur
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $instalasi_nama
 * @property integer $instalasi_id
 * @property integer $unitlayanan_id
 * @property string $unitlayanan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $nama_pj
 * @property string $alamat_pj
 * @property integer $obatalkespasien_id
 * @property string $tglpelayanan
 * @property double $hargasatuan_oa
 * @property double $qty_oa
 * @property string $satuankecil_nama
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $tgl_pendaftaran
 * @property string $caramasuk_nama
 * @property integer $caramasuk_id
 * @property string $tgladmisi
 * @property string $tglpasienpulang
 * @property string $carakeluar
 * @property string $kondisipulang
 * @property string $ruanganakhir_nama
 * @property integer $ruanganakhir_id
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property integer $penjualanresep_id
 * @property integer $reseptur_id
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class RincianbiayafarmasirawatinapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianbiayafarmasirawatinapV the static model class
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
		return 'rincianbiayafarmasirawatinap_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pasien_id, rt, rw, pendaftaran_id, instalasi_id, unitlayanan_id, pegawai_id, carabayar_id, penjamin_id, jeniskasuspenyakit_id, obatalkespasien_id, jenisobatalkes_id, obatalkes_id, kelaspelayanan_id, caramasuk_id, ruanganakhir_id, lamarawat, penjualanresep_id, reseptur_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('hargasatuan_oa, qty_oa, discount, subsidiasuransi, subsidirs, iurbiaya', 'numerical'),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, instalasi_nama, unitlayanan_nama, nama_pegawai, carabayar_nama, penjamin_nama, nama_pj, satuankecil_nama, jenisobatalkes_nama, kelaspelayanan_nama, caramasuk_nama, carakeluar, kondisipulang, ruanganakhir_nama, noresep, ruangan_nama', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('jeniskasuspenyakit_nama, penerimapasien, jenispenjualan, instalasiasal_nama, ruanganasal_nama', 'length', 'max'=>100),
			array('obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('oa', 'length', 'max'=>2),
			array('alamat_pasien, alamat_pj, tglpelayanan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran, tgladmisi, tglpasienpulang, tglpenjualan, tglresep', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, pasien_id, no_rekam_medik, namadepan, nama_pasien, jeniskelamin, umur, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, instalasi_nama, instalasi_id, unitlayanan_id, unitlayanan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, nama_pj, alamat_pj, obatalkespasien_id, tglpelayanan, hargasatuan_oa, qty_oa, satuankecil_nama, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_id, obatalkes_kode, obatalkes_nama, discount, subsidiasuransi, subsidirs, iurbiaya, oa, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelaspelayanan_id, kelaspelayanan_nama, tgl_pendaftaran, caramasuk_nama, caramasuk_id, tgladmisi, tglpasienpulang, carakeluar, kondisipulang, ruanganakhir_nama, ruanganakhir_id, penerimapasien, lamarawat, penjualanresep_id, reseptur_id, tglpenjualan, jenispenjualan, tglresep, noresep, instalasiasal_nama, ruanganasal_nama, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'profilrs_id' => 'Profilrs',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'umur' => 'Umur',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'instalasi_nama' => 'Instalasi Nama',
			'instalasi_id' => 'Instalasi',
			'unitlayanan_id' => 'Unitlayanan',
			'unitlayanan_nama' => 'Unitlayanan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'nama_pj' => 'Nama Pj',
			'alamat_pj' => 'Alamat Pj',
			'obatalkespasien_id' => 'Obatalkespasien',
			'tglpelayanan' => 'Tglpelayanan',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'qty_oa' => 'Jumlah Oa',
			'satuankecil_nama' => 'Satuankecil Nama',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
			'oa' => 'Oa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'caramasuk_nama' => 'Caramasuk Nama',
			'caramasuk_id' => 'Caramasuk',
			'tgladmisi' => 'Tgladmisi',
			'tglpasienpulang' => 'Tglpasienpulang',
			'carakeluar' => 'Carakeluar',
			'kondisipulang' => 'Kondisipulang',
			'ruanganakhir_nama' => 'Ruanganakhir Nama',
			'ruanganakhir_id' => 'Ruanganakhir',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'penjualanresep_id' => 'Penjualanresep',
			'reseptur_id' => 'Reseptur',
			'tglpenjualan' => 'Tglpenjualan',
			'jenispenjualan' => 'Jenispenjualan',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('unitlayanan_id',$this->unitlayanan_id);
		$criteria->compare('LOWER(unitlayanan_nama)',strtolower($this->unitlayanan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(alamat_pj)',strtolower($this->alamat_pj),true);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('ruanganakhir_id',$this->ruanganakhir_id);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('unitlayanan_id',$this->unitlayanan_id);
		$criteria->compare('LOWER(unitlayanan_nama)',strtolower($this->unitlayanan_nama),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(alamat_pj)',strtolower($this->alamat_pj),true);
		$criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(ruanganakhir_nama)',strtolower($this->ruanganakhir_nama),true);
		$criteria->compare('ruanganakhir_id',$this->ruanganakhir_id);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

    public function getNamaPasienPendaftar()
    {
		return $this->namadepan.' '.$this->nama_pasien; 	     
    }

    public function getAlamatPasienPendaftar()
    {
		return $this->alamat_pasien.' Rt/Rw. '.$this->rt.' / '.$this->rw; 	     
    }

    public function getDokterPemeriksa()
    {
		return $this->gelardepan.' '.$this->nama_pegawai; 	     
    }

    public function getCarabayarPenjamin()
    {
		return $this->carabayar_nama.' / '.$this->penjamin_nama; 	     
    }
}