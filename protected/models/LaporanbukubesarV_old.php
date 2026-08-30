<?php

/**
 * This is the model class for table "laporanbukubesar_v".
 *
 * The followings are the available columns in table 'laporanbukubesar_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
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
 * @property integer $bukubesar_id
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $rekening1_nb
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $rekening2_nb
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $rekening3_nb
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $rekening4_nb
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $rekening5_nb
 * @property string $tglbukubesar
 * @property string $no_referensi
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property double $saldoakhirberjalan
 * @property integer $jurnalrekening_id
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property string $tglreferensi
 * @property integer $nobku
 * @property string $urianjurnal
 * @property integer $jurnaldetail_id
 * @property integer $rekeningjurnal1_id
 * @property string $rekeningjurnal1_kode
 * @property string $rekeningjurnal1_nama
 * @property string $rekeningjurnal1_saldonormal
 * @property integer $rekeningjurnal2_id
 * @property string $rekeningjurnal2_kode
 * @property string $rekeningjurnal2_nama
 * @property string $rekeningjurnal2_saldonormal
 * @property integer $rekeningjurnal3_id
 * @property string $rekeningjurnal3_kode
 * @property string $rekeningjurnal3_nama
 * @property string $rekeningjurnal3_saldonormal
 * @property integer $rekeningjurnal4_id
 * @property string $rekeningjurnal4_kode
 * @property string $rekeningjurnal4_nama
 * @property string $rekeningjurnal4_saldonormal
 * @property integer $rekeningjurnal5_id
 * @property string $rekeningjurnal5_kode
 * @property string $rekeningjurnal5_nama
 * @property string $rekeningjurnal5_saldonormal
 * @property string $nourut
 * @property string $uraiantransaksijurnal
 * @property double $saldodebitjurnal
 * @property double $saldokreditjurnal
 * @property boolean $koreksi
 * @property string $catatan
 * @property integer $jurnalposting_id
 * @property string $tgljurnalpost
 * @property string $keterangan
 */
class LaporanbukubesarV_old extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanbukubesarV the static model class
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
			array('instalasi_id, ruangan_id, rekperiod_id, konfiganggaran_id, periodeposting_id, bukubesar_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, jurnalrekening_id, jenisjurnal_id, nobku, jurnaldetail_id, rekeningjurnal1_id, rekeningjurnal2_id, rekeningjurnal3_id, rekeningjurnal4_id, rekeningjurnal5_id, jurnalposting_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit, saldoakhirberjalan, saldodebitjurnal, saldokreditjurnal', 'numerical'),
			array('instalasi_nama, ruangan_nama, nobuktijurnal', 'length', 'max'=>50),
			array('deskripsi, deskripsiperiodeposting, nmrekening2, uraiantransaksi, rekeningjurnal2_nama', 'length', 'max'=>200),
			array('deskripsiperiode, periodeposting_nama, nmrekening1, jenisjurnal_nama, rekeningjurnal1_nama, uraiantransaksijurnal', 'length', 'max'=>100),
			array('digitnilaianggaran, no_referensi', 'length', 'max'=>10),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5, rekeningjurnal1_kode, rekeningjurnal2_kode, rekeningjurnal3_kode, rekeningjurnal4_kode, rekeningjurnal5_kode', 'length', 'max'=>5),
			array('rekening1_nb, rekening2_nb, rekening3_nb, rekening4_nb, rekening5_nb, rekeningjurnal1_saldonormal, rekeningjurnal2_saldonormal, rekeningjurnal3_saldonormal, rekeningjurnal4_saldonormal, rekeningjurnal5_saldonormal', 'length', 'max'=>1),
			array('nmrekening3, rekeningjurnal3_nama', 'length', 'max'=>300),
			array('nmrekening4, rekeningjurnal4_nama', 'length', 'max'=>400),
			array('nmrekening5, rekeningjurnal5_nama', 'length', 'max'=>500),
			array('kodejurnal', 'length', 'max'=>20),
			array('nourut', 'length', 'max'=>3),
			array('perideawal, sampaidgn, isclosing, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, isclosing_anggaran, tglperiodeposting_awal, tglperiodeposting_akhir, tglbukubesar, tglbuktijurnal, noreferensi, tglreferensi, urianjurnal, koreksi, catatan, tgljurnalpost, keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, rekperiod_id, perideawal, sampaidgn, deskripsi, isclosing, konfiganggaran_id, deskripsiperiode, tglanggaran, sd_tglanggaran, tglrencanaanggaran, sd_tglrencanaanggaran, tglrevisianggaran, sd_tglrevisianggaran, digitnilaianggaran, isclosing_anggaran, periodeposting_id, periodeposting_nama, tglperiodeposting_awal, tglperiodeposting_akhir, deskripsiperiodeposting, bukubesar_id, rekening1_id, kdrekening1, nmrekening1, rekening1_nb, rekening2_id, kdrekening2, nmrekening2, rekening2_nb, rekening3_id, kdrekening3, nmrekening3, rekening3_nb, rekening4_id, kdrekening4, nmrekening4, rekening4_nb, rekening5_id, kdrekening5, nmrekening5, rekening5_nb, tglbukubesar, no_referensi, uraiantransaksi, saldodebit, saldokredit, saldoakhirberjalan, jurnalrekening_id, jenisjurnal_id, jenisjurnal_nama, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, tglreferensi, nobku, urianjurnal, jurnaldetail_id, rekeningjurnal1_id, rekeningjurnal1_kode, rekeningjurnal1_nama, rekeningjurnal1_saldonormal, rekeningjurnal2_id, rekeningjurnal2_kode, rekeningjurnal2_nama, rekeningjurnal2_saldonormal, rekeningjurnal3_id, rekeningjurnal3_kode, rekeningjurnal3_nama, rekeningjurnal3_saldonormal, rekeningjurnal4_id, rekeningjurnal4_kode, rekeningjurnal4_nama, rekeningjurnal4_saldonormal, rekeningjurnal5_id, rekeningjurnal5_kode, rekeningjurnal5_nama, rekeningjurnal5_saldonormal, nourut, uraiantransaksijurnal, saldodebitjurnal, saldokreditjurnal, koreksi, catatan, jurnalposting_id, tgljurnalpost, keterangan', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
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
			'digitnilaianggaran' => 'Digit Nilai Anggaran',
			'isclosing_anggaran' => 'Is Closing Anggaran',
			'periodeposting_id' => 'Periode Posting',
			'periodeposting_nama' => 'Periode Posting',
			'tglperiodeposting_awal' => 'Tanggal Periode Posting Awal',
			'tglperiodeposting_akhir' => 'Tangal Periode Posting Akhir',
			'deskripsiperiodeposting' => 'Deskripsi Periode Posting',
			'bukubesar_id' => 'Buku Besar',
			'rekening1_id' => 'Rekening 1',
			'kdrekening1' => 'Kode Rekenig 1',
			'nmrekening1' => 'Nama Rekening 1',
			'rekening1_nb' => 'Rekening 1 NB',
			'rekening2_id' => 'Rekening 2',
			'kdrekening2' => 'Kode Rekening 2',
			'nmrekening2' => 'Nama Rekening 2',
			'rekening2_nb' => 'Rekening 2 NB',
			'rekening3_id' => 'Rekening 3',
			'kdrekening3' => 'Kode Rekening 3',
			'nmrekening3' => 'Nama Rekening 3',
			'rekening3_nb' => 'Rekening 3 NB',
			'rekening4_id' => 'Rekening 4',
			'kdrekening4' => 'Kode Rekening 4',
			'nmrekening4' => 'Nama Rekening 4',
			'rekening4_nb' => 'Rekeing 4 NB',
			'rekening5_id' => 'Rekening 5',
			'kdrekening5' => 'Kode Rekening 5',
			'nmrekening5' => 'Nama Rekening 5',
			'rekening5_nb' => 'Rekening 5 NB',
			'tglbukubesar' => 'Tanggal Buku Besar',
			'no_referensi' => 'No. Referensi',
			'uraiantransaksi' => 'Uraian Transaksi',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'saldoakhirberjalan' => 'Saldo Akhir Berjalan',
			'jurnalrekening_id' => 'Jurnal Rekening',
			'jenisjurnal_id' => 'Jenis Jurnal',
			'jenisjurnal_nama' => 'Jenis Jurnal',
			'tglbuktijurnal' => 'Tanggal Bukti Jurnal',
			'nobuktijurnal' => 'No. Bukti Jurnal',
			'kodejurnal' => 'Kode Jurnal',
			'noreferensi' => 'No. Referensi',
			'tglreferensi' => 'Tanggal Referensi',
			'nobku' => 'No. BKU',
			'urianjurnal' => 'Uraian Jurnal',
			'jurnaldetail_id' => 'Jurnal Detail',
			'rekeningjurnal1_id' => 'Rekening Jurnal 1',
			'rekeningjurnal1_kode' => 'Kode Rekening Jurnal 1',
			'rekeningjurnal1_nama' => 'Nama Rekening Jurnal 1',
			'rekeningjurnal1_saldonormal' => 'Saldo Normal Rekening Jurnal 1',
			'rekeningjurnal2_id' => 'Rekening Jurnal 2',
			'rekeningjurnal2_kode' => 'Kode Rekening Jurnal 2',
			'rekeningjurnal2_nama' => 'Nama Rekening Jurnal 2',
			'rekeningjurnal2_saldonormal' => 'Saldo Normal Rekening Jurnal 2',
			'rekeningjurnal3_id' => 'Rekening Jurnal 3',
			'rekeningjurnal3_kode' => 'Kode Rekening Jurnal 3',
			'rekeningjurnal3_nama' => 'Nama Rekening Jurnal 3',
			'rekeningjurnal3_saldonormal' => 'Saldo Normal Rekening Jurnal 3',
			'rekeningjurnal4_id' => 'Rekening Jurnal 4',
			'rekeningjurnal4_kode' => 'Kode Rekening Jurnal 4',
			'rekeningjurnal4_nama' => 'Nama Rekening Jurnal 4',
			'rekeningjurnal4_saldonormal' => 'Saldo Normal Rekening Jurnal 4',
			'rekeningjurnal5_id' => 'Rekening Jurnal 5',
			'rekeningjurnal5_kode' => 'Kode Rekening Jurnal 5',
			'rekeningjurnal5_nama' => 'Nama Rekening Jurnal 5',
			'rekeningjurnal5_saldonormal' => 'Saldo Normal Rekening Jurnal 5',
			'nourut' => 'No. Urut',
			'uraiantransaksijurnal' => 'Uraian Transaksi Jurnal',
			'saldodebitjurnal' => 'Saldo Debit Jurnal',
			'saldokreditjurnal' => 'Saldo Kredit Jurnal',
			'koreksi' => 'Koreksi',
			'catatan' => 'Catatan',
			'jurnalposting_id' => 'Jurnal Posting',
			'tgljurnalpost' => 'Tanggal Jurnal Posting',
			'keterangan' => 'Keterangan',
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
		if(!empty($this->bukubesar_id)){
			$criteria->addCondition('bukubesar_id = '.$this->bukubesar_id);
		}
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('LOWER(rekening5_nb)',strtolower($this->rekening5_nb),true);
		$criteria->compare('LOWER(tglbukubesar)',strtolower($this->tglbukubesar),true);
		$criteria->compare('LOWER(no_referensi)',strtolower($this->no_referensi),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('saldoakhirberjalan',$this->saldoakhirberjalan);
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition('jurnalrekening_id = '.$this->jurnalrekening_id);
		}
		if(!empty($this->jenisjurnal_id)){
			$criteria->addCondition('jenisjurnal_id = '.$this->jenisjurnal_id);
		}
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		if(!empty($this->nobku)){
			$criteria->addCondition('nobku = '.$this->nobku);
		}
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		if(!empty($this->jurnaldetail_id)){
			$criteria->addCondition('jurnaldetail_id = '.$this->jurnaldetail_id);
		}
		if(!empty($this->rekeningjurnal1_id)){
			$criteria->addCondition('rekeningjurnal1_id = '.$this->rekeningjurnal1_id);
		}
		$criteria->compare('LOWER(rekeningjurnal1_kode)',strtolower($this->rekeningjurnal1_kode),true);
		$criteria->compare('LOWER(rekeningjurnal1_nama)',strtolower($this->rekeningjurnal1_nama),true);
		$criteria->compare('LOWER(rekeningjurnal1_saldonormal)',strtolower($this->rekeningjurnal1_saldonormal),true);
		if(!empty($this->rekeningjurnal2_id)){
			$criteria->addCondition('rekeningjurnal2_id = '.$this->rekeningjurnal2_id);
		}
		$criteria->compare('LOWER(rekeningjurnal2_kode)',strtolower($this->rekeningjurnal2_kode),true);
		$criteria->compare('LOWER(rekeningjurnal2_nama)',strtolower($this->rekeningjurnal2_nama),true);
		$criteria->compare('LOWER(rekeningjurnal2_saldonormal)',strtolower($this->rekeningjurnal2_saldonormal),true);
		if(!empty($this->rekeningjurnal3_id)){
			$criteria->addCondition('rekeningjurnal3_id = '.$this->rekeningjurnal3_id);
		}
		$criteria->compare('LOWER(rekeningjurnal3_kode)',strtolower($this->rekeningjurnal3_kode),true);
		$criteria->compare('LOWER(rekeningjurnal3_nama)',strtolower($this->rekeningjurnal3_nama),true);
		$criteria->compare('LOWER(rekeningjurnal3_saldonormal)',strtolower($this->rekeningjurnal3_saldonormal),true);
		if(!empty($this->rekeningjurnal4_id)){
			$criteria->addCondition('rekeningjurnal4_id = '.$this->rekeningjurnal4_id);
		}
		$criteria->compare('LOWER(rekeningjurnal4_kode)',strtolower($this->rekeningjurnal4_kode),true);
		$criteria->compare('LOWER(rekeningjurnal4_nama)',strtolower($this->rekeningjurnal4_nama),true);
		$criteria->compare('LOWER(rekeningjurnal4_saldonormal)',strtolower($this->rekeningjurnal4_saldonormal),true);
		if(!empty($this->rekeningjurnal5_id)){
			$criteria->addCondition('rekeningjurnal5_id = '.$this->rekeningjurnal5_id);
		}
		$criteria->compare('LOWER(rekeningjurnal5_kode)',strtolower($this->rekeningjurnal5_kode),true);
		$criteria->compare('LOWER(rekeningjurnal5_nama)',strtolower($this->rekeningjurnal5_nama),true);
		$criteria->compare('LOWER(rekeningjurnal5_saldonormal)',strtolower($this->rekeningjurnal5_saldonormal),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksijurnal)',strtolower($this->uraiantransaksijurnal),true);
		$criteria->compare('saldodebitjurnal',$this->saldodebitjurnal);
		$criteria->compare('saldokreditjurnal',$this->saldokreditjurnal);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		if(!empty($this->jurnalposting_id)){
			$criteria->addCondition('jurnalposting_id = '.$this->jurnalposting_id);
		}
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);

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