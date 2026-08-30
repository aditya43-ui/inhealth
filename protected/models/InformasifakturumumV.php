<?php

/**
 * This is the model class for table "informasifakturumum_v".
 *
 * The followings are the available columns in table 'informasifakturumum_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $terimapersediaan_id
 * @property integer $pembelianbarang_id
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_alamat
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $supplier_kodepos
 * @property string $supplier_npwp
 * @property string $supplier_norekening
 * @property string $supplier_namabank
 * @property string $supplier_rekatasnama
 * @property string $supplier_matauang
 * @property string $supplier_website
 * @property string $supplier_email
 * @property string $supplier_cp
 * @property string $supplier_cp_hp
 * @property string $supplier_cp_email
 * @property string $supplier_cp2
 * @property string $supplier_cp2_hp
 * @property string $supplier_cp2_email
 * @property string $supplier_jenis
 * @property integer $supplier_termin
 * @property string $longitude
 * @property string $latitude
 * @property integer $asalbarang_id
 * @property string $asalbarang_nama
 * @property integer $rekeningsupplier_id
 * @property integer $bank_id
 * @property string $namabank
 * @property string $alamatbank
 * @property string $no_rekening
 * @property string $tglpembelian
 * @property string $nopembelian
 * @property string $tgldikirim
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
 * @property string $tglterima
 * @property string $nopenerimaan
 * @property string $tglsuratjalan
 * @property string $nosuratjalan
 * @property string $tgljatuhtempo
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $keterangan_persediaan
 * @property double $totalharga
 * @property double $discount
 * @property double $biayaadministrasi
 * @property double $pajakpph
 * @property double $pajakppn
 * @property string $nofakturpajak
 */
class InformasifakturumumV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturumumV the static model class
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
		return 'informasifakturumum_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, terimapersediaan_id, pembelianbarang_id, supplier_id, supplier_termin, asalbarang_id, rekeningsupplier_id, bank_id, pegawaipenerima_id, pegawaimengetahui_id, pegawaimenyetujuikeuangan_id, syaratbayar_id', 'numerical', 'integerOnly'=>true),
			array('totalharga, discount, biayaadministrasi, pajakpph, pajakppn, jlmuangmukabeli, totalhutangusaha', 'numerical'),
			array('instalasi_nama, ruangan_nama, supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email, asalbarang_nama, no_rekening, pegawaipenerima_nama, pegawaimengetahui_nama, nopenerimaan, nosuratjalan, nofaktur, syaratbayar_nama', 'length', 'max'=>50),
			array('supplier_kode, pegawaipenerima_gelardepan, pegawaimengetahui_gelardepan', 'length', 'max'=>10),
			array('supplier_nama, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, namabank, nopembelian, pegawaipenerima_noidentitas, pegawaimengetahui_noidentitas, nofakturpajak', 'length', 'max'=>100),
			array('supplier_jenis, pegawaipenerima_jenisidentitas, pegawaimengetahui_jenisidentitas', 'length', 'max'=>20),
			array('pegawaipenerima_nip, pegawaimengetahui_nip', 'length', 'max'=>30),
			array('pegawaipenerima_gelarbelakang, pegawaimengetahui_gelarbelakang', 'length', 'max'=>15),
			array('supplier_alamat, longitude, latitude, alamatbank, tglpembelian, tgldikirim, tglterima, tglsuratjalan, tgljatuhtempo, tglfaktur, keterangan_persediaan, tgl_menyetujuikeuangan, keteranganfaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, terimapersediaan_id, pembelianbarang_id, supplier_id, supplier_kode, supplier_nama, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, longitude, latitude, asalbarang_id, asalbarang_nama, rekeningsupplier_id, bank_id, namabank, alamatbank, no_rekening, tglpembelian, nopembelian, tgldikirim, pegawaipenerima_id, pegawaipenerima_nip, pegawaipenerima_jenisidentitas, pegawaipenerima_noidentitas, pegawaipenerima_gelardepan, pegawaipenerima_nama, pegawaipenerima_gelarbelakang, pegawaimengetahui_id, pegawaimengetahui_nip, pegawaimengetahui_jenisidentitas, pegawaimengetahui_noidentitas, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, tglterima, nopenerimaan, tglsuratjalan, nosuratjalan, tgljatuhtempo, tglfaktur, nofaktur, keterangan_persediaan, totalharga, discount, biayaadministrasi, pajakpph, pajakppn, nofakturpajak, tgl_menyetujuikeuangan, pegawaimenyetujuikeuangan_id, syaratbayar_id, syaratbayar_nama, keteranganfaktur, jlmuangmukabeli, totalhutangusaha', 'safe', 'on'=>'search'),
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
			'terimapersediaan_id' => 'Terima Persediaan',
			'pembelianbarang_id' => 'Pembelian Barang',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_alamat' => 'Alamat',
			'supplier_propinsi' => 'Propinsi Supplier',
			'supplier_kabupaten' => 'Kabupaten Supplier',
			'supplier_telp' => 'Telp Supplier',
			'supplier_fax' => 'No. Faximile',
			'supplier_kodepos' => 'Kode Pos',
			'supplier_npwp' => 'NPWP',
			'supplier_norekening' => 'Bank',
			'supplier_namabank' => 'Nama',
			'supplier_rekatasnama' => 'No. Rekening',
			'supplier_matauang' => 'Mata Uang',
			'supplier_website' => 'Website Supplier',
			'supplier_email' => 'Email Supplier',
			'supplier_cp' => 'Supplier Cp',
			'supplier_cp_hp' => 'Supplier Cp Hp',
			'supplier_cp_email' => 'Supplier Cp Email',
			'supplier_cp2' => 'Supplier Cp2',
			'supplier_cp2_hp' => 'Supplier Cp2 Hp',
			'supplier_cp2_email' => 'Supplier Cp2 Email',
			'supplier_jenis' => 'Jenis Supplier',
			'supplier_termin' => 'Supplier Termin',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'asalbarang_id' => 'Asalbarang',
			'asalbarang_nama' => 'Asal Barang',
			'rekeningsupplier_id' => 'Rekeningsupplier',
			'bank_id' => 'Bank',
			'namabank' => 'Namabank',
			'alamatbank' => 'Alamatbank',
			'no_rekening' => 'No. Rekening',
			'tglpembelian' => 'Tanggal Pembelian',
			'nopembelian' => 'No. Pembelian',
			'tgldikirim' => 'Tanggal Pengiriman',
			'pegawaipenerima_id' => 'Pegawaipenerima',
			'pegawaipenerima_nip' => 'Pegawaipenerima Nip',
			'pegawaipenerima_jenisidentitas' => 'Pegawaipenerima Jenisidentitas',
			'pegawaipenerima_noidentitas' => 'Pegawaipenerima Noidentitas',
			'pegawaipenerima_gelardepan' => 'Pegawaipenerima Gelardepan',
			'pegawaipenerima_nama' => 'Pegawai Penerima',
			'pegawaipenerima_gelarbelakang' => 'Pegawaipenerima Gelarbelakang',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimengetahui_nip' => 'Pegawaimengetahui Nip',
			'pegawaimengetahui_jenisidentitas' => 'Pegawaimengetahui Jenisidentitas',
			'pegawaimengetahui_noidentitas' => 'Pegawaimengetahui Noidentitas',
			'pegawaimengetahui_gelardepan' => 'Pegawaimengetahui Gelardepan',
			'pegawaimengetahui_nama' => 'Pegawaimengetahui Nama',
			'pegawaimengetahui_gelarbelakang' => 'Pegawaimengetahui Gelarbelakang',
			'tglterima' => 'Tanggal Terima',
			'nopenerimaan' => 'No. Penerimaan',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'keterangan_persediaan' => 'Keterangan Persediaan',
			'totalharga' => 'Total Harga',
			'discount' => 'Keringanan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'pajakpph' => 'Pajak Pph',
			'pajakppn' => 'Pajak Ppn',
			'nofakturpajak' => 'No. Faktur Pajak',
			'supplier_telphon' => 'No. Telepon',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_kode',$this->supplier_kode,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('supplier_propinsi',$this->supplier_propinsi,true);
		$criteria->compare('supplier_kabupaten',$this->supplier_kabupaten,true);
		$criteria->compare('supplier_telp',$this->supplier_telp,true);
		$criteria->compare('supplier_fax',$this->supplier_fax,true);
		$criteria->compare('supplier_kodepos',$this->supplier_kodepos,true);
		$criteria->compare('supplier_npwp',$this->supplier_npwp,true);
		$criteria->compare('supplier_norekening',$this->supplier_norekening,true);
		$criteria->compare('supplier_namabank',$this->supplier_namabank,true);
		$criteria->compare('supplier_rekatasnama',$this->supplier_rekatasnama,true);
		$criteria->compare('supplier_matauang',$this->supplier_matauang,true);
		$criteria->compare('supplier_website',$this->supplier_website,true);
		$criteria->compare('supplier_email',$this->supplier_email,true);
		$criteria->compare('supplier_cp',$this->supplier_cp,true);
		$criteria->compare('supplier_cp_hp',$this->supplier_cp_hp,true);
		$criteria->compare('supplier_cp_email',$this->supplier_cp_email,true);
		$criteria->compare('supplier_cp2',$this->supplier_cp2,true);
		$criteria->compare('supplier_cp2_hp',$this->supplier_cp2_hp,true);
		$criteria->compare('supplier_cp2_email',$this->supplier_cp2_email,true);
		$criteria->compare('supplier_jenis',$this->supplier_jenis,true);
		$criteria->compare('supplier_termin',$this->supplier_termin);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('asalbarang_id',$this->asalbarang_id);
		$criteria->compare('asalbarang_nama',$this->asalbarang_nama,true);
		$criteria->compare('rekeningsupplier_id',$this->rekeningsupplier_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('alamatbank',$this->alamatbank,true);
		$criteria->compare('no_rekening',$this->no_rekening,true);
		$criteria->compare('tglpembelian',$this->tglpembelian,true);
		$criteria->compare('nopembelian',$this->nopembelian,true);
		$criteria->compare('tgldikirim',$this->tgldikirim,true);
		$criteria->compare('pegawaipenerima_id',$this->pegawaipenerima_id);
		$criteria->compare('pegawaipenerima_nip',$this->pegawaipenerima_nip,true);
		$criteria->compare('pegawaipenerima_jenisidentitas',$this->pegawaipenerima_jenisidentitas,true);
		$criteria->compare('pegawaipenerima_noidentitas',$this->pegawaipenerima_noidentitas,true);
		$criteria->compare('pegawaipenerima_gelardepan',$this->pegawaipenerima_gelardepan,true);
		$criteria->compare('pegawaipenerima_nama',$this->pegawaipenerima_nama,true);
		$criteria->compare('pegawaipenerima_gelarbelakang',$this->pegawaipenerima_gelarbelakang,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_nip',$this->pegawaimengetahui_nip,true);
		$criteria->compare('pegawaimengetahui_jenisidentitas',$this->pegawaimengetahui_jenisidentitas,true);
		$criteria->compare('pegawaimengetahui_noidentitas',$this->pegawaimengetahui_noidentitas,true);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('nopenerimaan',$this->nopenerimaan,true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('keterangan_persediaan',$this->keterangan_persediaan,true);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('pajakpph',$this->pajakpph);
		$criteria->compare('pajakppn',$this->pajakppn);
		$criteria->compare('nofakturpajak',$this->nofakturpajak,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}