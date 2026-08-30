<?php

/**
 * This is the model class for table "laporanpenerimaanbhnmakanan_v".
 *
 * The followings are the available columns in table 'laporanpenerimaanbhnmakanan_v':
 * @property integer $terimabahanmakan_id
 * @property string $tglsurjalan
 * @property string $nosuratjalan
 * @property string $tglterimabahan
 * @property string $nopenerimaanbahan
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $sumberdanabhn
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_alamat
 * @property string $supplier_kodepos
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $loginpemakai_id
 * @property string $nama_pemakai
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $terimabahandetail_id
 * @property integer $golbahanmakanan_id
 * @property string $golbahanmakanan_nama
 * @property integer $bahanmakanan_id
 * @property string $jenisbahanmakanan
 * @property string $kelbahanmakanan
 * @property string $namabahanmakanan
 * @property integer $jmlminimal
 * @property integer $jmldlmkemasan
 * @property double $jmlpersediaan
 * @property integer $nourutbahan
 * @property string $ukuran_bahanterima
 * @property string $merk_bahanterima
 * @property double $qty_terima
 * @property string $satuanbahan
 * @property double $harganettobhn
 * @property double $hargajualbhn
 * @property string $tglkadaluarsabahan
 * @property double $totalharganetto
 * @property double $totaldiscount
 * @property double $biayapengiriman
 * @property double $biayatransportasi
 * @property double $biayapajak
 * @property string $keterangan_terima_bahan
 * @property string $create_time
 * @property string $update_time
 * @property integer $pengajuanbahanmkn_id
 * @property string $tglpengajuanbahan
 * @property string $nopengajuan
 */
class LaporanpenerimaanbhnmakananV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpenerimaanbhnmakananV the static model class
	 */
        public $tgl_awal, $bln_awal, $thn_awal;
        public $tgl_akhir, $bln_akhir, $thn_akhir;
        public $jns_periode;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpenerimaanbhnmakanan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimabahanmakan_id, supplier_id, ruangan_id, loginpemakai_id, pegawai_id, gelarbelakang_id, jabatan_id, terimabahandetail_id, golbahanmakanan_id, bahanmakanan_id, jmlminimal, jmldlmkemasan, nourutbahan, pengajuanbahanmkn_id', 'numerical', 'integerOnly'=>true),
			array('jmlpersediaan, qty_terima, harganettobhn, hargajualbhn, totalharganetto, totaldiscount, biayapengiriman, biayatransportasi, biayapajak', 'numerical'),
			array('nosuratjalan, nopenerimaanbahan, nofaktur, sumberdanabhn, supplier_kodepos, supplier_telp, ruangan_nama, nama_pegawai, jenisbahanmakanan, kelbahanmakanan, ukuran_bahanterima, merk_bahanterima, satuanbahan, nopengajuan', 'length', 'max'=>50),
			array('supplier_kode, gelardepan', 'length', 'max'=>10),
			array('supplier_nama, supplier_propinsi, supplier_kabupaten, jabatan_nama, golbahanmakanan_nama, namabahanmakanan', 'length', 'max'=>100),
			array('nama_pemakai', 'length', 'max'=>20),
			array('nomorindukpegawai', 'length', 'max'=>30),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('keterangan_terima_bahan', 'length', 'max'=>200),
			array('tglsurjalan, tglterimabahan, tglfaktur, supplier_alamat, tglkadaluarsabahan, create_time, update_time, tglpengajuanbahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimabahanmakan_id, tglsurjalan, nosuratjalan, tglterimabahan, nopenerimaanbahan, tglfaktur, nofaktur, sumberdanabhn, supplier_id, supplier_kode, supplier_nama, supplier_alamat, supplier_kodepos, supplier_propinsi, supplier_kabupaten, supplier_telp, ruangan_id, ruangan_nama, loginpemakai_id, nama_pemakai, pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, jabatan_id, jabatan_nama, terimabahandetail_id, golbahanmakanan_id, golbahanmakanan_nama, bahanmakanan_id, jenisbahanmakanan, kelbahanmakanan, namabahanmakanan, jmlminimal, jmldlmkemasan, jmlpersediaan, nourutbahan, ukuran_bahanterima, merk_bahanterima, qty_terima, satuanbahan, harganettobhn, hargajualbhn, tglkadaluarsabahan, totalharganetto, totaldiscount, biayapengiriman, biayatransportasi, biayapajak, keterangan_terima_bahan, create_time, update_time, pengajuanbahanmkn_id, tglpengajuanbahan, nopengajuan', 'safe', 'on'=>'search'),
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
			'terimabahanmakan_id' => 'ID',
			'tglsurjalan' => 'Tanggal Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'tglterimabahan' => 'Tanggal Penerimaan',
			'nopenerimaanbahan' => 'No Penerimaan',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No Faktur',
			'sumberdanabhn' => 'Sumber Dana',
			'supplier_id' => 'Supplier ID',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Supplier',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_kodepos' => 'Kodepos Supplier',
			'supplier_propinsi' => 'Propinsi Supplier',
			'supplier_kabupaten' => 'Kabupaten Supplier',
			'supplier_telp' => 'Telp Supplier',
			'ruangan_id' => 'Ruangan ID',
			'ruangan_nama' => 'Ruangan',
			'loginpemakai_id' => 'Login ID',
			'nama_pemakai' => 'Pemakai',
			'pegawai_id' => 'Pegawai ID',
			'nomorindukpegawai' => 'NIP',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Pegawai',
			'gelarbelakang_id' => 'Gelar Belakang ID',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'jabatan_id' => 'Jabatan ID',
			'jabatan_nama' => 'Jabatan',
			'terimabahandetail_id' => 'Terima Bahan Detail ID',
			'golbahanmakanan_id' => 'Gol Bahan Makanan ID',
			'golbahanmakanan_nama' => 'Gol Bahan Makanan',
			'bahanmakanan_id' => 'Bahan Makanan ID',
			'jenisbahanmakanan' => 'Jenis Bahan Makanan',
			'kelbahanmakanan' => 'Kel Bahan Makanan',
			'namabahanmakanan' => 'Nama Bahan Makanan',
			'jmlminimal' => 'Jml Minimal',
			'jmldlmkemasan' => 'Jml Dlm Kemasan',
			'jmlpersediaan' => 'Jml Persediaan',
			'nourutbahan' => 'No Urut Bahan',
			'ukuran_bahanterima' => 'Ukuran Bahan Terima',
			'merk_bahanterima' => 'Merk Bahan Terima',
			'qty_terima' => 'Qty Terima',
			'satuanbahan' => 'Satuan Bahan',
			'harganettobhn' => 'Harga Netto Bhn',
			'hargajualbhn' => 'Harga Jual Bhn',
			'tglkadaluarsabahan' => 'Tglkadaluarsabahan',
			'totalharganetto' => 'Totalharganetto',
			'totaldiscount' => 'Total Keringanan',
			'biayapengiriman' => 'Biayapengiriman',
			'biayatransportasi' => 'Biayatransportasi',
			'biayapajak' => 'Biayapajak',
			'keterangan_terima_bahan' => 'Keterangan Terima Bahan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'pengajuanbahanmkn_id' => 'Pengajuanbahanmkn',
			'tglpengajuanbahan' => 'Tglpengajuanbahan',
			'nopengajuan' => 'Nopengajuan',
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

		$criteria->compare('terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('tglsurjalan',$this->tglsurjalan,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('tglterimabahan',$this->tglterimabahan,true);
		$criteria->compare('nopenerimaanbahan',$this->nopenerimaanbahan,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('sumberdanabhn',$this->sumberdanabhn,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_kodepos',$this->supplier_kodepos,true);
		$criteria->compare('supplier_propinsi',$this->supplier_propinsi,true);
		$criteria->compare('supplier_kabupaten',$this->supplier_kabupaten,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('terimabahandetail_id',$this->terimabahandetail_id);
		$criteria->compare('golbahanmakanan_id',$this->golbahanmakanan_id);
		$criteria->compare('golbahanmakanan_nama',$this->golbahanmakanan_nama,true);
		$criteria->compare('bahanmakanan_id',$this->bahanmakanan_id);
		$criteria->compare('jenisbahanmakanan',$this->jenisbahanmakanan,true);
		$criteria->compare('kelbahanmakanan',$this->kelbahanmakanan,true);
		$criteria->compare('namabahanmakanan',$this->namabahanmakanan,true);
		$criteria->compare('jmlminimal',$this->jmlminimal);
		$criteria->compare('jmldlmkemasan',$this->jmldlmkemasan);
		$criteria->compare('jmlpersediaan',$this->jmlpersediaan);
		$criteria->compare('nourutbahan',$this->nourutbahan);
		$criteria->compare('ukuran_bahanterima',$this->ukuran_bahanterima,true);
		$criteria->compare('merk_bahanterima',$this->merk_bahanterima,true);
		$criteria->compare('qty_terima',$this->qty_terima);
		$criteria->compare('satuanbahan',$this->satuanbahan,true);
		$criteria->compare('harganettobhn',$this->harganettobhn);
		$criteria->compare('hargajualbhn',$this->hargajualbhn);
		$criteria->compare('tglkadaluarsabahan',$this->tglkadaluarsabahan,true);
		$criteria->compare('totalharganetto',$this->totalharganetto);
		$criteria->compare('totaldiscount',$this->totaldiscount);
		$criteria->compare('biayapengiriman',$this->biayapengiriman);
		$criteria->compare('biayatransportasi',$this->biayatransportasi);
		$criteria->compare('biayapajak',$this->biayapajak);
		$criteria->compare('keterangan_terima_bahan',$this->keterangan_terima_bahan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('pengajuanbahanmkn_id',$this->pengajuanbahanmkn_id);
		$criteria->compare('tglpengajuanbahan',$this->tglpengajuanbahan,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getSupplierGizi()
        {
            GolbahanmakananM::model()->findAll();
        }
}