<?php

/**
 * This is the model class for table "penerimaanbarang_t".
 *
 * The followings are the available columns in table 'penerimaanbarang_t':
 * @property integer $penerimaanbarang_id
 * @property integer $fakturpembelian_id
 * @property integer $supplier_id
 * @property integer $permintaanpembelian_id
 * @property integer $returpembelian_id
 * @property string $noterima
 * @property string $tglterima
 * @property string $tglterimafaktur
 * @property string $nosuratjalan
 * @property string $tglsuratjalan
 * @property integer $gudangpenerima_id
 * @property string $keteranganterima
 * @property double $harganetto
 * @property double $jmldiscount
 * @property double $persendiscount
 * @property double $totalpajakppn
 * @property double $totalpajakpph
 * @property double $totalharga
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawai_id
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $statuspenerimaan
 *
 * The followings are the available model relations:
 * @property FakturpembelianT[] $fakturpembelianTs
 * @property PenerimaandetailT[] $penerimaandetailTs
 * @property PermintaanpembelianT[] $permintaanpembelianTs
 * @property FakturpembelianT $fakturpembelian
 * @property PermintaanpembelianT $permintaanpembelian
 * @property ReturpembelianT $returpembelian
 * @property SupplierM $supplier
 * @property RuanganM $gudangpenerima
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 * @property PegawaiM $pegawai
 * @property UangmukabeliT[] $uangmukabeliTs
 * @property ReturpembelianT[] $returpembelianTs
 */
class PenerimaanbarangT extends CActiveRecord
{
	public $pegawai_nama;
	public $menyetujui_nama;
	public $mengetahui_nama;
	public $supplier_nama;
	public $nopermintaan;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenerimaanbarangT the static model class
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
		return 'penerimaanbarang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, noterima, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('fakturpembelian_id, supplier_id, permintaanpembelian_id, returpembelian_id, gudangpenerima_id, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, pajak_id, sumberdana_id', 'numerical', 'integerOnly'=>true),
			array('harganetto, jmldiscount, persendiscount, totalpajakppn, totalpajakpph, totalharga', 'numerical'),
			array('noterima, statuspenerimaan', 'length', 'max'=>20),
			array('nosuratjalan', 'length', 'max'=>50),
			array('pembelianlangsung, tglterima, tglterimafaktur, tglsuratjalan, keteranganterima, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penerimaanbarang_id, fakturpembelian_id, supplier_id, permintaanpembelian_id, returpembelian_id, noterima, tglterima, tglterimafaktur, nosuratjalan, tglsuratjalan, gudangpenerima_id, keteranganterima, harganetto, jmldiscount, persendiscount, totalpajakppn, totalpajakpph, totalharga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, statuspenerimaan, pajak_id, sumberdana_id', 'safe', 'on'=>'search'),
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
			'fakturpembelianTs' => array(self::HAS_MANY, 'FakturpembelianT', 'penerimaanbarang_id'),
			'penerimaandetailTs' => array(self::HAS_MANY, 'PenerimaandetailT', 'penerimaanbarang_id'),
			'permintaanpembelianTs' => array(self::HAS_MANY, 'PermintaanpembelianT', 'penerimaanbarang_id'),
			'fakturpembelian' => array(self::BELONGS_TO, 'FakturpembelianT', 'fakturpembelian_id'),
			'permintaanpembelian' => array(self::BELONGS_TO, 'PermintaanpembelianT', 'permintaanpembelian_id'),
			'returpembelian' => array(self::BELONGS_TO, 'ReturpembelianT', 'returpembelian_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'gudangpenerima' => array(self::BELONGS_TO, 'RuanganM', 'gudangpenerima_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'sumberdana' => array(self::BELONGS_TO, 'SumberdanaM', 'sumberdana_id'),
			'uangmukabeliTs' => array(self::HAS_MANY, 'UangmukabeliT', 'penerimaanbarang_id'),
			'returpembelianTs' => array(self::HAS_MANY, 'ReturpembelianT', 'penerimaanbarang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penerimaanbarang_id' => 'Penerimaan Barang',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'supplier_id' => 'Supplier',
			'permintaanpembelian_id' => 'Permintaan Pembelian',
			'returpembelian_id' => 'Retur Pembelian',
			'noterima' => 'No. Terima',
			'tglterima' => 'Tanggal Terima',
			'tglterimafaktur' => 'Tanggal Terima Faktur',
			'nosuratjalan' => 'No. Faktur',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
			'gudangpenerima_id' => 'Gudang Penerima',
			'keteranganterima' => 'Keterangan Terima',
			'harganetto' => 'Harga Netto',
			'jmldiscount' => 'Jumlah Keringanan',
			'persendiscount' => 'Persen Keringanan',
			'totalpajakppn' => 'Total Pajak PPN',
			'totalpajakpph' => 'Total Pajak PPH',
			'totalharga' => 'Total Harga',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawai_id' => 'Pegawai',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'statuspenerimaan' => 'Status Penerimaan',
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

		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('permintaanpembelian_id',$this->permintaanpembelian_id);
		$criteria->compare('returpembelian_id',$this->returpembelian_id);
		$criteria->compare('noterima',$this->noterima,true);
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('tglterimafaktur',$this->tglterimafaktur,true);
		$criteria->compare('nosuratjalan',$this->nosuratjalan,true);
		$criteria->compare('tglsuratjalan',$this->tglsuratjalan,true);
		$criteria->compare('gudangpenerima_id',$this->gudangpenerima_id);
		$criteria->compare('keteranganterima',$this->keteranganterima,true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('totalpajakppn',$this->totalpajakppn);
		$criteria->compare('totalpajakpph',$this->totalpajakpph);
		$criteria->compare('totalharga',$this->totalharga);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('statuspenerimaan',$this->statuspenerimaan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}