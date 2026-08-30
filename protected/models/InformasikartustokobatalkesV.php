<?php

/**
 * This is the model class for table "informasikartustokobatalkes_v".
 *
 * The followings are the available columns in table 'informasikartustokobatalkes_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $stokobatalkes_id
 * @property integer $penerimaandetail_id
 * @property integer $penerimaanbarang_id
 * @property string $tglterimabarang
 * @property string $noterimabarang
 * @property string $tglsuratjalan
 * @property string $nosuratjalan
 * @property integer $fakturpembelian_id
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property integer $returdetail_id
 * @property integer $returpembelian_id
 * @property string $tglreturpembelian
 * @property string $noretur
 * @property string $alasanreturpembelian
 * @property string $keteranganreturpembelian
 * @property integer $terimamutasidetail_id
 * @property integer $terimamutasi_id
 * @property string $tglterimamutasi
 * @property string $noterimamutasi
 * @property integer $returresepdet_id
 * @property integer $returresep_id
 * @property string $tglreturresep
 * @property string $noreturresep
 * @property string $alasanreturresep
 * @property string $keteranganreturresep
 * @property integer $mutasioadetail_id
 * @property integer $mutasioaruangan_id
 * @property string $tglmutasioa
 * @property string $nomutasioa
 * @property integer $obatalkespasien_id
 * @property integer $penjualanresep_id
 * @property string $tglresep
 * @property string $noresep
 * @property integer $pemusnahanoadetail_id
 * @property integer $pemusnahanobatalkes_id
 * @property string $tglpemusnahan
 * @property string $nopemusnahan
 * @property integer $formstokopname_id
 * @property integer $formuliropname_id
 * @property string $tglformulir
 * @property string $noformulir
 * @property integer $stokopnamedet_id
 * @property integer $stokopname_id
 * @property string $tglstokopname
 * @property string $nostokopname
 * @property integer $pemakaianobatdetail_id
 * @property integer $pemakaianobat_id
 * @property string $tglpemakaianobat
 * @property string $nopemakaian_obat
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property boolean $jenisobatalkes_farmasi
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $asalbarang_id
 * @property string $asalbarang_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $stokobatalkesasal_id
 * @property string $tglterima
 * @property string $tglkadaluarsa
 * @property string $nobatch
 * @property string $tglstok_in
 * @property string $tglstok_out
 * @property double $qtystok_in
 * @property double $qtystok_out
 * @property double $harganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $persenppn
 * @property double $persenpph
 * @property double $persenmargin
 * @property double $jmlmargin
 * @property boolean $stokoa_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InformasikartustokobatalkesV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasikartustokobatalkesV the static model class
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
		return 'informasikartustokobatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, stokobatalkes_id, penerimaandetail_id, penerimaanbarang_id, fakturpembelian_id, returdetail_id, returpembelian_id, terimamutasidetail_id, terimamutasi_id, returresepdet_id, returresep_id, mutasioadetail_id, mutasioaruangan_id, obatalkespasien_id, penjualanresep_id, pemusnahanoadetail_id, pemusnahanobatalkes_id, formstokopname_id, formuliropname_id, stokopnamedet_id, stokopname_id, pemakaianobatdetail_id, pemakaianobat_id, jenisobatalkes_id, obatalkes_id, asalbarang_id, satuankecil_id, stokobatalkesasal_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('qtystok_in, qtystok_out, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin', 'numerical'),
			array('instalasi_nama, ruangan_nama, nosuratjalan, nofaktur, noretur, noreturresep, noresep, noformulir, nostokopname, jenisobatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, asalbarang_nama, satuankecil_nama, nobatch', 'length', 'max'=>50),
			array('noterimabarang, noterimamutasi, nomutasioa, nopemakaian_obat, obatalkes_kadarobat', 'length', 'max'=>20),
			array('alasanreturpembelian, alasanreturresep, nopemusnahan, obatalkes_barcode, obatalkes_kode, obatalkes_nama', 'length', 'max'=>200),
			array('jenisobatalkes_kode', 'length', 'max'=>10),
			array('tglterimabarang, tglsuratjalan, tglfaktur, tglreturpembelian, keteranganreturpembelian, tglterimamutasi, tglreturresep, keteranganreturresep, tglmutasioa, tglresep, tglpemusnahan, tglformulir, tglstokopname, tglpemakaianobat, jenisobatalkes_farmasi, tglterima, tglkadaluarsa, tglstok_in, tglstok_out, stokoa_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, stokobatalkes_id, penerimaandetail_id, penerimaanbarang_id, tglterimabarang, noterimabarang, tglsuratjalan, nosuratjalan, fakturpembelian_id, tglfaktur, nofaktur, returdetail_id, returpembelian_id, tglreturpembelian, noretur, alasanreturpembelian, keteranganreturpembelian, terimamutasidetail_id, terimamutasi_id, tglterimamutasi, noterimamutasi, returresepdet_id, returresep_id, tglreturresep, noreturresep, alasanreturresep, keteranganreturresep, mutasioadetail_id, mutasioaruangan_id, tglmutasioa, nomutasioa, obatalkespasien_id, penjualanresep_id, tglresep, noresep, pemusnahanoadetail_id, pemusnahanobatalkes_id, tglpemusnahan, nopemusnahan, formstokopname_id, formuliropname_id, tglformulir, noformulir, stokopnamedet_id, stokopname_id, tglstokopname, nostokopname, pemakaianobatdetail_id, pemakaianobat_id, tglpemakaianobat, nopemakaian_obat, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, jenisobatalkes_farmasi, obatalkes_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, asalbarang_id, asalbarang_nama, satuankecil_id, satuankecil_nama, stokobatalkesasal_id, tglterima, tglkadaluarsa, nobatch, tglstok_in, tglstok_out, qtystok_in, qtystok_out, harganetto, persendiscount, jmldiscount, persenppn, persenpph, persenmargin, jmlmargin, stokoa_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'stokobatalkes_id' => 'Stok Obat Alkes',
			'penerimaandetail_id' => 'Penerimaan Obat Alkes',
			'penerimaanbarang_id' => 'Penerimaan Obat Alkes',
			'tglterimabarang' => 'Tanggal Terima',
			'noterimabarang' => 'No. Terima',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'returpembelian_id' => 'Retur Pembelian',
			'tglreturpembelian' => 'Tanggal Retur Pembelian',
			'noretur' => 'No. Retur Pembelian',
			'alasanreturpembelian' => 'Alasan Retur Pembelian',
			'keteranganreturpembelian' => 'Keterangan Retur Pembelian',
			'terimamutasidetail_id' => 'Penerimaan Mutasi',
			'terimamutasi_id' => 'Penerimaan Mutasi',
			'tglterimamutasi' => 'Tanggal Terima Mutasi',
			'noterimamutasi' => 'No. Penerimaan Mutasi',
			'returresepdet_id' => 'Retur Resep',
			'returresep_id' => 'Retur Resep',
			'tglreturresep' => 'Tanggal Retur Resep',
			'noreturresep' => 'No. Retur Resep',
			'alasanreturresep' => 'Alasan Retur Resep',
			'keteranganreturresep' => 'Keterangan Retur Resep',
			'returdetail_id' => 'Retur Penerimaan',
			'returpenerimaan_id' => 'Retur Pembelian',
			'tglreturterima' => 'Tglreturterima',
			'mutasioadetail_id' => 'Mutasi Obat Alkes',
			'mutasioaruangan_id' => 'Mutasi Obat Alkes',
			'tglmutasioa' => 'Tanggal Mutasi',
			'nomutasioa' => 'Nomutasioa',
			'obatalkespasien_id' => 'Obatalkespasien',
			'penjualanresep_id' => 'Penjualan Resep',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'pemusnahanoadetail_id' => 'Pemusnahanoadetail',
			'pemusnahanobatalkes_id' => 'Pemusnahan Obat Alkes',
			'tglpemusnahan' => 'Tgl. Pemusnahan',
			'nopemusnahan' => 'No Pemusnahan',
			'formstokopname_id' => 'Formstokopname',
			'formuliropname_id' => 'Formuliropname',
			'tglformulir' => 'Tglformulir',
			'noformulir' => 'Noformulir',
			'stokopnamedet_id' => 'Stokopnamedet',
			'stokopname_id' => 'Stok Opname',
			'tglstokopname' => 'Tglstokopname',
			'nostokopname' => 'Nostokopname',
			'jenisobatalkes_id' => 'Jenis',
			'jenisobatalkes_kode' => 'Jenisobatalkes Kode',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'jenisobatalkes_farmasi' => 'Jenisobatalkes Farmasi',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_barcode' => 'Barcode',
			'obatalkes_kode' => 'Kode Obat Alkes',
			'obatalkes_nama' => 'Nama Obat Alkes',
			'obatalkes_namalain' => 'Nama Lain',
			'obatalkes_golongan' => 'Golongan',
			'obatalkes_kategori' => 'Kategori',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'asalbarang_id' => 'Asal Barang',
			'asalbarang_nama' => 'Asal Barang',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Satuan Kecil',
			'stokobatalkesasal_id' => 'Stok Obat Alkes Asal',
			'tglterima' => 'Tanggal Terima',
			'tglkadaluarsa' => 'Tanggal Kedaluwarsa',
			'nobatch' => 'No. Batch',
			'tglstok_in' => 'Tanggal Stok Masuk',
			'tglstok_out' => 'Tanggal Stok Keluar',
			'qtystok_in' => 'Stok Masuk',
			'qtystok_out' => 'Stok Keluar',
			'harganetto' => 'Harga Netto (Rp)',
			'persendiscount' => 'Keringanan (%)',
			'jmldiscount' => 'Keringanan (Rp)',
			'persenppn' => 'PPN (%)',
			'persenpph' => 'PPh (%)',
			'persenmargin' => 'Margin (%)',
			'jmlmargin' => 'Margin (Rp)',
			'stokoa_aktif' => 'Status',
			'create_time' => 'Tanggal Transaksi',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->stokobatalkes_id)){
			$criteria->addCondition('stokobatalkes_id = '.$this->stokobatalkes_id);
		}
		if(!empty($this->penerimaandetail_id)){
			$criteria->addCondition('penerimaandetail_id = '.$this->penerimaandetail_id);
		}
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(tglterimabarang)',strtolower($this->tglterimabarang),true);
		$criteria->compare('LOWER(noterimabarang)',strtolower($this->noterimabarang),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		if(!empty($this->returdetail_id)){
			$criteria->addCondition('returdetail_id = '.$this->returdetail_id);
		}
		if(!empty($this->returpembelian_id)){
			$criteria->addCondition('returpembelian_id = '.$this->returpembelian_id);
		}
		$criteria->compare('LOWER(tglreturpembelian)',strtolower($this->tglreturpembelian),true);
		$criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
		$criteria->compare('LOWER(alasanreturpembelian)',strtolower($this->alasanreturpembelian),true);
		$criteria->compare('LOWER(keteranganreturpembelian)',strtolower($this->keteranganreturpembelian),true);
		if(!empty($this->terimamutasidetail_id)){
			$criteria->addCondition('terimamutasidetail_id = '.$this->terimamutasidetail_id);
		}
		if(!empty($this->terimamutasi_id)){
			$criteria->addCondition('terimamutasi_id = '.$this->terimamutasi_id);
		}
		$criteria->compare('LOWER(tglterimamutasi)',strtolower($this->tglterimamutasi),true);
		$criteria->compare('LOWER(noterimamutasi)',strtolower($this->noterimamutasi),true);
		if(!empty($this->returresepdet_id)){
			$criteria->addCondition('returresepdet_id = '.$this->returresepdet_id);
		}
		if(!empty($this->returresep_id)){
			$criteria->addCondition('returresep_id = '.$this->returresep_id);
		}
		$criteria->compare('LOWER(tglreturresep)',strtolower($this->tglreturresep),true);
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanreturresep)',strtolower($this->alasanreturresep),true);
		$criteria->compare('LOWER(keteranganreturresep)',strtolower($this->keteranganreturresep),true);
		if(!empty($this->mutasioadetail_id)){
			$criteria->addCondition('mutasioadetail_id = '.$this->mutasioadetail_id);
		}
		if(!empty($this->mutasioaruangan_id)){
			$criteria->addCondition('mutasioaruangan_id = '.$this->mutasioaruangan_id);
		}
		$criteria->compare('LOWER(tglmutasioa)',strtolower($this->tglmutasioa),true);
		$criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
		if(!empty($this->obatalkespasien_id)){
			$criteria->addCondition('obatalkespasien_id = '.$this->obatalkespasien_id);
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
		}
		$criteria->compare('LOWER(tglresep)',strtolower($this->tglresep),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		if(!empty($this->pemusnahanoadetail_id)){
			$criteria->addCondition('pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
		}
		if(!empty($this->pemusnahanobatalkes_id)){
			$criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
		}
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
		if(!empty($this->formstokopname_id)){
			$criteria->addCondition('formstokopname_id = '.$this->formstokopname_id);
		}
		if(!empty($this->formuliropname_id)){
			$criteria->addCondition('formuliropname_id = '.$this->formuliropname_id);
		}
		$criteria->compare('LOWER(tglformulir)',strtolower($this->tglformulir),true);
		$criteria->compare('LOWER(noformulir)',strtolower($this->noformulir),true);
		if(!empty($this->stokopnamedet_id)){
			$criteria->addCondition('stokopnamedet_id = '.$this->stokopnamedet_id);
		}
		if(!empty($this->stokopname_id)){
			$criteria->addCondition('stokopname_id = '.$this->stokopname_id);
		}
		$criteria->compare('LOWER(tglstokopname)',strtolower($this->tglstokopname),true);
		$criteria->compare('LOWER(nostokopname)',strtolower($this->nostokopname),true);
		if(!empty($this->pemakaianobatdetail_id)){
			$criteria->addCondition('pemakaianobatdetail_id = '.$this->pemakaianobatdetail_id);
		}
		if(!empty($this->pemakaianobat_id)){
			$criteria->addCondition('pemakaianobat_id = '.$this->pemakaianobat_id);
		}
		$criteria->compare('LOWER(tglpemakaianobat)',strtolower($this->tglpemakaianobat),true);
		$criteria->compare('LOWER(nopemakaian_obat)',strtolower($this->nopemakaian_obat),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('jenisobatalkes_farmasi',$this->jenisobatalkes_farmasi);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->asalbarang_id)){
			$criteria->addCondition('asalbarang_id = '.$this->asalbarang_id);
		}
		$criteria->compare('LOWER(asalbarang_nama)',strtolower($this->asalbarang_nama),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		if(!empty($this->stokobatalkesasal_id)){
			$criteria->addCondition('stokobatalkesasal_id = '.$this->stokobatalkesasal_id);
		}
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
		$criteria->compare('LOWER(tglstok_out)',strtolower($this->tglstok_out),true);
		$criteria->compare('qtystok_in',$this->qtystok_in);
		$criteria->compare('qtystok_out',$this->qtystok_out);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('persenmargin',$this->persenmargin);
		$criteria->compare('jmlmargin',$this->jmlmargin);
		$criteria->compare('stokoa_aktif',$this->stokoa_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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
         * menampilkan harga netto apotek
         */
        public function getHPP(){
            $hpp = $this->harganetto;
            if($this->persendiscount > 0){
                $jmldiscount = $this->harganetto * $this->persendiscount / 100;
            }else{
                $jmldiscount = $this->jmldiscount;
            }
            
            $hpp = ($this->harganetto - $jmldiscount + (($this->harganetto - $jmldiscount) * $this->persenppn / 100) + (($this->harganetto - $jmldiscount + (($this->harganetto - $jmldiscount) * $this->persenppn / 100)) * $this->persenpph / 100));
            return $hpp;
        }
        /**
         * menampilkan harga netto apotek
         */
        public function getHargaJualApotek(){
            $hargajual = $this->HPP;
            if($this->persenmargin > 0){
                $jmlmargin = $this->HPP * $this->persenmargin / 100;
            }else{
                $jmlmargin = $this->jmlmargin;
            }
            
            $hargajual = $this->HPP + $jmlmargin;
            return $hargajual;
        }
}