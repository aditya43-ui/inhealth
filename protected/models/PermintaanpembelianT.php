<?php

/**
 * This is the model class for table "permintaanpembelian_t".
 *
 * The followings are the available columns in table 'permintaanpembelian_t':
 * @property integer $permintaanpembelian_id
 * @property integer $ruangan_id
 * @property integer $penerimaanbarang_id
 * @property integer $pegawai_id
 * @property integer $permintaanpenawaran_id
 * @property integer $instalasi_id
 * @property integer $syaratbayar_id
 * @property integer $rencanakebfarmasi_id
 * @property integer $supplier_id
 * @property string $tglpermintaanpembelian
 * @property string $nopermintaan
 * @property string $tglterimabarang
 * @property string $alamatpengiriman
 * @property boolean $istermasukppn
 * @property boolean $istermasukpph
 * @property string $keteranganpermintaan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $statuspembelian
 *
 * The followings are the available model relations:
 * @property InstalasiM $instalasi
 * @property PegawaiM $pegawai
 * @property PenerimaanbarangT $penerimaanbarang
 * @property PermintaanpenawaranT $permintaanpenawaran
 * @property RencanakebfarmasiT $rencanakebfarmasi
 * @property RuanganM $ruangan
 * @property SupplierM $supplier
 * @property SyaratbayarM $syaratbayar
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 * @property PenerimaanbarangT[] $penerimaanbarangTs
 * @property PermintaandetailT[] $permintaandetailTs
 */
class PermintaanpembelianT extends CActiveRecord
{
    public $supplier_alamat;
    public $supplier_nama;
    public $pegawaiapoteker_nama;
    public $pegawaiapoteker_alamat;
    public $pegawaiapoteker_alamat_ktp;
    public $pegawaiapoteker_sipa, $pegawaimengetahuiumum_nama, $sumberdana_nama, $pegawai_nama, $is_uangmukapembelian, $pajak_nama;
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaanpembelianT the static model class
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
		return 'permintaanpembelian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pegawai_id, instalasi_id, supplier_id, tglpermintaanpembelian, create_time, create_loginpemakai_id, create_ruangan, sumberdana_id', 'required'),
			array('ruangan_id, penerimaanbarang_id, pegawai_id, permintaanpenawaran_id, instalasi_id, syaratbayar_id, rencanakebfarmasi_id, supplier_id, pegawaimengetahui_id, pegawaimenyetujui_id, pegawaimengetahuiumum_id, sumberdana_id, batalpermintaanpembelian_id, pajak_id', 'numerical', 'integerOnly'=>true),
                    array('jmlpermintaanuangmuka', 'numerical'),
			array('nopermintaan', 'length', 'max'=>50),
			array('statuspembelian', 'length', 'max'=>20),
                    array('noreferensi', 'length', 'max'=>100),
                    
			array('pegawaiapoteker_id, tglterimabarang, alamatpengiriman, istermasukppn, istermasukpph, keteranganpermintaan, update_time, update_loginpemakai_id, sumberdana_id, noreferensi, tgldikirim, tglpermintaanuangmuka', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawaiapoteker_id, permintaanpembelian_id, ruangan_id, penerimaanbarang_id, pegawai_id, permintaanpenawaran_id, instalasi_id, syaratbayar_id, rencanakebfarmasi_id, supplier_id, tglpermintaanpembelian, nopermintaan, tglterimabarang, alamatpengiriman, istermasukppn, istermasukpph, keteranganpermintaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimengetahui_id, pegawaimenyetujui_id, statuspembelian, pegawaimengetahuiumum_id, tglmengetahuiumum, sumberdana_id, noreferensi, batalpermintaanpembelian_id, tgldikirim, tglpermintaanuangmuka, jmlpermintaanuangmuka, pajak_id', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'penerimaanbarang' => array(self::BELONGS_TO, 'PenerimaanbarangT', 'penerimaanbarang_id'),
			'permintaanpenawaran' => array(self::BELONGS_TO, 'PermintaanpenawaranT', 'permintaanpenawaran_id'),
			'rencanakebfarmasi' => array(self::BELONGS_TO, 'RencanakebfarmasiT', 'rencanakebfarmasi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'syaratbayar' => array(self::BELONGS_TO, 'SyaratbayarM', 'syaratbayar_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'penerimaanbarangTs' => array(self::HAS_MANY, 'PenerimaanbarangT', 'permintaanpembelian_id'),
			'permintaandetailTs' => array(self::HAS_MANY, 'PermintaandetailT', 'permintaanpembelian_id'),
                        'pegawaimengetahuiumum' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahuiumum_id'),
                        'pegawaiapoteker' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaiapoteker_id'),
                    'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
                    'pajak' => array(self::BELONGS_TO, 'PajakM', 'pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'permintaanpembelian_id' => 'Permintaan Pembelian',
			'ruangan_id' => 'Ruangan',
			'penerimaanbarang_id' => 'Penerimaan Barang',
			'pegawai_id' => 'Pegawai',
			'sumberdana_id' => 'Sumber Dana',
			'sumberdana_id_langsung' => 'Sumber Dana',
			'permintaanpenawaran_id' => 'Permintaan Penawaran',
			'instalasi_id' => 'Instalasi',
			'syaratbayar_id' => 'Syarat Bayar',
			'rencanakebfarmasi_id' => 'Rencana Kebutuhan Farmasi',
			'supplier_id' => 'Distributor',
            'supplier_alamat' => 'Alamat Distributor',
			'tglpermintaanpembelian' => 'Tanggal Permintaan Pembelian',
			'nopermintaan' => 'No. Permintaan',
			'tglterimabarang' => 'Tanggal Terima Barang',
			'alamatpengiriman' => 'Alamat Pengiriman',
			'istermasukppn' => 'Is Termasuk PPN',
			'istermasukpph' => 'Is Termasuk PPH',
			'keteranganpermintaan' => 'Keterangan Permintaan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaimengetahui_id' => 'Purchasing',
			'pegawaimenyetujui_id' => 'Penanggung Jawab Penunjang',
			'pegawaiapoteker_id' => 'Penanggung Jawab Apoteker',
			'statuspembelian' => 'Status Pembelian',
            'pegawaiapoteker_nama' => 'Penanggung Jawab Apoteker',
            'pegawaiapoteker_alamat' => 'Alamat',
            'pegawaiapoteker_sipa' => 'No. SIPA',
                    'noreferensi'=>'No Referensi',
                    'tgldikirim' => 'Tanggal Dikirim'
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

		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('permintaanpenawaran_id',$this->permintaanpenawaran_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('rencanakebfarmasi_id',$this->rencanakebfarmasi_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('tglpermintaanpembelian',$this->tglpermintaanpembelian,true);
		$criteria->compare('nopermintaan',$this->nopermintaan,true);
		$criteria->compare('tglterimabarang',$this->tglterimabarang,true);
		$criteria->compare('alamatpengiriman',$this->alamatpengiriman,true);
		$criteria->compare('istermasukppn',$this->istermasukppn);
		$criteria->compare('istermasukpph',$this->istermasukpph);
		$criteria->compare('keteranganpermintaan',$this->keteranganpermintaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('statuspembelian',$this->statuspembelian,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}