<?php

/**
 * This is the model class for table "informasipembayaranuangmukapembelian_v".
 *
 * The followings are the available columns in table 'informasipembayaranuangmukapembelian_v':
 * @property integer $uangmukabeli_id
 * @property double $jumlahuang
 * @property string $tgluangmukabeli
 * @property string $nopembayaran
 * @property string $nopermintaanpembelian
 * @property string $tglpermintaanuangmuka
 * @property double $jmlpermintaanuangmuka
 * @property integer $supplier_id
 * @property string $supplier_nama
 * @property integer $tandabuktikeluar_id
 * @property string $nokaskeluar
 * @property string $tglkaskeluar
 * @property double $biayaadministrasi
 * @property double $biaya_materai
 * @property double $jmlkaskeluar
 */
class InformasipembayaranuangmukapembelianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayaranuangmukapembelianV the static model class
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
		return 'informasipembayaranuangmukapembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uangmukabeli_id, supplier_id, tandabuktikeluar_id, pegawaibatal_id, alasanbatalbayar', 'numerical', 'integerOnly'=>true),
			array('jumlahuang, jmlpermintaanuangmuka, biayaadministrasi, biaya_materai, jmlkaskeluar, jmlsisauangmuka, totalpo,totalsisahutangpo', 'numerical'),
			array('nopembayaran, supplier_nama', 'length', 'max'=>100),
			array('nokaskeluar', 'length', 'max'=>50),
                        array('supplier_jenis', 'length', 'max'=>20),
			array('tgluangmukabeli, nopermintaanpembelian, tglpermintaanuangmuka, tglkaskeluar, tglbataluangmuka', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uangmukabeli_id, jumlahuang, tgluangmukabeli, nopembayaran, nopermintaanpembelian, tglpermintaanuangmuka, jmlpermintaanuangmuka, supplier_id, supplier_nama, tandabuktikeluar_id, nokaskeluar, tglkaskeluar, biayaadministrasi, biaya_materai, jmlkaskeluar, supplier_jenis, tglbataluangmuka, pegawaibatal_id, alasanbatalbayar, jmlsisauangmuka, totalpo,totalsisahutangpo', 'safe', 'on'=>'search'),
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
			'uangmukabeli_id' => 'Uang Muka Beli',
			'jumlahuang' => 'Jumlahuang',
			'tgluangmukabeli' => 'Tgluangmukabeli',
			'nopembayaran' => 'No. Pembayaran',
			'nopermintaanpembelian' => 'Nopermintaanpembelian',
			'tglpermintaanuangmuka' => 'Tglpermintaanuangmuka',
			'jmlpermintaanuangmuka' => 'Jmlpermintaanuangmuka',
			'supplier_id' => 'Supplier',
			'supplier_nama' => 'Nama Supplier',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biaya_materai' => 'Biaya Materai',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
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

		$criteria->compare('uangmukabeli_id',$this->uangmukabeli_id);
		$criteria->compare('jumlahuang',$this->jumlahuang);
		$criteria->compare('tgluangmukabeli',$this->tgluangmukabeli,true);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('nopermintaanpembelian',$this->nopermintaanpembelian,true);
		$criteria->compare('tglpermintaanuangmuka',$this->tglpermintaanuangmuka,true);
		$criteria->compare('jmlpermintaanuangmuka',$this->jmlpermintaanuangmuka);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
