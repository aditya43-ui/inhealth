<?php

/**
 * This is the model class for table "penerimaanpencucianlinen_v".
 *
 * The followings are the available columns in table 'penerimaanpencucianlinen_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $penerimaanlinen_id
 * @property string $nopenerimaanlinen
 * @property string $tglpenerimaanlinen
 * @property string $keteranganpenerimaanlinen_header
 * @property integer $beratlinen
 * @property integer $penerimaanlinendetail_id
 * @property string $jenisperawatanlinen
 * @property string $keteranganpenerimaanlinen_item
 * @property integer $perawatanlinen_id
 * @property string $noperawatan
 * @property string $tglperawatanlinen
 * @property string $keterangan_perawatan
 * @property integer $perawatanlinendetail_id
 * @property string $jenisperawatan
 * @property string $keteranganperawatan
 * @property string $statusperawatanlinen
 * @property integer $linen_id
 * @property integer $jenislinen_id
 * @property string $jenislinen_no
 * @property string $jenislinen_nama
 * @property string $tgldiedarkan
 * @property string $ukuranitem
 * @property double $beratitem
 * @property integer $qtyitem
 * @property string $warnalinen
 * @property boolean $isberwarna
 * @property integer $lokasipenyimpanan_id
 * @property string $lokasipenyimpanan_kode
 * @property string $lokasipenyimpanan_nama
 * @property string $lokasipenyimpanan_namalain
 * @property integer $rakpenyimpanan_id
 * @property string $rakpenyimpanan_label
 * @property string $rakpenyimpanan_kode
 * @property string $rakpenyimpanan_nama
 * @property string $rakpenyimpanan_namalain
 * @property integer $bahanlinen_id
 * @property string $bahanlinen_nama
 * @property string $bahanlinen_namalain
 * @property string $suhurekomendasi
 * @property string $kodelinen
 * @property integer $barang_id
 * @property string $barang_type
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_merk
 * @property string $barang_noseri
 * @property string $barang_ukuran
 * @property string $barang_bahan
 * @property string $barang_thnbeli
 * @property string $barang_warna
 * @property boolean $barang_statusregister
 * @property integer $barang_ekonomis_thn
 * @property string $barang_satuan
 * @property integer $barang_jmldlmkemasan
 * @property double $barang_harganetto
 * @property double $barang_persendiskon
 * @property double $barang_ppn
 * @property double $barang_hpp
 * @property double $barang_hargajual
 * @property string $tglregisterlinen
 * @property string $noregisterlinen
 * @property string $namalinen
 * @property string $namalainnya
 * @property string $merklinen
 * @property integer $beratlinen_satuan
 * @property string $warna
 * @property string $tahunbeli
 * @property string $gambarlinen
 * @property integer $jmlcucilinen
 * @property string $satuanlinen
 * @property integer $pegawaipenerima_id
 * @property string $pegawaipenerima_nip
 * @property string $pegawaipenerima_jenisidentitas
 * @property string $pegawaipenerima_noidentitas
 * @property string $pegawaipenerima_gelardepan
 * @property string $pegawaipenerima_nama
 * @property string $pegawaipenerima_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PenerimaanpencucianlinenV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanpencucianlinenV the static model class
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
		return 'penerimaanpencucianlinen_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, penerimaanlinen_id, beratlinen, penerimaanlinendetail_id, perawatanlinen_id, perawatanlinendetail_id, linen_id, jenislinen_id, qtyitem, lokasipenyimpanan_id, rakpenyimpanan_id, bahanlinen_id, barang_id, barang_ekonomis_thn, barang_jmldlmkemasan, beratlinen_satuan, jmlcucilinen, pegawaipenerima_id, pegawaimengetahui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('beratitem, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual', 'numerical'),
			array('instalasi_nama, ruangan_nama, jenisperawatanlinen, jenisperawatan, jenislinen_no, warnalinen, kodelinen, barang_type, barang_kode, barang_merk, barang_warna, barang_satuan, noregisterlinen, merklinen, satuanlinen, pegawaipenerima_nama, pegawaimengetahui_nama', 'length', 'max'=>50),
			array('nopenerimaanlinen, noperawatan, statusperawatanlinen, barang_noseri, barang_ukuran, barang_bahan, warna, pegawaipenerima_jenisidentitas, pegawaimengetahui_jenisidentitas', 'length', 'max'=>20),
			array('keteranganpenerimaanlinen_item, keteranganperawatan, lokasipenyimpanan_nama, lokasipenyimpanan_namalain, rakpenyimpanan_nama, rakpenyimpanan_namalain, barang_nama, pegawaipenerima_noidentitas, pegawaimengetahui_noidentitas', 'length', 'max'=>100),
			array('jenislinen_nama, bahanlinen_nama, bahanlinen_namalain, namalinen, namalainnya', 'length', 'max'=>200),
			array('ukuranitem, pegawaipenerima_nip, pegawaimengetahui_nip', 'length', 'max'=>30),
			array('lokasipenyimpanan_kode, rakpenyimpanan_label, suhurekomendasi, pegawaipenerima_gelardepan, pegawaimengetahui_gelardepan', 'length', 'max'=>10),
			array('rakpenyimpanan_kode, barang_thnbeli', 'length', 'max'=>5),
			array('tahunbeli', 'length', 'max'=>6),
			array('pegawaipenerima_gelarbelakang, pegawaimengetahui_gelarbelakang', 'length', 'max'=>15),
			array('tglpenerimaanlinen, keteranganpenerimaanlinen_header, tglperawatanlinen, keterangan_perawatan, tgldiedarkan, isberwarna, barang_statusregister, tglregisterlinen, gambarlinen, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, penerimaanlinen_id, nopenerimaanlinen, tglpenerimaanlinen, keteranganpenerimaanlinen_header, beratlinen, penerimaanlinendetail_id, jenisperawatanlinen, keteranganpenerimaanlinen_item, perawatanlinen_id, noperawatan, tglperawatanlinen, keterangan_perawatan, perawatanlinendetail_id, jenisperawatan, keteranganperawatan, statusperawatanlinen, linen_id, jenislinen_id, jenislinen_no, jenislinen_nama, tgldiedarkan, ukuranitem, beratitem, qtyitem, warnalinen, isberwarna, lokasipenyimpanan_id, lokasipenyimpanan_kode, lokasipenyimpanan_nama, lokasipenyimpanan_namalain, rakpenyimpanan_id, rakpenyimpanan_label, rakpenyimpanan_kode, rakpenyimpanan_nama, rakpenyimpanan_namalain, bahanlinen_id, bahanlinen_nama, bahanlinen_namalain, suhurekomendasi, kodelinen, barang_id, barang_type, barang_kode, barang_nama, barang_merk, barang_noseri, barang_ukuran, barang_bahan, barang_thnbeli, barang_warna, barang_statusregister, barang_ekonomis_thn, barang_satuan, barang_jmldlmkemasan, barang_harganetto, barang_persendiskon, barang_ppn, barang_hpp, barang_hargajual, tglregisterlinen, noregisterlinen, namalinen, namalainnya, merklinen, beratlinen_satuan, warna, tahunbeli, gambarlinen, jmlcucilinen, satuanlinen, pegawaipenerima_id, pegawaipenerima_nip, pegawaipenerima_jenisidentitas, pegawaipenerima_noidentitas, pegawaipenerima_gelardepan, pegawaipenerima_nama, pegawaipenerima_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'penerimaanlinen_id' => 'Penerimaan Linen',
			'nopenerimaanlinen' => 'No. Penerimaan',
			'tglpenerimaanlinen' => 'Tanggal Penerimaan',
			'keteranganpenerimaanlinen_header' => 'Keterangan Penerimaan',
			'beratlinen' => 'Berat Linen',
			'penerimaanlinendetail_id' => 'Penerimaan Linen Detail',
			'jenisperawatanlinen' => 'Jenis Perawata',
			'keteranganpenerimaanlinen_item' => 'Keterangan Penerimaan Item',
			'perawatanlinen_id' => 'Perawatan Linen',
			'noperawatan' => 'No. Perawatan',
			'tglperawatanlinen' => 'Tanggal Perawatan Linen',
			'keterangan_perawatan' => 'Keterangan Perawatan',
			'perawatanlinendetail_id' => 'Perawatan Linen Detail',
			'jenisperawatan' => 'Jenis Perawatan',
			'keteranganperawatan' => 'Keterangan Perawatan',
			'statusperawatanlinen' => 'Status Perawatan Linen',
			'linen_id' => 'Linen',
			'jenislinen_id' => 'Jenis Linen',
			'jenislinen_no' => 'No. Jenis Linen',
			'jenislinen_nama' => 'Jenis Linen',
			'tgldiedarkan' => 'Tanggal Diedarkan',
			'ukuranitem' => 'Ukuran Item',
			'beratitem' => 'Berat Item',
			'qtyitem' => 'Jumlah Item',
			'warnalinen' => 'Warna Linen',
			'isberwarna' => 'Is Berwarna',
			'lokasipenyimpanan_id' => 'Lokasi Penyimpanan',
			'lokasipenyimpanan_kode' => 'Kode Lokasi Penyimpanan',
			'lokasipenyimpanan_nama' => 'Nama Lokasi Penyimpanan',
			'lokasipenyimpanan_namalain' => 'Nama Lain Lokasi Penyimpanan',
			'rakpenyimpanan_id' => 'Rak Penyimkpanan',
			'rakpenyimpanan_label' => 'Label Rak Penyimpanan',
			'rakpenyimpanan_kode' => 'Kode Rak Penyimpanan',
			'rakpenyimpanan_nama' => 'Nama Rak Penyimpanan',
			'rakpenyimpanan_namalain' => 'Nama Lain Rak Penyimpanan',
			'bahanlinen_id' => 'Bahan Linen',
			'bahanlinen_nama' => 'Nama Bahan Linen',
			'bahanlinen_namalain' => 'Nama Lain Bahan Linen',
			'suhurekomendasi' => 'Suhu Rekomendasi',
			'kodelinen' => 'Kode Linen',
			'barang_id' => 'Barang',
			'barang_type' => 'Tipe Barang',
			'barang_kode' => 'Kode Barang',
			'barang_nama' => 'Nama Barang',
			'barang_merk' => 'Merk Barang',
			'barang_noseri' => 'No. Seri Barang',
			'barang_ukuran' => 'Ukuran Barang',
			'barang_bahan' => 'Bahan Barang',
			'barang_thnbeli' => 'Tahun Beli Barang',
			'barang_warna' => 'Barang Warna',
			'barang_statusregister' => 'Status Registrasi Barang',
			'barang_ekonomis_thn' => 'Tahun Ekonomis Barang',
			'barang_satuan' => 'Satuan Barang',
			'barang_jmldlmkemasan' => 'Jumlah Dalam Kemasan',
			'barang_harganetto' => 'Harga Netto',
			'barang_persendiskon' => 'Persen Keringanan',
			'barang_ppn' => 'PPN',
			'barang_hpp' => 'HPP',
			'barang_hargajual' => 'Harga Jual',
			'tglregisterlinen' => 'Tanggal Register Linen',
			'noregisterlinen' => 'No. Register Linen',
			'namalinen' => 'Nama Linen',
			'namalainnya' => 'Nama Lainnya',
			'merklinen' => 'Merk Linen',
			'beratlinen_satuan' => 'Satuan Berat Linen',
			'warna' => 'Warna',
			'tahunbeli' => 'Tahun Beli',
			'gambarlinen' => 'Gambar Linen',
			'jmlcucilinen' => 'Jumlah Cuci Linen',
			'satuanlinen' => 'Satuan Linen',
			'pegawaipenerima_id' => 'Pegawai Penerima',
			'pegawaipenerima_nip' => 'NIP Pegawai Pegawai Penerima',
			'pegawaipenerima_jenisidentitas' => 'Jenis Identitas Pegawai Penerima',
			'pegawaipenerima_noidentitas' => 'No. Identitas Pegawai Penerima',
			'pegawaipenerima_gelardepan' => 'Gelar Depan Pegawai Penerima',
			'pegawaipenerima_nama' => 'Nama Pegawai Penerima',
			'pegawaipenerima_gelarbelakang' => 'Gelar Belakang Pegawai Penerima',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_nip' => 'NIP Pegawai',
			'pegawaimengetahui_jenisidentitas' => 'Jenis Identitas Pegawai Mengetahui',
			'pegawaimengetahui_noidentitas' => 'No. Identitas Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Gelar Depan Pegawai Mengetahui',
			'pegawaimengetahui_nama' => 'Nama Pegawai Mengetahui',
			'pegawaimengetahui_gelarbelakang' => 'Gelar Belakang Pegawai Mengetahui',
			'create_time' => 'Waktu Create',
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
		if(!empty($this->penerimaanlinen_id)){
			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
		}
		$criteria->compare('LOWER(nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->compare('LOWER(tglpenerimaanlinen)',strtolower($this->tglpenerimaanlinen),true);
		$criteria->compare('LOWER(keteranganpenerimaanlinen_header)',strtolower($this->keteranganpenerimaanlinen_header),true);
		if(!empty($this->beratlinen)){
			$criteria->addCondition('beratlinen = '.$this->beratlinen);
		}
		if(!empty($this->penerimaanlinendetail_id)){
			$criteria->addCondition('penerimaanlinendetail_id = '.$this->penerimaanlinendetail_id);
		}
		$criteria->compare('LOWER(jenisperawatanlinen)',strtolower($this->jenisperawatanlinen),true);
		$criteria->compare('LOWER(keteranganpenerimaanlinen_item)',strtolower($this->keteranganpenerimaanlinen_item),true);
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		$criteria->compare('LOWER(noperawatan)',strtolower($this->noperawatan),true);
		$criteria->compare('LOWER(tglperawatanlinen)',strtolower($this->tglperawatanlinen),true);
		$criteria->compare('LOWER(keterangan_perawatan)',strtolower($this->keterangan_perawatan),true);
		if(!empty($this->perawatanlinendetail_id)){
			$criteria->addCondition('perawatanlinendetail_id = '.$this->perawatanlinendetail_id);
		}
		$criteria->compare('LOWER(jenisperawatan)',strtolower($this->jenisperawatan),true);
		$criteria->compare('LOWER(keteranganperawatan)',strtolower($this->keteranganperawatan),true);
		$criteria->compare('LOWER(statusperawatanlinen)',strtolower($this->statusperawatanlinen),true);
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->jenislinen_id)){
			$criteria->addCondition('jenislinen_id = '.$this->jenislinen_id);
		}
		$criteria->compare('LOWER(jenislinen_no)',strtolower($this->jenislinen_no),true);
		$criteria->compare('LOWER(jenislinen_nama)',strtolower($this->jenislinen_nama),true);
		$criteria->compare('LOWER(tgldiedarkan)',strtolower($this->tgldiedarkan),true);
		$criteria->compare('LOWER(ukuranitem)',strtolower($this->ukuranitem),true);
		$criteria->compare('beratitem',$this->beratitem);
		if(!empty($this->qtyitem)){
			$criteria->addCondition('qtyitem = '.$this->qtyitem);
		}
		$criteria->compare('LOWER(warnalinen)',strtolower($this->warnalinen),true);
		$criteria->compare('isberwarna',$this->isberwarna);
		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		$criteria->compare('LOWER(lokasipenyimpanan_kode)',strtolower($this->lokasipenyimpanan_kode),true);
		$criteria->compare('LOWER(lokasipenyimpanan_nama)',strtolower($this->lokasipenyimpanan_nama),true);
		$criteria->compare('LOWER(lokasipenyimpanan_namalain)',strtolower($this->lokasipenyimpanan_namalain),true);
		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		$criteria->compare('LOWER(rakpenyimpanan_label)',strtolower($this->rakpenyimpanan_label),true);
		$criteria->compare('LOWER(rakpenyimpanan_kode)',strtolower($this->rakpenyimpanan_kode),true);
		$criteria->compare('LOWER(rakpenyimpanan_nama)',strtolower($this->rakpenyimpanan_nama),true);
		$criteria->compare('LOWER(rakpenyimpanan_namalain)',strtolower($this->rakpenyimpanan_namalain),true);
		if(!empty($this->bahanlinen_id)){
			$criteria->addCondition('bahanlinen_id = '.$this->bahanlinen_id);
		}
		$criteria->compare('LOWER(bahanlinen_nama)',strtolower($this->bahanlinen_nama),true);
		$criteria->compare('LOWER(bahanlinen_namalain)',strtolower($this->bahanlinen_namalain),true);
		$criteria->compare('LOWER(suhurekomendasi)',strtolower($this->suhurekomendasi),true);
		$criteria->compare('LOWER(kodelinen)',strtolower($this->kodelinen),true);
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('LOWER(barang_noseri)',strtolower($this->barang_noseri),true);
		$criteria->compare('LOWER(barang_ukuran)',strtolower($this->barang_ukuran),true);
		$criteria->compare('LOWER(barang_bahan)',strtolower($this->barang_bahan),true);
		$criteria->compare('LOWER(barang_thnbeli)',strtolower($this->barang_thnbeli),true);
		$criteria->compare('LOWER(barang_warna)',strtolower($this->barang_warna),true);
		$criteria->compare('barang_statusregister',$this->barang_statusregister);
		if(!empty($this->barang_ekonomis_thn)){
			$criteria->addCondition('barang_ekonomis_thn = '.$this->barang_ekonomis_thn);
		}
		$criteria->compare('LOWER(barang_satuan)',strtolower($this->barang_satuan),true);
		if(!empty($this->barang_jmldlmkemasan)){
			$criteria->addCondition('barang_jmldlmkemasan = '.$this->barang_jmldlmkemasan);
		}
		$criteria->compare('barang_harganetto',$this->barang_harganetto);
		$criteria->compare('barang_persendiskon',$this->barang_persendiskon);
		$criteria->compare('barang_ppn',$this->barang_ppn);
		$criteria->compare('barang_hpp',$this->barang_hpp);
		$criteria->compare('barang_hargajual',$this->barang_hargajual);
		$criteria->compare('LOWER(tglregisterlinen)',strtolower($this->tglregisterlinen),true);
		$criteria->compare('LOWER(noregisterlinen)',strtolower($this->noregisterlinen),true);
		$criteria->compare('LOWER(namalinen)',strtolower($this->namalinen),true);
		$criteria->compare('LOWER(namalainnya)',strtolower($this->namalainnya),true);
		$criteria->compare('LOWER(merklinen)',strtolower($this->merklinen),true);
		if(!empty($this->beratlinen_satuan)){
			$criteria->addCondition('beratlinen_satuan = '.$this->beratlinen_satuan);
		}
		$criteria->compare('LOWER(warna)',strtolower($this->warna),true);
		$criteria->compare('LOWER(tahunbeli)',strtolower($this->tahunbeli),true);
		$criteria->compare('LOWER(gambarlinen)',strtolower($this->gambarlinen),true);
		if(!empty($this->jmlcucilinen)){
			$criteria->addCondition('jmlcucilinen = '.$this->jmlcucilinen);
		}
		$criteria->compare('LOWER(satuanlinen)',strtolower($this->satuanlinen),true);
		if(!empty($this->pegawaipenerima_id)){
			$criteria->addCondition('pegawaipenerima_id = '.$this->pegawaipenerima_id);
		}
		$criteria->compare('LOWER(pegawaipenerima_nip)',strtolower($this->pegawaipenerima_nip),true);
		$criteria->compare('LOWER(pegawaipenerima_jenisidentitas)',strtolower($this->pegawaipenerima_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaipenerima_noidentitas)',strtolower($this->pegawaipenerima_noidentitas),true);
		$criteria->compare('LOWER(pegawaipenerima_gelardepan)',strtolower($this->pegawaipenerima_gelardepan),true);
		$criteria->compare('LOWER(pegawaipenerima_nama)',strtolower($this->pegawaipenerima_nama),true);
		$criteria->compare('LOWER(pegawaipenerima_gelarbelakang)',strtolower($this->pegawaipenerima_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
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
}