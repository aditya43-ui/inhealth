<?php

/**
 * This is the model class for table "laporanaruskas_v".
 *
 * The followings are the available columns in table 'laporanaruskas_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $laporanaruskas_id
 * @property integer $laporanlabarugi_id
 * @property integer $laporanneraca_id
 * @property integer $laporanaruskasdetail_id
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
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
 * @property double $saldodebit
 * @property double $saldokredit
 * @property integer $bukubesar_id
 * @property double $kewajiban
 * @property double $investasi
 * @property double $piutang
 * @property double $persediaan
 * @property double $uangmuka
 * @property double $bebandibayardimuka
 * @property double $penyusutandanamortisasi
 * @property double $labarugi
 * @property double $pendapatannonoperasional
 * @property double $bebannonoperasional
 * @property double $ekuitas
 * @property double $selisihaktivalancarnonkas
 * @property double $kelompokoperasional
 * @property double $kelompokinvestasi
 * @property double $kelompokpendanaan
 * @property double $kenaikanpenurunankas
 * @property double $saldoawalperiode
 * @property double $saldoakhirperiode
 * @property integer $periodeposting_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class LaporanaruskasV extends CActiveRecord
{
	public $saldototal;
	public $rekening5_nb;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanaruskasV the static model class
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
		return 'laporanaruskas_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, laporanaruskas_id, laporanlabarugi_id, laporanneraca_id, laporanaruskasdetail_id, kelrekening_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, bukubesar_id, periodeposting_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit, kewajiban, investasi, piutang, persediaan, uangmuka, bebandibayardimuka, penyusutandanamortisasi, labarugi, pendapatannonoperasional, bebannonoperasional, ekuitas, selisihaktivalancarnonkas, kelompokoperasional, kelompokinvestasi, kelompokpendanaan, kenaikanpenurunankas, saldoawalperiode, saldoakhirperiode', 'numerical'),
			array('instalasi_nama, ruangan_nama, koderekeningkel', 'length', 'max'=>50),
			array('namakelrekening, nmrekening1', 'length', 'max'=>100),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('nmrekening2', 'length', 'max'=>200),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, laporanaruskas_id, laporanlabarugi_id, laporanneraca_id, laporanaruskasdetail_id, kelrekening_id, koderekeningkel, namakelrekening, rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, saldodebit, saldokredit, bukubesar_id, kewajiban, investasi, piutang, persediaan, uangmuka, bebandibayardimuka, penyusutandanamortisasi, labarugi, pendapatannonoperasional, bebannonoperasional, ekuitas, selisihaktivalancarnonkas, kelompokoperasional, kelompokinvestasi, kelompokpendanaan, kenaikanpenurunankas, saldoawalperiode, saldoakhirperiode, periodeposting_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'periodePosting' => array(self::HAS_MANY, 'AKPeriodepostingM', 'periodeposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'laporanaruskas_id' => 'Laporan Arus Kas',
			'laporanlabarugi_id' => 'Laporan Laba Rugi',
			'laporanneraca_id' => 'Laporan Neraca',
			'laporanaruskasdetail_id' => 'Laporan Arus Kas Detail',
			'kelrekening_id' => 'Kelompok Rekening',
			'koderekeningkel' => 'Kode Kelompok Rekening',
			'namakelrekening' => 'Nama Kelompok Rekening',
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
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'bukubesar_id' => 'Buku Besar',
			'kewajiban' => 'Kewajiban',
			'investasi' => 'Investasi',
			'piutang' => 'Piutang',
			'persediaan' => 'Persediaan',
			'uangmuka' => 'Uangmuka',
			'bebandibayardimuka' => 'Beban Dibayar Muka',
			'penyusutandanamortisasi' => 'Penyusutan dan Mortisasi',
			'labarugi' => 'Laba Rugi',
			'pendapatannonoperasional' => 'Pendapatan Non Operasional',
			'bebannonoperasional' => 'Beban Non Operasional',
			'ekuitas' => 'Ekuitas',
			'selisihaktivalancarnonkas' => 'Selish Aktiva Lancar Non Kas',
			'kelompokoperasional' => 'Kelompok Operasional',
			'kelompokinvestasi' => 'Kelompok Investasi',
			'kelompokpendanaan' => 'Kelompok Pendanaan',
			'kenaikanpenurunankas' => 'Kenaikan Penurunan Kas',
			'saldoawalperiode' => 'Saldo Awal Periode',
			'saldoakhirperiode' => 'Saldo Akhir Periode',
			'periodeposting_id' => 'Periode Posting',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->laporanaruskas_id)){
			$criteria->addCondition('laporanaruskas_id = '.$this->laporanaruskas_id);
		}
		if(!empty($this->laporanlabarugi_id)){
			$criteria->addCondition('laporanlabarugi_id = '.$this->laporanlabarugi_id);
		}
		if(!empty($this->laporanneraca_id)){
			$criteria->addCondition('laporanneraca_id = '.$this->laporanneraca_id);
		}
		if(!empty($this->laporanaruskasdetail_id)){
			$criteria->addCondition('laporanaruskasdetail_id = '.$this->laporanaruskasdetail_id);
		}
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
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
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('kewajiban',$this->kewajiban);
		$criteria->compare('investasi',$this->investasi);
		$criteria->compare('piutang',$this->piutang);
		$criteria->compare('persediaan',$this->persediaan);
		$criteria->compare('uangmuka',$this->uangmuka);
		$criteria->compare('bebandibayardimuka',$this->bebandibayardimuka);
		$criteria->compare('penyusutandanamortisasi',$this->penyusutandanamortisasi);
		$criteria->compare('labarugi',$this->labarugi);
		$criteria->compare('pendapatannonoperasional',$this->pendapatannonoperasional);
		$criteria->compare('bebannonoperasional',$this->bebannonoperasional);
		$criteria->compare('ekuitas',$this->ekuitas);
		$criteria->compare('selisihaktivalancarnonkas',$this->selisihaktivalancarnonkas);
		$criteria->compare('kelompokoperasional',$this->kelompokoperasional);
		$criteria->compare('kelompokinvestasi',$this->kelompokinvestasi);
		$criteria->compare('kelompokpendanaan',$this->kelompokpendanaan);
		$criteria->compare('kenaikanpenurunankas',$this->kenaikanpenurunankas);
		$criteria->compare('saldoawalperiode',$this->saldoawalperiode);
		$criteria->compare('saldoakhirperiode',$this->saldoakhirperiode);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		
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