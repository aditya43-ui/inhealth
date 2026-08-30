<?php

/**
 * This is the model class for table "informasisetoranhutangpajak_v".
 *
 * The followings are the available columns in table 'informasisetoranhutangpajak_v':
 * @property integer $setoranpajak_id
 * @property string $tglsetoranpajak
 * @property double $totalhutang
 * @property double $jmlpembayaran
 * @property double $totalsisahutang
 * @property string $jenissetoran
 * @property string $tglbatalsetor
 * @property integer $batalpegawai_id
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $no_setorpajakpembelian
 * @property double $biaya_materai
 * @property double $jmlkaskeluar
 * @property string $petugaspenyetor
 * @property integer $petugaspenyetor_id
 */
class InformasisetoranhutangpajakV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisetoranhutangpajakV the static model class
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
		return 'informasisetoranhutangpajak_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranpajak_id, batalpegawai_id, tandabuktikeluar_id, petugaspenyetor_id, pajak_id', 'numerical', 'integerOnly'=>true),
			array('totalhutang, jmlpembayaran, totalsisahutang, biaya_materai, jmlkaskeluar', 'numerical'),
			array('jenissetoran', 'length', 'max'=>40),
			array('nokaskeluar', 'length', 'max'=>50),
                    array('pajak_nama', 'length', 'max'=>100),
			array('no_setorpajakpembelian', 'length', 'max'=>30),
			array('tglsetoranpajak, tglbatalsetor, tglkaskeluar, petugaspenyetor', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('setoranpajak_id, tglsetoranpajak, totalhutang, jmlpembayaran, totalsisahutang, jenissetoran, tglbatalsetor, batalpegawai_id, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, no_setorpajakpembelian, biaya_materai, jmlkaskeluar, petugaspenyetor, petugaspenyetor_id, pajak_id, pajak_nama', 'safe', 'on'=>'search'),
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
			'jenissetoran' => 'Jenissetoran',
			'tglbatalsetor' => 'Tglbatalsetor',
			'batalpegawai_id' => 'Batalpegawai',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'no_setorpajakpembelian' => 'No. Penyetoran',
			'biaya_materai' => 'Biaya Materai',
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

		$criteria->compare('setoranpajak_id',$this->setoranpajak_id);
		$criteria->compare('tglsetoranpajak',$this->tglsetoranpajak,true);
		$criteria->compare('totalhutang',$this->totalhutang);
		$criteria->compare('jmlpembayaran',$this->jmlpembayaran);
		$criteria->compare('totalsisahutang',$this->totalsisahutang);
		$criteria->compare('jenissetoran',$this->jenissetoran,true);
		$criteria->compare('tglbatalsetor',$this->tglbatalsetor,true);
		$criteria->compare('batalpegawai_id',$this->batalpegawai_id);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('no_setorpajakpembelian',$this->no_setorpajakpembelian,true);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('jmlkaskeluar',$this->jmlkaskeluar);
		$criteria->compare('petugaspenyetor',$this->petugaspenyetor,true);
		$criteria->compare('petugaspenyetor_id',$this->petugaspenyetor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}