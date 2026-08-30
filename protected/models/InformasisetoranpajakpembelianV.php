<?php

/**
 * This is the model class for table "informasisetoranpajakpembelian_v".
 *
 * The followings are the available columns in table 'informasisetoranpajakpembelian_v':
 * @property integer $setoranpajak_id
 * @property string $tglsetoranpajak
 * @property double $totalhutang
 * @property double $jmlpembayaran
 * @property double $sisahutang
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $no_setorpajakpembelian
 * @property double $biaya_materai
 * @property double $jmlkaskeluar
 * @property integer $pajak_id
 * @property string $pajak_nama
 * @property string $petugaspenyetor
 * @property integer $faktur_id
 * @property string $nofaktur
 * @property string $tglfaktur
 */
class InformasisetoranpajakpembelianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisetoranpajakpembelianV the static model class
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
		return 'informasisetoranpajakpembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranpajak_id, tandabuktikeluar_id, pajak_id, faktur_id, petugaspenyetor_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, jmlpembayaran, sisahutang, biaya_materai, jmlkaskeluar', 'numerical'),
			array('nokaskeluar, no_setorpajakpembelian, nofaktur', 'length', 'max'=>50),
			array('pajak_nama', 'length', 'max'=>100),
			array('tglsetoranpajak, tglkaskeluar, petugaspenyetor, tglfaktur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranpajak_id, tglsetoranpajak, totalhutang, jmlpembayaran, sisahutang, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, pajak_id, pajak_nama, petugaspenyetor, faktur_id, nofaktur, tglfaktur, petugaspenyetor_id', 'safe', 'on'=>'search'),
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
			'sisahutang' => 'Sisahutang',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'no_setorpajakpembelian' => 'No. Penyetoran',
			'biaya_materai' => 'Biaya Materai',
			'jmlkaskeluar' => 'Jumlah Kas Keluar',
			'pajak_id' => 'Pajak',
			'pajak_nama' => 'Pajak Nama',
			'petugaspenyetor' => 'Petugas Penyetor',
			'faktur_id' => 'Faktur',
			'nofaktur' => 'No. Faktur',
			'tglfaktur' => 'Tanggal Faktur',
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
		$criteria->compare('sisahutang',$this->sisahutang);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('no_setorpajakpembelian',$this->no_setorpajakpembelian,true);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('pajak_id',$this->pajak_id);
		$criteria->compare('pajak_nama',$this->pajak_nama,true);
		$criteria->compare('petugaspenyetor',$this->petugaspenyetor,true);
		$criteria->compare('faktur_id',$this->faktur_id);
		$criteria->compare('nofaktur',$this->nofaktur,true);
		$criteria->compare('tglfaktur',$this->tglfaktur,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}