<?php

/**
 * This is the model class for table "laporanbukubesar_v".
 *
 * The followings are the available columns in table 'laporanbukubesar_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $tiperekening_id
 * @property string $nourut
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property integer $jurnalposting_id
 * @property string $tgljurnalpost
 * @property string $noreferensi
 */
class LaporanbukubesarV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanbukubesarV the static model class
	 */
        public $data;
        public $jumlah;
        public $tick;
        public $is_tglposting, $is_tgltransaksi, $urutan, $tgl_posting_awal, $tgl_posting_akhir, $tgl_transaksi_awal, $tgl_transaksi_akhir;
          
        public $tgl_awal, $tgl_akhir;
        public $kelrekening_id, $rekening5_id;
        
        public $namaRekening, $kodeRekening;
				public $ishpp, $ispendapatan, $isbebanusaha, $ispendapatanluar, $isbebanluar, $isbebankeluar;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanbukubesar_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening5_id, tiperekening_id, jurnalposting_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			array('kdrekening5', 'length', 'max'=>5),
			array('nmrekening5', 'length', 'max'=>500),
			array('uraiantransaksi, tgljurnalpost, noreferensi, periodeposting_id, unitkerja_id, rekening5_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitkerja_id, tgl_awal, namaRekening, kodeRekening, tgl_akhir, rekening5_id, kdrekening5, nmrekening5, tiperekening_id, uraiantransaksi, saldodebit, saldokredit, jurnalposting_id, tgljurnalpost, noreferensi, periodeposting_id, rekening5_aktif', 'safe', 'on'=>'search'),
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
			'rekening5_id' => 'Rekening5',
			'kdrekening5' => 'Kdrekening5',
			'nmrekening5' => 'Nmrekening5',
			'tiperekening_id' => 'Tiperekening',
			'uraiantransaksi' => 'Uraiantransaksi',
			'saldodebit' => 'Saldodebit',
			'saldokredit' => 'Saldokredit',
			'jurnalposting_id' => 'Jurnalposting',
			'tgljurnalpost' => 'Tgljurnalpost',
			'noreferensi' => 'Noreferensi',
			'tgl_awal'=>'Tanggal Posting',
			'tgl_akhir'=>'Sampai Dengan',
			'periodeposting_id'=>'Periode Posting',
			'unitkerja_id'=>'Unit Kerja',
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

		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}