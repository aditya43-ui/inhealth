<?php

/**
 * This is the model class for table "laporanpengeluaranobatgratis_v".
 *
 * The followings are the available columns in table 'laporanpengeluaranobatgratis_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $permohonanoa_id
 * @property string $permohonanoa_tgl
 * @property string $permohonanoa_nomor
 * @property integer $penjualanresep_id
 * @property string $tglpenjualan
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property string $permohonanoa_nosurat
 * @property string $permohonanoa_instansi
 * @property string $pemohon_jenisidentitas
 * @property string $pemohon_noidentitas
 * @property string $pemohon_nama
 * @property string $pemohon_jeniskelamin
 * @property string $pemohon_alamat
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
 * @property string $pemohon_notelp
 * @property string $pemohon_nomobile
 * @property string $pemohon_alamatemail
 * @property string $permohonan_alasan
 * @property string $permohonan_keterangan
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_nip
 * @property string $pegawaimenyetujui_jenisidentitas
 * @property string $pegawaimenyetujui_noidentitas
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $stokobatalkes_id
 * @property integer $permohonanoadetail_id
 * @property integer $obatalkespasien_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property double $permohonanoadetail_qty
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property double $biayaservice
 * @property double $biayakonseling
 * @property double $jasadokterresep
 * @property double $biayakemasan
 * @property double $biayaadministrasi
 * @property double $tarifcyto
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 */
class LaporanpengeluaranobatgratisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengeluaranobatgratisV the static model class
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
		return 'laporanpengeluaranobatgratis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, permohonanoa_id, penjualanresep_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, pegawaimengetahui_id, pegawaimenyetujui_id, profilrs_id, stokobatalkes_id, jenisobatalkes_id, obatalkes_id, satuankecil_id', 'numerical', 'integerOnly'=>true),
			array('permohonanoadetail_qty, qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'numerical'),
			array('instalasi_nama, ruangan_nama, permohonanoa_nomor, noresep, permohonanoa_nosurat, pemohon_nama, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, pegawaimengetahui_nama, pegawaimenyetujui_nama, jenisobatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, satuankecil_nama', 'length', 'max'=>50),
			array('jenispenjualan, pemohon_alamatemail, pegawaimengetahui_noidentitas, pegawaimenyetujui_noidentitas, nama_rumahsakit', 'length', 'max'=>100),
			array('permohonanoa_instansi, obatalkes_barcode, obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('pemohon_jenisidentitas, pemohon_jeniskelamin, pemohon_notelp, pegawaimengetahui_jenisidentitas, pegawaimenyetujui_jenisidentitas, obatalkes_kadarobat', 'length', 'max'=>20),
			array('pemohon_noidentitas, pemohon_nomobile, pegawaimengetahui_nip, pegawaimenyetujui_nip', 'length', 'max'=>30),
			array('pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan, nokode_rumahsakit, jenisobatalkes_kode', 'length', 'max'=>10),
			array('pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('permohonanoa_tgl, tglpenjualan, tglresep, pemohon_alamat, permohonan_alasan, permohonan_keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, permohonanoa_id, permohonanoa_tgl, permohonanoa_nomor, penjualanresep_id, tglpenjualan, jenispenjualan, tglresep, noresep, permohonanoa_nosurat, permohonanoa_instansi, pemohon_jenisidentitas, pemohon_noidentitas, pemohon_nama, pemohon_jeniskelamin, pemohon_alamat, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, pemohon_notelp, pemohon_nomobile, pemohon_alamatemail, permohonan_alasan, permohonan_keterangan, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_nip, pegawaimenyetujui_jenisidentitas, pegawaimenyetujui_noidentitas, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, profilrs_id, nokode_rumahsakit, nama_rumahsakit, stokobatalkes_id, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, obatalkes_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, satuankecil_id, satuankecil_nama, permohonanoadetail_qty, qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, biayaservice, biayakonseling, jasadokterresep, biayakemasan, biayaadministrasi, tarifcyto, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'permohonanoa_id' => 'Permohonanoa',
			'permohonanoa_tgl' => 'Permohonanoa Tgl',
			'permohonanoa_nomor' => 'Permohonanoa Nomor',
			'penjualanresep_id' => 'Penjualanresep',
			'tglpenjualan' => 'Tglpenjualan',
			'jenispenjualan' => 'Jenispenjualan',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'permohonanoa_nosurat' => 'Permohonanoa Nosurat',
			'permohonanoa_instansi' => 'Permohonanoa Instansi',
			'pemohon_jenisidentitas' => 'Pemohon Jenisidentitas',
			'pemohon_noidentitas' => 'Pemohon Noidentitas',
			'pemohon_nama' => 'Pemohon Nama',
			'pemohon_jeniskelamin' => 'Pemohon Jeniskelamin',
			'pemohon_alamat' => 'Pemohon Alamat',
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
			'pemohon_notelp' => 'Pemohon Notelp',
			'pemohon_nomobile' => 'Pemohon Nomobile',
			'pemohon_alamatemail' => 'Pemohon Alamatemail',
			'permohonan_alasan' => 'Permohonan Alasan',
			'permohonan_keterangan' => 'Permohonan Keterangan',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_jenisidentitas' => 'Pegawaimengetahui Jenisidentitas',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'pegawaimenyetujui_id' => 'Pegawaimenyetujui',
			'pegawaimenyetujui_nip' => 'Pegawaimenyetujui Nip',
			'pegawaimenyetujui_jenisidentitas' => 'Pegawaimenyetujui Jenisidentitas',
			'pegawaimenyetujui_noidentitas' => 'Pegawaimenyetujui Noidentitas',
			'pegawaimenyetujui_gelardepan' => 'Pegawaimenyetujui Gelardepan',
			'pegawaimenyetujui_nama' => 'Pegawaimenyetujui Nama',
			'pegawaimenyetujui_gelarbelakang' => 'Pegawaimenyetujui Gelarbelakang',
			'profilrs_id' => 'Profilrs',
			'nokode_rumahsakit' => 'Nokode Rumahsakit',
			'nama_rumahsakit' => 'Nama Rumahsakit',
			'stokobatalkes_id' => 'Stokobatalkes',
			// RND-4829 field sudah dihapus 'permohonanoadetail_id' => 'Permohonanoadetail',
			// RND-4829 field sudah dihapus 'obatalkespasien_id' => 'Obatalkespasien',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_kode' => 'Jenisobatalkes Kode',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_barcode' => 'Obatalkes Barcode',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_namalain' => 'Obatalkes Namalain',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'permohonanoadetail_qty' => 'Permohonanoadetail Jumlah',
			'qty_oa' => 'Jumlah Oa',
			'hargasatuan_oa' => 'Hargasatuan Oa',
			'harganetto_oa' => 'Harganetto Oa',
			'hargajual_oa' => 'Hargajual Oa',
			'biayaservice' => 'Biayaservice',
			'biayakonseling' => 'Biayakonseling',
			'jasadokterresep' => 'Jasadokterresep',
			'biayakemasan' => 'Biayakemasan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'tarifcyto' => 'Tarifcyto',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Subsidiasuransi',
			'subsidipemerintah' => 'Subsidipemerintah',
			'subsidirs' => 'Subsidirs',
			'iurbiaya' => 'Iurbiaya',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('permohonanoa_id',$this->permohonanoa_id);
		$criteria->compare('LOWER(permohonanoa_tgl)',strtolower($this->permohonanoa_tgl),true);
		$criteria->compare('LOWER(permohonanoa_nomor)',strtolower($this->permohonanoa_nomor),true);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);
		$criteria->compare('LOWER(tglpenjualan)',strtolower($this->tglpenjualan),true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('LOWER(permohonanoa_nosurat)',strtolower($this->permohonanoa_nosurat),true);
		$criteria->compare('LOWER(permohonanoa_instansi)',strtolower($this->permohonanoa_instansi),true);
		$criteria->compare('LOWER(pemohon_jenisidentitas)',strtolower($this->pemohon_jenisidentitas),true);
		$criteria->compare('LOWER(pemohon_noidentitas)',strtolower($this->pemohon_noidentitas),true);
		$criteria->compare('LOWER(pemohon_nama)',strtolower($this->pemohon_nama),true);
		$criteria->compare('LOWER(pemohon_jeniskelamin)',strtolower($this->pemohon_jeniskelamin),true);
		$criteria->compare('LOWER(pemohon_alamat)',strtolower($this->pemohon_alamat),true);
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
		$criteria->compare('LOWER(pemohon_notelp)',strtolower($this->pemohon_notelp),true);
		$criteria->compare('LOWER(pemohon_nomobile)',strtolower($this->pemohon_nomobile),true);
		$criteria->compare('LOWER(pemohon_alamatemail)',strtolower($this->pemohon_alamatemail),true);
		$criteria->compare('LOWER(permohonan_alasan)',strtolower($this->permohonan_alasan),true);
		$criteria->compare('LOWER(permohonan_keterangan)',strtolower($this->permohonan_keterangan),true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('LOWER(pegawaimenyetujui_nip)',strtolower($this->pegawaimenyetujui_nip),true);
		$criteria->compare('LOWER(pegawaimenyetujui_jenisidentitas)',strtolower($this->pegawaimenyetujui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_noidentitas)',strtolower($this->pegawaimenyetujui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(nokode_rumahsakit)',strtolower($this->nokode_rumahsakit),true);
		$criteria->compare('LOWER(nama_rumahsakit)',strtolower($this->nama_rumahsakit),true);
		$criteria->compare('stokobatalkes_id',$this->stokobatalkes_id);
		// RND-4829 field sudah dihapus  $criteria->compare('permohonanoadetail_id',$this->permohonanoadetail_id);
		// RND-4829 field sudah dihapus  $criteria->compare('obatalkespasien_id',$this->obatalkespasien_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('permohonanoadetail_qty',$this->permohonanoadetail_qty);
		$criteria->compare('qty_oa',$this->qty_oa);
		$criteria->compare('hargasatuan_oa',$this->hargasatuan_oa);
		$criteria->compare('harganetto_oa',$this->harganetto_oa);
		$criteria->compare('hargajual_oa',$this->hargajual_oa);
		$criteria->compare('biayaservice',$this->biayaservice);
		$criteria->compare('biayakonseling',$this->biayakonseling);
		$criteria->compare('jasadokterresep',$this->jasadokterresep);
		$criteria->compare('biayakemasan',$this->biayakemasan);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('tarifcyto',$this->tarifcyto);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subsidiasuransi',$this->subsidiasuransi);
		$criteria->compare('subsidipemerintah',$this->subsidipemerintah);
		$criteria->compare('subsidirs',$this->subsidirs);
		$criteria->compare('iurbiaya',$this->iurbiaya);

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