<?php

/**
 * This is the model class for table "laporanlabarugi_v".
 *
 * The followings are the available columns in table 'laporanlabarugi_v':
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property string $deskripsi
 * @property boolean $isclosing
 * @property integer $konfiganggaran_id
 * @property string $deskripsiperiode
 * @property string $tglanggaran
 * @property string $sd_tglanggaran
 * @property string $tglrencanaanggaran
 * @property string $sd_tglrencanaanggaran
 * @property string $tglrevisianggaran
 * @property string $sd_tglrevisianggaran
 * @property string $digitnilaianggaran
 * @property boolean $isclosing_anggaran
 * @property integer $periodeposting_id
 * @property string $periodeposting_nama
 * @property string $tglperiodeposting_awal
 * @property string $tglperiodeposting_akhir
 * @property string $deskripsiperiodeposting
 * @property boolean $periodeposting_aktif
 * @property integer $laporanlabarugi_id
 * @property integer $laporanlabarugidetail_id
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
 * @property string $rekening5_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property string $kelompokrek
 * @property boolean $sak
 * @property double $saldodebit
 * @property double $saldokredit
 * @property integer $bukubesar_id
 * @property double $pendapatanoperasional
 * @property double $pendapatannonoperasional
 * @property double $pendapatan
 * @property double $bebanoperasional
 * @property double $bebannonoperasional
 * @property double $beban
 * @property double $labarugisebelumpajak
 * @property double $pajak
 * @property double $labarugi
 * @property string $keteranganlabarugi
 * @property double $saldoakhirberjalan
 */
class LaporanlabarugiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanlabarugiV the static model class
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
		return 'laporanlabarugi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id, konfiganggaran_id, periodeposting_id, laporanlabarugi_id, laporanlabarugidetail_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, nourutrek, bukubesar_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit, pendapatanoperasional, pendapatannonoperasional, pendapatan, bebanoperasional, bebannonoperasional, beban, labarugisebelumpajak, pajak, labarugi, saldoakhirberjalan', 'numerical'),
			array('deskripsi, deskripsiperiodeposting, nmrekening2', 'length', 'max'=>200),
			array('deskripsiperiode, periodeposting_nama, nmrekening1', 'length', 'max'=>100),
			array('digitnilaianggaran', 'length', 'max'=>10),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5, keteranganlabarugi', 'length', 'max'=>5),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('rekening5_nb', 'length', 'max'=>1),
			array('kelompokrek', 'length', 'max'=>20),
			array('perideawal, sampaidgn, isclosing, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, isclosing_anggaran, tglperiodeposting_awal, tglperiodeposting_akhir, periodeposting_aktif, keterangan, sak', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekperiod_id, perideawal, sampaidgn, deskripsi, isclosing, konfiganggaran_id, deskripsiperiode, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, digitnilaianggaran, isclosing_anggaran, periodeposting_id, periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, deskripsiperiodeposting, periodeposting_aktif, laporanlabarugi_id, laporanlabarugidetail_id, rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, rekening5_nb, keterangan, nourutrek, kelompokrek, sak, saldodebit, saldokredit, bukubesar_id, pendapatanoperasional, pendapatannonoperasional, pendapatan, bebanoperasional, bebannonoperasional, beban, labarugisebelumpajak, pajak, labarugi, keteranganlabarugi, saldoakhirberjalan', 'safe', 'on'=>'search'),
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
			'rekperiod_id' => 'Periode Rekening',
			'perideawal' => 'Periode Awal',
			'sampaidgn' => 'Sampai Dengan',
			'deskripsi' => 'Deskripsi',
			'isclosing' => 'Is Closing',
			'konfiganggaran_id' => 'Konfig Anggaran',
			'deskripsiperiode' => 'Deskripsi Periode',
			'tglanggaran' => 'Tanggal Anggaran',
			'sd_tglanggaran' => 'Sampai Dengan',
			'tglrencanaanggaran' => 'Tanggal Rencana Anggaran',
			'sd_tglrencanaanggaran' => 'Sampai Dengan',
			'tglrevisianggaran' => 'Tanggal Revisi Anggaran',
			'sd_tglrevisianggaran' => 'Sampai Dengan',
			'digitnilaianggaran' => 'Digit Nilai Anggaran',
			'isclosing_anggaran' => 'Is Closing Anggaran',
			'periodeposting_id' => 'Periode Posting',
			'periodeposting_nama' => 'Nama Periode Posting',
			'tglperiodeposting_awal' => 'Tanggal Awal Periode Posting',
			'tglperiodeposting_akhir' => 'Tanggal Akhir Periode Posting',
			'deskripsiperiodeposting' => 'Deskripsi Periode Posting',
			'periodeposting_aktif' => 'Periode Posting Aktif',
			'laporanlabarugi_id' => 'Laporan Laba Rugi',
			'laporanlabarugidetail_id' => 'Laporan Laba Rugi Detail',
			'rekening1_id' => 'Rekening 1',
			'kdrekening1' => 'Kode Rekening 1',
			'nmrekening1' => 'Nama Rekening 1',
			'rekening2_id' => 'Rekening 2',
			'kdrekening2' => 'Kode Rekening 2',
			'nmrekening2' => 'Nama Rekening 2',
			'rekening3_id' => 'Rekening 3',
			'kdrekening3' => 'Kode Rekening 3',
			'nmrekening3' => 'Nama Rekening 3',
			'rekening4_id' => 'Rekening 4',
			'kdrekening4' => 'Kode Rekening 4',
			'nmrekening4' => 'Nama Rekening 4',
			'rekening5_id' => 'Rekening 5',
			'kdrekening5' => 'Kode Rekening 5',
			'nmrekening5' => 'Nama Rekening 5',
			'rekening5_nb' => 'Rekening 5 NB',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'No. Urut Rekening',
			'kelompokrek' => 'Kelompok Rekening',
			'sak' => 'Sak',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'bukubesar_id' => 'Buku Besar',
			'pendapatanoperasional' => 'Pendapatan Operasional',
			'pendapatannonoperasional' => 'Pendapatan Non Operasional',
			'pendapatan' => 'Pendapatan',
			'bebanoperasional' => 'Beban Operasional',
			'bebannonoperasional' => 'Beban Non Opereasional',
			'beban' => 'Beban',
			'labarugisebelumpajak' => 'Laba Rugi Sebelum Pajak',
			'pajak' => 'Pajak',
			'labarugi' => 'Laba Rugi',
			'keteranganlabarugi' => 'Keterangan Laba Rugi',
			'saldoakhirberjalan' => 'Saldo Akhir Berjalan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',$this->isclosing);
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
		$criteria->compare('LOWER(tglanggaran)',strtolower($this->tglanggaran),true);
		$criteria->compare('LOWER(sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
		$criteria->compare('LOWER(tglrencanaanggaran)',strtolower($this->tglrencanaanggaran),true);
		$criteria->compare('LOWER(sd_tglrencanaanggaran)',strtolower($this->sd_tglrencanaanggaran),true);
		$criteria->compare('LOWER(tglrevisianggaran)',strtolower($this->tglrevisianggaran),true);
		$criteria->compare('LOWER(sd_tglrevisianggaran)',strtolower($this->sd_tglrevisianggaran),true);
		$criteria->compare('LOWER(digitnilaianggaran)',strtolower($this->digitnilaianggaran),true);
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		$criteria->compare('periodeposting_aktif',$this->periodeposting_aktif);
		if(!empty($this->laporanlabarugi_id)){
			$criteria->addCondition('laporanlabarugi_id = '.$this->laporanlabarugi_id);
		}
		if(!empty($this->laporanlabarugidetail_id)){
			$criteria->addCondition('laporanlabarugidetail_id = '.$this->laporanlabarugidetail_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('pendapatanoperasional',$this->pendapatanoperasional);
		$criteria->compare('pendapatannonoperasional',$this->pendapatannonoperasional);
		$criteria->compare('pendapatan',$this->pendapatan);
		$criteria->compare('bebanoperasional',$this->bebanoperasional);
		$criteria->compare('bebannonoperasional',$this->bebannonoperasional);
		$criteria->compare('beban',$this->beban);
		$criteria->compare('labarugisebelumpajak',$this->labarugisebelumpajak);
		$criteria->compare('pajak',$this->pajak);
		$criteria->compare('labarugi',$this->labarugi);
		$criteria->compare('LOWER(keteranganlabarugi)',strtolower($this->keteranganlabarugi),true);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}