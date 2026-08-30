<?php

/**
 * This is the model class for table "saldorekening_v".
 *
 * The followings are the available columns in table 'saldorekening_v':
 * @property integer $saldoawal_id
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property integer $kursrp_id
 * @property double $nilai
 * @property integer $matauang_id
 * @property string $matauang
 * @property integer $periodeposting_id
 * @property string $periodeposting_nama
 * @property string $tglperiodeposting_awal
 * @property string $tglperiodeposting_akhir
 * @property string $deskripsiperiodeposting
 * @property integer $struktur_id
 * @property string $kdstruktur
 * @property string $nmstruktur
 * @property string $nmstrukturlain
 * @property string $struktur_nb
 * @property boolean $struktur_aktif
 * @property integer $kelompok_id
 * @property string $kdkelompok
 * @property string $nmkelompok
 * @property string $nmkelompoklain
 * @property string $kelompok_nb
 * @property boolean $kelompok_aktif
 * @property integer $jenis_id
 * @property string $kdjenis
 * @property string $nmjenis
 * @property string $nmjenislain
 * @property string $jenis_nb
 * @property boolean $jenis_aktif
 * @property integer $obyek_id
 * @property string $kdobyek
 * @property string $nmobyek
 * @property string $nmobyeklain
 * @property string $obyek_nb
 * @property boolean $obyek_aktif
 * @property integer $rincianobyek_id
 * @property string $kdrincianobyek
 * @property string $nmrincianobyek
 * @property string $nmrincianobyeklain
 * @property string $rincianobyek_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rincianobyek_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property double $jmlanggaran
 * @property double $jmlsaldoawald
 * @property double $jmlsaldoawalk
 * @property double $jmlmutasid
 * @property double $jmlmutasik
 * @property double $jmlsaldoakhird
 * @property double $jmlsaldoakhirk
 */
class SaldorekeningV extends CActiveRecord
{
	public $tiperekening_id;
	public $rekperiod_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SaldorekeningV the static model class
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
		return 'saldorekening_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('saldoawal_id, rekperiod_id, kursrp_id, matauang_id, periodeposting_id, struktur_id, kelompok_id, jenis_id, obyek_id, rincianobyek_id, nourutrek', 'numerical', 'integerOnly'=>true),
			array('nilai, jmlanggaran, jmlsaldoawald, jmlsaldoawalk, jmlmutasid, jmlmutasik, jmlsaldoakhird, jmlsaldoakhirk', 'numerical'),
			array('matauang', 'length', 'max'=>50),
			array('periodeposting_nama, nmstruktur, nmstrukturlain', 'length', 'max'=>100),
			array('deskripsiperiodeposting, nmkelompok, nmkelompoklain', 'length', 'max'=>200),
			array('kdstruktur, kdkelompok, kdjenis, kdobyek, kdrincianobyek', 'length', 'max'=>5),
			array('struktur_nb, kelompok_nb, jenis_nb, obyek_nb, rincianobyek_nb', 'length', 'max'=>1),
			array('nmjenis, nmjenislain', 'length', 'max'=>300),
			array('nmobyek, nmobyeklain', 'length', 'max'=>400),
			array('nmrincianobyek, nmrincianobyeklain', 'length', 'max'=>500),
			array('kelompokrek', 'length', 'max'=>20),
			array('perideawal, sampaidgn, tglperiodeposting_awal, tglperiodeposting_akhir, struktur_aktif, kelompok_aktif, jenis_aktif, obyek_aktif, keterangan, rincianobyek_aktif, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('saldoawal_id, rekperiod_id, perideawal, sampaidgn, kursrp_id, nilai, matauang_id, matauang, periodeposting_id, periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, deskripsiperiodeposting, struktur_id, kdstruktur, nmstruktur, nmstrukturlain, struktur_nb, struktur_aktif, kelompok_id, kdkelompok, nmkelompok, nmkelompoklain, kelompok_nb, kelompok_aktif, jenis_id, kdjenis, nmjenis, nmjenislain, jenis_nb, jenis_aktif, obyek_id, kdobyek, nmobyek, nmobyeklain, obyek_nb, obyek_aktif, rincianobyek_id, kdrincianobyek, nmrincianobyek, nmrincianobyeklain, rincianobyek_nb, keterangan, nourutrek, rincianobyek_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jmlanggaran, jmlsaldoawald, jmlsaldoawalk, jmlmutasid, jmlmutasik, jmlsaldoakhird, jmlsaldoakhirk', 'safe', 'on'=>'search'),
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
			'saldoawal_id' => 'ID Saldo Awal',
			'rekperiod_id' => 'Rekening Periode',
			'perideawal' => 'Periode Awal',
			'sampaidgn' => 'Sampai Dengan',
			'kursrp_id' => 'Kurs Rp',
			'nilai' => 'Nilai',
			'matauang_id' => 'Mata Uang',
			'matauang' => 'Mata Uang',
			'periodeposting_id' => 'ID Periode Posting',
			'periodeposting_nama' => 'Periode Posting',
			'tglperiodeposting_awal' => 'Tgl. Awal Periode Posting',
			'tglperiodeposting_akhir' => 'Tgl. Akhir Periode Posting',
			'deskripsiperiodeposting' => 'Deskripsi Periode',
			'struktur_id' => 'Struktur',
			'kdstruktur' => 'Kode Struktur',
			'nmstruktur' => 'Nama Struktur',
			'nmstrukturlain' => 'Nama Struktur Lain',
			'struktur_nb' => 'Struktur Nb',
			'struktur_aktif' => 'Struktur Aktif',
			'kelompok_id' => 'Kelompok',
			'kdkelompok' => 'Kode Kelompok',
			'nmkelompok' => 'Nama Kelompok',
			'nmkelompoklain' => 'Nama Kelompok Lain',
			'kelompok_nb' => 'Kelompok Nb',
			'kelompok_aktif' => 'Kelompok Aktif',
			'jenis_id' => 'ID Jenis',
			'kdjenis' => 'Kode Jenis',
			'nmjenis' => 'Nama Jenis',
			'nmjenislain' => 'Nama Jenis Lain',
			'jenis_nb' => 'Jenis Nb',
			'jenis_aktif' => 'Jenis Aktif',
			'obyek_id' => 'ID Obyek',
			'kdobyek' => 'Kode Obyek',
			'nmobyek' => 'Nama Obyek',
			'nmobyeklain' => 'Nama Obyek Lain',
			'obyek_nb' => 'Obyek Nb',
			'obyek_aktif' => 'Obyek Aktif',
			'rincianobyek_id' => 'Rincian Obyek',
			'kdrincianobyek' => 'Kode Rincian Obyek',
			'nmrincianobyek' => 'Nama Rincian Obyek',
			'nmrincianobyeklain' => 'Nama Rincian Obyek Lain',
			'rincianobyek_nb' => 'Rincian Obyek Nb',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'No. Urut Rek.',
			'rincianobyek_aktif' => 'Rincian Obyek Aktif',
			'kelompokrek' => 'Kelompok Rek.',
			'sak' => 'Sak',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'jmlanggaran' => 'Jumlah Anggaran',
			'jmlsaldoawald' => 'Saldo Awal (Debit)',
			'jmlsaldoawalk' => 'Saldo Awal (Kredit)',
			'jmlmutasid' => 'Mutasi (Debit)',
			'jmlmutasik' => 'Mutasi (Kredit)',
			'jmlsaldoakhird' => 'Saldo Akhir (Debit)',
			'jmlsaldoakhirk' => 'Saldo Akhir (Kredit)',
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

		if(!empty($this->saldoawal_id)){
			$criteria->addCondition('saldoawal_id = '.$this->saldoawal_id);
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		if(!empty($this->kursrp_id)){
			$criteria->addCondition('kursrp_id = '.$this->kursrp_id);
		}
		$criteria->compare('nilai',$this->nilai);
		if(!empty($this->matauang_id)){
			$criteria->addCondition('matauang_id = '.$this->matauang_id);
		}
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		if(!empty($this->periodeposting_id)){
			$criteria->addCondition('periodeposting_id = '.$this->periodeposting_id);
		}
		$criteria->compare('LOWER(periodeposting_nama)',strtolower($this->periodeposting_nama),true);
		$criteria->compare('LOWER(tglperiodeposting_awal)',strtolower($this->tglperiodeposting_awal),true);
		$criteria->compare('LOWER(tglperiodeposting_akhir)',strtolower($this->tglperiodeposting_akhir),true);
		$criteria->compare('LOWER(deskripsiperiodeposting)',strtolower($this->deskripsiperiodeposting),true);
		if(!empty($this->struktur_id)){
			$criteria->addCondition('struktur_id = '.$this->struktur_id);
		}
		$criteria->compare('LOWER(kdstruktur)',strtolower($this->kdstruktur),true);
		$criteria->compare('LOWER(nmstruktur)',strtolower($this->nmstruktur),true);
		$criteria->compare('LOWER(nmstrukturlain)',strtolower($this->nmstrukturlain),true);
		$criteria->compare('LOWER(struktur_nb)',strtolower($this->struktur_nb),true);
		$criteria->compare('struktur_aktif',$this->struktur_aktif);
		if(!empty($this->kelompok_id)){
			$criteria->addCondition('kelompok_id = '.$this->kelompok_id);
		}
		$criteria->compare('LOWER(kdkelompok)',strtolower($this->kdkelompok),true);
		$criteria->compare('LOWER(nmkelompok)',strtolower($this->nmkelompok),true);
		$criteria->compare('LOWER(nmkelompoklain)',strtolower($this->nmkelompoklain),true);
		$criteria->compare('LOWER(kelompok_nb)',strtolower($this->kelompok_nb),true);
		$criteria->compare('kelompok_aktif',$this->kelompok_aktif);
		if(!empty($this->jenis_id)){
			$criteria->addCondition('jenis_id = '.$this->jenis_id);
		}
		$criteria->compare('LOWER(kdjenis)',strtolower($this->kdjenis),true);
		$criteria->compare('LOWER(nmjenis)',strtolower($this->nmjenis),true);
		$criteria->compare('LOWER(nmjenislain)',strtolower($this->nmjenislain),true);
		$criteria->compare('LOWER(jenis_nb)',strtolower($this->jenis_nb),true);
		$criteria->compare('jenis_aktif',$this->jenis_aktif);
		if(!empty($this->obyek_id)){
			$criteria->addCondition('obyek_id = '.$this->obyek_id);
		}
		$criteria->compare('LOWER(kdobyek)',strtolower($this->kdobyek),true);
		$criteria->compare('LOWER(nmobyek)',strtolower($this->nmobyek),true);
		$criteria->compare('LOWER(nmobyeklain)',strtolower($this->nmobyeklain),true);
		$criteria->compare('LOWER(obyek_nb)',strtolower($this->obyek_nb),true);
		$criteria->compare('obyek_aktif',$this->obyek_aktif);
		if(!empty($this->rincianobyek_id)){
			$criteria->addCondition('rincianobyek_id = '.$this->rincianobyek_id);
		}
		$criteria->compare('LOWER(kdrincianobyek)',strtolower($this->kdrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyek)',strtolower($this->nmrincianobyek),true);
		$criteria->compare('LOWER(nmrincianobyeklain)',strtolower($this->nmrincianobyeklain),true);
		$criteria->compare('LOWER(rincianobyek_nb)',strtolower($this->rincianobyek_nb),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->nourutrek)){
			$criteria->addCondition('nourutrek = '.$this->nourutrek);
		}
		$criteria->compare('rincianobyek_aktif',$this->rincianobyek_aktif);
		$criteria->compare('LOWER(kelompokrek)',strtolower($this->kelompokrek),true);
		$criteria->compare('sak',$this->sak);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('jmlanggaran',$this->jmlanggaran);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);
		$criteria->compare('jmlmutasid',$this->jmlmutasid);
		$criteria->compare('jmlmutasik',$this->jmlmutasik);
		$criteria->compare('jmlsaldoakhird',$this->jmlsaldoakhird);
		$criteria->compare('jmlsaldoakhirk',$this->jmlsaldoakhirk);

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