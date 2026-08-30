<?php

/**
 * This is the model class for table "informasipembayaransupplierkolektif_v".
 *
 * The followings are the available columns in table 'informasipembayaransupplierkolektif_v':
 * @property integer $bayarkesupplier_id
 * @property string $tglbayarkesupplier
 * @property string $supplier_nama
 * @property string $supplier_jenis
 * @property double $totaltagihan
 * @property double $jmldibayarkan
 * @property double $totalsisatagihan
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $no_setorpajakpembelian
 * @property double $biayaadministrasi
 * @property double $biayaongkos_kirim
 * @property double $jmlkaskeluar
 * @property string $petugaspenyetor
 * @property integer $petugaspenyetor_id
 */
class InformasipembayaransupplierkolektifV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipembayaransupplierkolektifV the static model class
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
		return 'informasipembayaransupplierkolektif_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bayarkesupplier_id, tandabuktikeluar_id, petugaspenyetor_id', 'numerical', 'integerOnly'=>true),
			array('totaltagihan, jmldibayarkan, totalsisatagihan, biayaadministrasi, biayaongkos_kirim, jmlkaskeluar', 'numerical'),
			array('nokaskeluar', 'length', 'max'=>50),
			array('no_setorpajakpembelian', 'length', 'max'=>30),
			array('tglbayarkesupplier, supplier_nama, supplier_jenis, tglkaskeluar, petugaspenyetor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bayarkesupplier_id, tglbayarkesupplier, supplier_nama, supplier_jenis, totaltagihan, jmldibayarkan, totalsisatagihan, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, no_setorpajakpembelian, biayaadministrasi, biayaongkos_kirim, jmlkaskeluar, petugaspenyetor, petugaspenyetor_id', 'safe', 'on'=>'search'),
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
			'bayarkesupplier_id' => 'Bayar ke Supplier',
			'tglbayarkesupplier' => 'Tgl. Bayar ke Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_jenis' => 'Supplier Jenis',
			'totaltagihan' => 'Total Tagihan',
			'jmldibayarkan' => 'Jumlah Dibayarkan',
			'totalsisatagihan' => 'Totalsisatagihan',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'no_setorpajakpembelian' => 'No. Pembayaran',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayaongkos_kirim' => 'Biayaongkos Kirim',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'petugaspenyetor' => 'Petugas Penyetor',
			'petugaspenyetor_id' => 'Petugaspenyetor',
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

		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('tglbayarkesupplier',$this->tglbayarkesupplier,true);
		$criteria->compare('supplier_nama',$this->supplier_nama,true);
		$criteria->compare('supplier_jenis',$this->supplier_jenis,true);
		$criteria->compare('totaltagihan',$this->totaltagihan);
		$criteria->compare('jmldibayarkan',$this->jmldibayarkan);
		$criteria->compare('totalsisatagihan',$this->totalsisatagihan);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('no_setorpajakpembelian',$this->no_setorpajakpembelian,true);
		$criteria->compare('biayaadministrasi',$this->biayaadministrasi);
		$criteria->compare('biayaongkos_kirim',$this->biayaongkos_kirim);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('petugaspenyetor',$this->petugaspenyetor,true);
		$criteria->compare('petugaspenyetor_id',$this->petugaspenyetor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
