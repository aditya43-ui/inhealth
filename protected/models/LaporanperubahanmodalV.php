<?php

/**
 * This is the model class for table "laporanperubahanmodal_v".
 *
 * The followings are the available columns in table 'laporanperubahanmodal_v':
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
 * @property boolean $isclosing_anggaran
 * @property string $digitnilaianggaran
 * @property integer $periodeposting_id
 * @property string $periodeposting_nama
 * @property string $tglperiodeposting_awal
 * @property string $tglperiodeposting_akhir
 * @property string $deskripsiperiodeposting
 * @property integer $laporanperubahanmodal_id
 * @property integer $laporanperubahanmodaldetail_id
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
 * @property double $saldoakhirberjalan
 * @property integer $bukubesar_id
 * @property double $labarugi
 * @property double $ekuitas
 * @property double $prive
 * @property double $modal
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class LaporanperubahanmodalV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanperubahanmodalV the static model class
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
		return 'laporanperubahanmodal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id, konfiganggaran_id, periodeposting_id, laporanperubahanmodal_id, laporanperubahanmodaldetail_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, bukubesar_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, instalasi_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit, saldoakhirberjalan, labarugi, ekuitas, prive, modal', 'numerical'),
			array('deskripsi, deskripsiperiodeposting, nmrekening2', 'length', 'max'=>200),
			array('deskripsiperiode, periodeposting_nama, nmrekening1', 'length', 'max'=>100),
			array('digitnilaianggaran', 'length', 'max'=>10),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('unitkerja_id,perideawal, sampaidgn, isclosing, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, isclosing_anggaran, tglperiodeposting_awal, tglperiodeposting_akhir, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('unitkerja_id,rekperiod_id, perideawal, sampaidgn, deskripsi, isclosing, konfiganggaran_id, deskripsiperiode, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, isclosing_anggaran, digitnilaianggaran, periodeposting_id, periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, deskripsiperiodeposting, laporanperubahanmodal_id, laporanperubahanmodaldetail_id, rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, saldodebit, saldokredit, saldoakhirberjalan, bukubesar_id, labarugi, ekuitas, prive, modal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama', 'safe', 'on'=>'search'),
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
			'konfiganggaran_id' => 'Konfig. Anggaran',
			'deskripsiperiode' => 'Deskripsi Periode',
			'tglanggaran' => 'Tanggal Anggaran',
			'sd_tglanggaran' => 'Sampai Dengan',
			'tglrencanaanggaran' => 'Tanggal Rencana Anggaran',
			'sd_tglrencanaanggaran' => 'Sampai Dengan',
			'tglrevisianggaran' => 'Tanggal Revisi Anggaran',
			'sd_tglrevisianggaran' => 'Sampai Dengan',
			'isclosing_anggaran' => 'Is Closing Anggaran',
			'digitnilaianggaran' => 'Digit Nilai Anggaran',
			'periodeposting_id' => 'Periode Posting',
			'periodeposting_nama' => 'Periode Posting',
			'tglperiodeposting_awal' => 'Tanggal Periode Posting Awal',
			'tglperiodeposting_akhir' => 'Tanggal Periode Posting Akhir',
			'deskripsiperiodeposting' => 'Deskripsi Periode Posting',
			'laporanperubahanmodal_id' => 'Laporan Perubahan Modal',
			'laporanperubahanmodaldetail_id' => 'Laporan Perubahan Modal Detail',
			'rekening1_id' => 'ID Rekening 1',
			'kdrekening1' => 'Kode Rekening 1',
			'nmrekening1' => 'Nama Rekening 1',
			'rekening2_id' => 'ID Rekening 2',
			'kdrekening2' => 'Kode Rekening 2',
			'nmrekening2' => 'Nama Rekening 2',
			'rekening3_id' => 'ID Rekening 3',
			'kdrekening3' => 'Kode Rekening 3',
			'nmrekening3' => 'Nama Rekening 3',
			'rekening4_id' => 'ID Rekening 4',
			'kdrekening4' => 'Kode Rekening 4',
			'nmrekening4' => 'Nama Rekening 4',
			'rekening5_id' => 'ID Rekening 4',
			'kdrekening5' => 'Kode Rekening 4',
			'nmrekening5' => 'Nama Rekening 4',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'saldoakhirberjalan' => 'Saldo Akhir Berjalan',
			'bukubesar_id' => 'Buku Besar',
			'labarugi' => 'Laba Rugi',
			'ekuitas' => 'Ekuitas',
			'prive' => 'Prive',
			'modal' => 'Modal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
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
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
		$criteria->compare('LOWER(digitnilaianggaran)',strtolower($this->digitnilaianggaran),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		if(!empty($this->laporanperubahanmodal_id)){
			$criteria->addCondition('laporanperubahanmodal_id = '.$this->laporanperubahanmodal_id);
		}
		if(!empty($this->laporanperubahanmodaldetail_id)){
			$criteria->addCondition('laporanperubahanmodaldetail_id = '.$this->laporanperubahanmodaldetail_id);
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
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		$criteria->compare('labarugi',$this->labarugi);
		$criteria->compare('ekuitas',$this->ekuitas);
		$criteria->compare('prive',$this->prive);
		$criteria->compare('modal',$this->modal);
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
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

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