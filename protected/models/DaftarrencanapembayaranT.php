<?php

/**
 * This is the model class for table "daftarrencanapembayaran_t".
 *
 * The followings are the available columns in table 'daftarrencanapembayaran_t':
 * @property integer $daftarrencanapembayaran_id
 * @property string $tgl_voucher
 * @property string $nama_perusahaan
 * @property string $no_voucher
 * @property string $mak
 * @property string $no_rekening
 * @property double $bruto
 * @property double $ppn
 * @property double $pph
 * @property double $denda
 * @property double $pajakdenda
 * @property double $netto
 */
class DaftarrencanapembayaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftarrencanapembayaranT the static model class
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
		return 'daftarrencanapembayaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('supplier_id, verpengeluaran_id, penerimaanberkas_id, bank_id', 'numerical', 'integerOnly'=>true),
			array('bruto, ppn, pph, pph22, pph23, pphpsl4, denda, pajakdenda, netto', 'numerical'),
			array('namabank, nama_perusahaan', 'length', 'max'=>100),
			array('no_voucher, no_rekening', 'length', 'max'=>50),
			array('mak, kode_lbu', 'length', 'max'=>20),
                        array('jenis_pph', 'length', 'max'=>10),
			array('tgl_voucher, supplier_id, verpengeluaran_id, penerimaanberkas_id, bank_id, jenis_pph, kode_lbu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('namabank, daftarrencanapembayaran_id, tgl_voucher, nama_perusahaan, no_voucher, mak, no_rekening, bruto, ppn, pph, pph22, pph23, pphpsl4, denda, pajakdenda, netto, supplier_id, verpengeluaran_id, penerimaanberkas_id, bank_id, jenis_pph, kode_lbu', 'safe', 'on'=>'search'),
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
			'daftarrencanapembayaran_id' => 'Daftarrencanapembayaran',
			'tgl_voucher' => 'Tgl Voucher',
			'nama_perusahaan' => 'Nama Perusahaan',
			'no_voucher' => 'No Voucher',
			'mak' => 'Mak',
			'no_rekening' => 'No Rekening',
			'bruto' => 'Bruto',
			'ppn' => 'Ppn',
			'pph' => 'Pph',
			'denda' => 'Denda',
			'pajakdenda' => 'Pajakdenda',
			'netto' => 'Netto',
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

		$criteria->compare('daftarrencanapembayaran_id',$this->daftarrencanapembayaran_id);
		$criteria->compare('tgl_voucher',$this->tgl_voucher,true);
		$criteria->compare('nama_perusahaan',$this->nama_perusahaan,true);
		$criteria->compare('no_voucher',$this->no_voucher,true);
		$criteria->compare('mak',$this->mak,true);
		$criteria->compare('no_rekening',$this->no_rekening,true);
		$criteria->compare('bruto',$this->bruto);
		$criteria->compare('ppn',$this->ppn);
		$criteria->compare('pph',$this->pph);
		$criteria->compare('denda',$this->denda);
		$criteria->compare('pajakdenda',$this->pajakdenda);
		$criteria->compare('netto',$this->netto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}