<?php

/**
 * This is the model class for table "rincianbiayafarmasird_v".
 *
 * The followings are the available columns in table 'rincianbiayafarmasird_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $penjualanresep_id
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property integer $pasienpegawai_id
 * @property integer $pasienprofilrs_id
 * @property integer $pasieninstalasiunit_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $gelardepan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpenjualan
 * @property integer $pasienadmisi_id
 * @property integer $reseptur_id
 * @property integer $pendaftaran_id
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kekuatan
 * @property integer $racikan_id
 * @property integer $shift_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $biayaservice
 * @property double $biayakemasan
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $update_loginpemakai_id
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $tipepaket_id
 * @property integer $oasudahbayar_id
 * @property double $biayaadministrasi
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruanganasal_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $nama_pj
 * @property string $alamat_pj
 */
class RincianbiayafarmasirdV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianbiayafarmasirdV the static model class
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
		return 'rincianbiayafarmasird_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, penjualanresep_id, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id, pegawai_id, carabayar_id, penjamin_id, pasienadmisi_id, reseptur_id, pendaftaran_id, obatalkes_id, jenisobatalkes_id, kekuatan, racikan_id, shift_id, rke, sumberdana_id, satuankecil_id, tipepaket_id, oasudahbayar_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, biayaservice, biayakemasan, biayaadministrasi, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'numerical'),
			array('no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('namadepan, jeniskelamin, obatalkes_kadarobat, no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, noresep, nama_pegawai, carabayar_nama, penjamin_nama, jenisobatalkes_nama, obatalkes_golongan, obatalkes_kategori, sumberdana_nama, satuankecil_nama, ruangan_nama, nama_pj', 'length', 'max'=>50),
			array('nama_bin, signa_oa, umur', 'length', 'max'=>30),
			array('tempat_lahir', 'length', 'max'=>25),
			array('jenispenjualan, etiket, ruanganasal_nama', 'length', 'max'=>100),
			array('obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('r, oa', 'length', 'max'=>2),
			array('tanggal_lahir, alamat_pasien, tglresep, tglpenjualan, tglpelayanan, create_time, update_time, create_loginpemakai_id, create_ruangan, update_loginpemakai_id, tgl_pendaftaran, alamat_pj', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, no_rekam_medik, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, penjualanresep_id, jenispenjualan, tglresep, noresep, pasienpegawai_id, pasienprofilrs_id, pasieninstalasiunit_id, pegawai_id, nama_pegawai, gelardepan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglpenjualan, pasienadmisi_id, reseptur_id, pendaftaran_id, obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kekuatan, racikan_id, shift_id, tglpelayanan, r, rke, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, biayaservice, biayakemasan, oa, create_time, update_time, create_loginpemakai_id, create_ruangan, update_loginpemakai_id, sumberdana_id, sumberdana_nama, satuankecil_id, satuankecil_nama, tipepaket_id, oasudahbayar_id, biayaadministrasi, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, ruangan_id, ruangan_nama, ruanganasal_nama, no_pendaftaran, tgl_pendaftaran, umur, nama_pj, alamat_pj', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'penjualanresep_id' => 'Penjualanresep',
			'jenispenjualan' => 'Jenispenjualan',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'pasienpegawai_id' => 'Pasienpegawai',
			'pasienprofilrs_id' => 'Pasienprofilrs',
			'pasieninstalasiunit_id' => 'Pasieninstalasiunit',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'gelardepan' => 'Gelardepan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'tglpenjualan' => 'Tglpenjualan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'reseptur_id' => 'Reseptur',
			'pendaftaran_id' => 'Pendaftaran',
			'obatalkes_id' => 'Obatalkes',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'kekuatan' => 'Kekuatan',
			'racikan_id' => 'Racikan',
			'shift_id' => 'Shift',
			'tglpelayanan' => 'Tglpelayanan',
			'r' => 'R',
			'rke' => 'Rke',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'signa_oa' => 'Signa Oa',
			'harganetto_oa' => 'Harganetto Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'etiket' => 'Etiket',
			'biayaservice' => 'Biayaservice',
			'biayakemasan' => 'Biayakemasan',
			'oa' => 'Oa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'sumberdana_id' => 'Sumberdana',
			'sumberdana_nama' => 'Sumberdana Nama',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'tipepaket_id' => 'Tipepaket',
			'oasudahbayar_id' => 'Oasudahbayar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'nama_pj' => 'Nama Pj',
			'alamat_pj' => 'Alamat Pj',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('pasienpegawai_id',$this->pasienpegawai_id);
		$criteria->compare('pasienprofilrs_id',$this->pasienprofilrs_id);
		$criteria->compare('pasieninstalasiunit_id',$this->pasieninstalasiunit_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(alamat_pj)',strtolower($this->alamat_pj),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('pasienpegawai_id',$this->pasienpegawai_id);
		$criteria->compare('pasienprofilrs_id',$this->pasienprofilrs_id);
		$criteria->compare('pasieninstalasiunit_id',$this->pasieninstalasiunit_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('racikan_id',$this->racikan_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('LOWER(tglpelayanan)',strtolower($this->tglpelayanan),true);
		$criteria->compare('LOWER(r)',strtolower($this->r),true);
		$criteria->compare('rke',$this->rke);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)',strtolower($this->signa_oa),true);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('LOWER(etiket)',strtolower($this->etiket),true);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('LOWER(oa)',strtolower($this->oa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('oasudahbayar_id',$this->oasudahbayar_id);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('LOWER(alamat_pj)',strtolower($this->alamat_pj),true);
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