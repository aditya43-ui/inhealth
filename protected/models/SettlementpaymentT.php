<?php

/**
 * This is the model class for table "settlementpayment_t".
 *
 * The followings are the available columns in table 'settlementpayment_t':
 * @property integer $settlementpayment_id
 * @property integer $advancepayment_id
 * @property integer $tandabuktibayar_id
 * @property integer $tandabuktikeluar_id
 * @property integer $komponengaji_id
 * @property integer $profilrs_id
 * @property string $tglsettlement
 * @property string $nosettlement
 * @property double $jmladvance
 * @property double $realisasipembelian
 * @property double $sisaadvance
 * @property double $jmlpembayaran
 * @property double $sisapengembalian
 * @property double $kekuranganrealisasi
 * @property double $sisakekurangan
 * @property boolean $ispotonggaji
 * @property boolean $ispiutang
 * @property boolean $ishutang
 * @property double $totalpotongan
 * @property double $totalpiutang
 * @property double $totalhutang
 * @property string $tgljatuhtempo
 * @property integer $pegawai_id
 * @property integer $pegawaisettlement_id
 * @property string $terimadari
 * @property string $sebagaipembayaran
 * @property string $tglpembatalan
 * @property integer $pegawaibatal_id
 * @property string $alasanpembatalan
 *
 * The followings are the available model relations:
 * @property SettlementpaymentlampT[] $settlementpaymentlampTs
 * @property SettlementpaymentdetT[] $settlementpaymentdetTs
 * @property AdvancepaymentT $advancepayment
 * @property TandabuktibayarT $tandabuktibayar
 * @property TandabuktikeluarT $tandabuktikeluar
 * @property ProfilrumahsakitM $profilrs
 * @property KomponengajiM $komponengaji
 */
class SettlementpaymentT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SettlementpaymentT the static model class
	 */
	public $hutangrealisasi,$jmlpembayaran2,$pegawaibatal_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settlementpayment_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglsettlement,realisasipembelian,profilrs_id,sisarealisasi,jmlpembayaran,jmladvance,sisapengembalian, nosettlement', 'required'),
			array('advancepayment_id, tandabuktibayar_id, tandabuktikeluar_id, komponengaji_id, profilrs_id, pegawai_id, pegawaisettlement_id, pegawaibatal_id', 'numerical', 'integerOnly'=>true),
			array('jmladvance, realisasipembelian, sisaadvance,sisarealisasi, jmlpembayaran, sisapengembalian, kekuranganrealisasi, sisakekurangan, totalpotongan, totalpiutang, totalhutang', 'numerical'),
			array('nosettlement', 'length', 'max'=>50),
			array('periodegaji', 'safe'),
			array('terimadari, sebagaipembayaran', 'length', 'max'=>100),
			array('ispotonggaji, ispiutang, ishutang, tgljatuhtempo, tglpembatalan, alasanpembatalan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('settlementpayment_id, advancepayment_id, tandabuktibayar_id, tandabuktikeluar_id, komponengaji_id, profilrs_id, tglsettlement, nosettlement, jmladvance, realisasipembelian, sisaadvance, jmlpembayaran, sisapengembalian, kekuranganrealisasi, sisakekurangan, ispotonggaji, ispiutang, ishutang, totalpotongan, totalpiutang, totalhutang, tgljatuhtempo, pegawai_id, pegawaisettlement_id, terimadari, sebagaipembayaran, tglpembatalan, pegawaibatal_id, alasanpembatalan', 'safe', 'on'=>'search'),
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
			'settlementpaymentlampTs' => array(self::HAS_MANY, 'SettlementpaymentlampT', 'settlementpayment_id'),
			'settlementpaymentdetTs' => array(self::HAS_MANY, 'SettlementpaymentdetT', 'settlementpayment_id'),
			'advancepayment' => array(self::BELONGS_TO, 'AdvancepaymentT', 'advancepayment_id'),
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
			'tandabuktikeluar' => array(self::BELONGS_TO, 'TandabuktikeluarT', 'tandabuktikeluar_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pegawaibatal' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaibatal_id'),
			'pegawaisettlement' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaisettlement_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'settlementpayment_id' => 'Settlementpayment',
			'advancepayment_id' => 'Advancepayment',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tandabuktikeluar_id' => 'Tandabuktikeluar',
			'komponengaji_id' => 'Komponengaji',
			'profilrs_id' => 'Klinik',
			'tglsettlement' => 'Tgl. Settlement',
			'nosettlement' => 'No. Settlement',
			'jmladvance' => 'Jumlah Advance Payment',
			'realisasipembelian' => 'Realisasi Pembelian',
			'sisaadvance' => 'Sisaadvance',
			// 'jmlpembayaran' => 'Jmlpembayaran',
			'kekuranganrealisasi' => 'Hutang Realisasi Pembelian',
			'sisakekurangan' => 'Sisa Hutang Realisasi Pembelian',
			'ispotonggaji' => 'Ispotonggaji',
			'periodegaji' => 'Periode Gaji',
			'ispiutang' => 'Ispiutang',
			'ishutang' => 'Ishutang',
			'totalpotongan' => 'Totalpotongan',
			'totalpiutang' => 'Total Piutang',
			'totalhutang' => 'Totalhutang',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'pegawai_id' => 'Pegawai',
			'pegawaisettlement_id' => 'Pegawaisettlement',
			'terimadari' => 'Terima Dari',
			'sebagaipembayaran' => 'Sebagai Pembayaran',
			'tglpembatalan' => 'Tglpembatalan',
			'pegawaibatal_id' => 'Pegawaibatal',
			'alasanpembatalan' => 'Alasanpembatalan',
			'sisapengembalian' => 'Sisa Pengembalian Advance Payment',
			'sisarealisasi' =>'Sisa Advance Payment',
			'jmlpembayaran' =>'Jumlah Pengembalian',
			'jmlpembayaran2' =>'Jumlah Pembayaran',
			
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

		$criteria->compare('settlementpayment_id',$this->settlementpayment_id);
		$criteria->compare('advancepayment_id',$this->advancepayment_id);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('tglsettlement',$this->tglsettlement,true);
		$criteria->compare('nosettlement',$this->nosettlement,true);
		$criteria->compare('jmladvance',$this->jmladvance);
		$criteria->compare('realisasipembelian',$this->realisasipembelian);
		$criteria->compare('sisaadvance',$this->sisaadvance);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('sisapengembalian',$this->sisapengembalian);
		$criteria->compare('kekuranganrealisasi',$this->kekuranganrealisasi);
		$criteria->compare('sisakekurangan',$this->sisakekurangan);
		$criteria->compare('ispotonggaji',$this->ispotonggaji);
		$criteria->compare('ispiutang',$this->ispiutang);
		$criteria->compare('ishutang',$this->ishutang);
		$criteria->compare('totalpotongan',$this->totalpotongan);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawaisettlement_id',$this->pegawaisettlement_id);
		$criteria->compare('terimadari',$this->terimadari,true);
		$criteria->compare('sebagaipembayaran',$this->sebagaipembayaran,true);
		$criteria->compare('tglpembatalan',$this->tglpembatalan,true);
		$criteria->compare('pegawaibatal_id',$this->pegawaibatal_id);
		$criteria->compare('alasanpembatalan',$this->alasanpembatalan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}