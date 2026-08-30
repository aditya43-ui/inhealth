<?php

/**
 * This is the model class for table "informasisetoranppnkeluaran_v".
 *
 * The followings are the available columns in table 'informasisetoranppnkeluaran_v':
 * @property integer $setoranpajak_id
 * @property string $tglsetoranpajak
 * @property double $totalhutang
 * @property double $jmlpembayaran
 * @property double $totalsisahutang
 * @property string $tglbatalsetor
 * @property integer $batalpegawai_id
 * @property integer $pajak_id
 * @property string $pajak_nama
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $no_setorpajakpembelian
 * @property double $biaya_materai
 * @property double $jmlkaskeluar
 */
class InformasisetoranppnkeluaranV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisetoranppnkeluaranV the static model class
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
		return 'informasisetoranppnkeluaran_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranpajak_id, batalpegawai_id, pajak_id, tandabuktikeluar_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, jmlpembayaran, totalsisahutang, biaya_materai, jmlkaskeluar', 'numerical'),
			array('pajak_nama', 'length', 'max'=>100),
			array('nokaskeluar', 'length', 'max'=>50),
			array('no_setorpajakpembelian', 'length', 'max'=>30),
			array('tglsetoranpajak, tglbatalsetor, tglkaskeluar, petugaspenyetor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranpajak_id, tglsetoranpajak, totalhutang, jmlpembayaran, totalsisahutang, tglbatalsetor, batalpegawai_id, pajak_id, pajak_nama, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, pegawai_id, petugaspenyetor', 'safe', 'on'=>'search'),
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
			'setoranpajak_id' => 'Setoranpajak',
			'tglsetoranpajak' => 'Tglsetoranpajak',
			'totalhutang' => 'Total Utang',
			'jmlpembayaran' => 'Jmlpembayaran',
			'totalsisahutang' => 'Total Sisa Utang',
			'tglbatalsetor' => 'Tglbatalsetor',
			'batalpegawai_id' => 'Batalpegawai',
			'pajak_id' => 'Pajak',
			'pajak_nama' => 'Pajak Nama',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'no_setorpajakpembelian' => 'No. Pembayaran',
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

		$criteria->compare('setoranpajak_id',$this->setoranpajak_id);
		$criteria->compare('tglsetoranpajak',$this->tglsetoranpajak,true);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('totalsisahutang',$this->totalsisahutang);
		$criteria->compare('tglbatalsetor',$this->tglbatalsetor,true);
		$criteria->compare('batalpegawai_id',$this->batalpegawai_id);
		$criteria->compare('pajak_id',$this->pajak_id);
		$criteria->compare('pajak_nama',$this->pajak_nama,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('no_setorpajakpembelian',$this->no_setorpajakpembelian,true);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
