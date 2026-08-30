<?php

/**
 * This is the model class for table "fakturpembelian_t".
 *
 * The followings are the available columns in table 'fakturpembelian_t':
 * @property integer $fakturpembelian_id
 * @property integer $penerimaanbarang_id
 * @property integer $supplier_id
 * @property integer $bayarkesupplier_id
 * @property integer $syaratbayar_id
 * @property integer $ruangan_id
 * @property string $nofaktur
 * @property string $tglfaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property double $totharganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $biayamaterai
 * @property double $totalpajakpph
 * @property double $totalpajakppn
 * @property double $totalhargabruto
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $pegawai_id
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $nobatch
 *
 * The followings are the available model relations:
 * @property BayarkesupplierT $bayarkesupplier
 * @property PenerimaanbarangT $penerimaanbarang
 * @property RuanganM $ruangan
 * @property SupplierM $supplier
 * @property SyaratbayarM $syaratbayar
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 * @property PegawaiM $pegawai
 * @property PenerimaanbarangT[] $penerimaanbarangTs
 * @property ReturpembelianT[] $returpembelianTs
 * @property FakturdetailT[] $fakturdetailTs
 * @property BayarkesupplierT[] $bayarkesupplierTs
 */
class FakturpembelianT extends CActiveRecord
{
	public $supplier_nama;
	public $sisa;
	public $umur_hutang;
        public $persenpph_22, $pajak_nama;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturpembelianT the static model class
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
		return 'fakturpembelian_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penerimaanbarang_id, supplier_id, ruangan_id, nofaktur, tglfaktur, tgljatuhtempo', 'required'),
			array('penerimaanbarang_id, supplier_id, bayarkesupplier_id, syaratbayar_id, ruangan_id, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, pegawaimenyetujuikeuangan_id, pajak_id', 'numerical', 'integerOnly'=>true),
			array('totharganetto, persendiscount, jmldiscount, biayamaterai, totalpajakpph, totalpajakppn, totalhargabruto, jmluangmukabeli, totalhutangusaha', 'numerical'),
			array('nofaktur, nobatch', 'length', 'max'=>50),
                        array('nofaktur', 'validasiNoFaktur','on'=>'insert'),
			array('supplier_nama, keteranganfaktur, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_menyetujuikeuangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplier_nama, fakturpembelian_id, penerimaanbarang_id, supplier_id, bayarkesupplier_id, syaratbayar_id, ruangan_id, nofaktur, tglfaktur, tgljatuhtempo, keteranganfaktur, totharganetto, persendiscount, jmldiscount, biayamaterai, totalpajakpph, totalpajakppn, totalhargabruto, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawai_id, pegawaimengetahui_id, pegawaimenyetujui_id, nobatch, pegawaimenyetujuikeuangan_id, tgl_menyetujuikeuangan, pajak_id, jmluangmukabeli, totalhutangusaha', 'safe', 'on'=>'search'),
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
			'bayarkesupplier' => array(self::BELONGS_TO, 'BayarkesupplierT', 'bayarkesupplier_id'),
			'penerimaanbarang' => array(self::BELONGS_TO, 'PenerimaanbarangT', 'penerimaanbarang_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'syaratbayar' => array(self::BELONGS_TO, 'SyaratbayarM', 'syaratbayar_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'penerimaanbarangTs' => array(self::HAS_MANY, 'PenerimaanbarangT', 'fakturpembelian_id'),
			'returpembelianTs' => array(self::HAS_MANY, 'ReturpembelianT', 'fakturpembelian_id'),
			'fakturdetailTs' => array(self::HAS_MANY, 'FakturdetailT', 'fakturpembelian_id'),
			'bayarkesupplierTs' => array(self::HAS_MANY, 'BayarkesupplierT', 'fakturpembelian_id'),
			'penerimaan'=>array(self::BELONGS_TO,'PenerimaanbarangT','penerimaanbarang_id'),
                    'pajak'=>array(self::BELONGS_TO,'PajakM','pajak_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fakturpembelian_id' => 'Faktur Pembelian',
			'penerimaanbarang_id' => 'Penerimaanbarang',
			'supplier_id' => 'Supplier',
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'syaratbayar_id' => 'Syaratbayar',
			'ruangan_id' => 'Ruangan',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
			'tgljatuhtempo' => 'Tgl. Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan',
			'totharganetto' => 'Total Harga',
			'persendiscount' => 'Persen Keringanan',
			'jmldiscount' => 'Jumlah Keringanan',
			'biayamaterai' => 'Biayamaterai',
			'totalpajakpph' => 'Total Pph',
			'totalpajakppn' => 'Total Ppn',
			'totalhargabruto' => 'Total Keseluruhan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawai_id' => 'Pegawai',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimenyetujui_id' => 'Pegawaimenyetujui',
			'nobatch' => 'Nobatch',
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

		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
		$criteria->compare('penerimaanbarang_id',$this->penerimaanbarang_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);
		$criteria->compare('tgljatuhtempo',$this->tgljatuhtempo,true);
		$criteria->compare('keteranganfaktur',$this->keteranganfaktur,true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('totalpajakpph',$this->totalpajakpph);
		$criteria->compare('totalpajakppn',$this->totalpajakppn);
		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('nobatch',$this->nobatch,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        function validasiNoFaktur($attribute, $params)
        {
            $dat = self::model()->findByAttributes(array(
                'nofaktur'=>$this->$attribute,
            ));
            if (!empty($dat)) {
                $this->addError($attribute, "Nomor Faktur sudah dicatat sebelumnya.");
            }
        }
}