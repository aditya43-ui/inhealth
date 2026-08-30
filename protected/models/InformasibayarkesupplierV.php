<?php

/**
 * This is the model class for table "informasibayarkesupplier_v".
 *
 * The followings are the available columns in table 'informasibayarkesupplier_v':
 * @property integer $bayarkesupplier_id
 * @property integer $fakturpembelian_id
 * @property integer $uangmukabeli_id
 * @property integer $tandabuktikeluar_id
 * @property integer $batalbayarsupplier_id
 * @property integer $terimapersediaan_id
 * @property integer $terimabahanmakan_id
 * @property string $tglbayarkesupplier
 * @property double $totaltagihan
 * @property double $jmldibayarkan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property double $biayaadministrasi
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property string $supplier_kode
 * @property double $jmlkaskeluar
 * @property string $carabayarkeluar
 * @property string $melalubank
 * @property string $denganrekening
 * @property string $atasnamarekening
 * @property string $namapenerima
 * @property string $alamatpenerima
 * @property string $supplier_alamat
 * @property string $supplier_telp
 * @property string $supplier_email
 * @property string $supplier_website
 * @property string $supplier_fax
 * @property string $keterangan_pengeluaran
 * @property string $tahun
 * @property string $untukpembayaran
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $keteranganfaktur
 * @property string $tgljatuhtempo
 * @property string $tglbatalbayar
 */
class InformasibayarkesupplierV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    public $sudahbayar;
    public $statusBayar;
    public $statusBatal;
	public $petugaskeuangan;
	public $supplier_jenis;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasibayarkesupplierV the static model class
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
		return 'informasibayarkesupplier_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bayarkesupplier_id, fakturpembelian_id, uangmukabeli_id, tandabuktikeluar_id, batalbayarsupplier_id, terimapersediaan_id, terimabahanmakan_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('totaltagihan, jmldibayarkan, biayaadministrasi, jmlkaskeluar', 'numerical'),
			array('nokaskeluar, carabayarkeluar, supplier_telp, supplier_email, supplier_website, supplier_fax, nofaktur', 'length', 'max'=>50),
			array('supplier_nama, melalubank, denganrekening, atasnamarekening, namapenerima, untukpembayaran', 'length', 'max'=>100),
			array('supplier_kode', 'length', 'max'=>10),
			array('tahun', 'length', 'max'=>4),
			array('tglbayarkesupplier, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglkaskeluar, alamatpenerima, supplier_alamat, keterangan_pengeluaran, tglfaktur, keteranganfaktur, tgljatuhtempo, tglbatalbayar', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayarkesupplier_id, fakturpembelian_id, uangmukabeli_id, tandabuktikeluar_id, batalbayarsupplier_id, terimapersediaan_id, terimabahanmakan_id, tglbayarkesupplier, totaltagihan, jmldibayarkan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, biayaadministrasi, tglkaskeluar, nokaskeluar, supplier_id, supplier_nama, supplier_kode, jmlkaskeluar, carabayarkeluar, melalubank, denganrekening, atasnamarekening, namapenerima, alamatpenerima, supplier_alamat, supplier_telp, supplier_email, supplier_website, supplier_fax, keterangan_pengeluaran, tahun, untukpembayaran, nofaktur, tglfaktur, keteranganfaktur, tgljatuhtempo, tglbatalbayar, supplier_jenis', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'uangmukabeli_id' => 'Uang Muka Beli',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'batalbayarsupplier_id' => 'Batal Bayar Supplier',
			'terimapersediaan_id' => 'Terima Persediaan',
			'terimabahanmakan_id' => 'Terima Bahan Makanan',
			'tglbayarkesupplier' => 'Tgl. Bayar ke Supplier',
			'totaltagihan' => 'Total Tagihan',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'biayaadministrasi' => 'Biaya Administrasi',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_kode' => 'Kode Supplier',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'carabayarkeluar' => 'Cara Bayar Keluar',
			'melalubank' => 'Melalui Bank',
			'denganrekening' => 'Dengan Rekening',
			'atasnamarekening' => 'Atas Nama Rekening',
			'namapenerima' => 'Nama Penerima',
			'alamatpenerima' => 'Alamat Penerima',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_email' => 'Email Supplier',
			'supplier_website' => 'Website Supplier',
			'supplier_fax' => 'Fax Supplier',
			'keterangan_pengeluaran' => 'Keterangan Pengeluaran',
			'tahun' => 'Tahun',
			'untukpembayaran' => 'Untuk Pembayaran',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tgl. Faktur',
			'keteranganfaktur' => 'Keterangan Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'tglbatalbayar' => 'Tgl. Batal Bayar',
			'supplier_jenis' => 'Jenis Faktur',
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

		//$criteria->join = "JOIN supplier_m on supplier_m.supplier_id = t.supplier_id";
		//$criteria->compare('supplier_m.supplier_jenis', $this->supplier_id, true);

		$criteria->compare('t.bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('t.fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('t.uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('t.tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('t.batalbayarsupplier_id',$this->batalbayarsupplier_id);
		$criteria->compare('t.terimapersediaan_id',$this->terimapersediaan_id);
		$criteria->compare('t.terimabahanmakan_id',$this->terimabahanmakan_id);
		$criteria->compare('t.tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('t.totaltagihan',$this->totaltagihan);
		$criteria->compare('t.jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan,true);
		$criteria->compare('t.biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('t.tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('t.nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('t.supplier_id',$this->supplier_id);
		$criteria->compare('t.supplier_nama',$this->supplier_nama,true);
		$criteria->compare('t.supplier_kode',$this->supplier_kode,true);
		$criteria->compare('t.jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('t.carabayarkeluar',$this->carabayarkeluar,true);
		$criteria->compare('t.melalubank',$this->melalubank,true);
		$criteria->compare('t.denganrekening',$this->denganrekening,true);
		$criteria->compare('t.atasnamarekening',$this->atasnamarekening,true);
		$criteria->compare('t.namapenerima',$this->namapenerima,true);
		$criteria->compare('t.alamatpenerima',$this->alamatpenerima,true);
		$criteria->compare('t.supplier_alamat',$this->supplier_alamat,true);
		$criteria->compare('t.supplier_telp',$this->supplier_telp,true);
		$criteria->compare('t.supplier_email',$this->supplier_email,true);
		$criteria->compare('t.supplier_website',$this->supplier_website,true);
		$criteria->compare('t.supplier_fax',$this->supplier_fax,true);
		$criteria->compare('t.keterangan_pengeluaran',$this->keterangan_pengeluaran,true);
		$criteria->compare('t.tahun',$this->tahun,true);
		$criteria->compare('t.untukpembayaran',$this->untukpembayaran,true);
		$criteria->compare('t.nofaktur',$this->nofaktur,true);
		$criteria->compare('t.tglfaktur',$this->tglfaktur,true);
		$criteria->compare('t.keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('t.tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('t.tglbatalbayar',$this->tglbatalbayar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi() {
        $prov = $this->search();
        
        $prov->criteria->addBetweenCondition(" DATE(tglkaskeluar) ", $this->tgl_awal, $this->tgl_akhir);
        
        $prov->criteria->join = "JOIN loginpemakai_k lp ON lp.loginpemakai_id = t.create_loginpemakai_id "
						. " LEFT JOIN pegawai_m p ON p.pegawai_id = lp.pegawai_id"
						. " JOIN supplier_m on supplier_m.supplier_id = t.supplier_id";
		//$criteria->join = "JOIN supplier_m on supplier_m.supplier_id = t.supplier_id";
        
        if (!empty($this->statusBayar)){
			if ($this->statusBayar == 1){
				$prov->criteria->addCondition(" totaltagihan - jmldibayarkan <= 0 ");
			}elseif ($this->statusBayar == 2){
				$prov->criteria->addCondition(" totaltagihan - jmldibayarkan > 0");
			}
		}
        
        if (!empty($this->statusBatal)){
			if ($this->statusBatal == 1){
				$prov->criteria->addCondition(" batalbayarsupplier_id is not null");
			}elseif ($this->statusBatal == 2){
				$prov->criteria->addCondition(" batalbayarsupplier_id is null");
			}
		}

		if (!empty($this->supplier_jenis)){
			//$prov->criteria->addCondition("uspplier_m.supplier_jenis = ". $this->jenisfaktur ." ");
			$prov->criteria->compare('supplier_m.supplier_jenis',$this->supplier_jenis,true);
		}
        
        if (!empty($this->petugaskeuangan)){
			$prov->criteria->addCondition(" p.pegawai_id = ".$this->petugaskeuangan."  ");
		}
        
        return $prov;
    }
}