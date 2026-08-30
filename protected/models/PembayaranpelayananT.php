<?php

/**
 * This is the model class for table "pembayaranpelayanan_t".
 *
 * The followings are the available columns in table 'pembayaranpelayanan_t':
 * @property integer $pembayaranpelayanan_id
 * @property integer $pembebasantarif_id
 * @property integer $suratketjaminan_id
 * @property integer $pasien_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property integer $ruangan_id
 * @property integer $tandabuktibayar_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $nopembayaran
 * @property string $tglpembayaran
 * @property string $noresep
 * @property string $nosjp
 * @property double $totalbiayaoa
 * @property double $totalbiayatindakan
 * @property double $totalbiayapelayanan
 * @property double $totalsubsidiasuransi
 * @property double $totalsubsidipemerintah
 * @property double $totalsubsidirs
 * @property double $totaliurbiaya
 * @property double $totalbayartindakan
 * @property double $totaldiscount
 * @property double $totalpembebasan
 * @property double $totalsisatagihan
 * @property integer $ruanganpelakhir_id
 * @property string $statusbayar
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PembayaranpelayananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranpelayananT the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pembayaranpelayanan_t';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, carabayar_id, penjamin_id, ruangan_id, nopembayaran, tglpembayaran, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, ruanganpelakhir_id, statusbayar', 'required'),
			array('pembebasantarif_id, suratketjaminan_id, pasien_id, carabayar_id, penjamin_id, ruangan_id, tandabuktibayar_id, pendaftaran_id, pasienadmisi_id, ruanganpelakhir_id', 'numerical', 'integerOnly' => true),
			array('selisihuntungrugibpjs, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, jasapelayanan_farmasi', 'numerical'),
			array('nopembayaran, noresep, nosjp', 'length', 'max' => 50),
			array('statusbayar', 'length', 'max' => 30),
			array('keterangan, update_time, update_loginpemakai_id', 'safe'),
			array('total_inacbg, alokasidana_id', 'safe'),
			array('nominal_cicilan, alamat, pekerjaan_id, hubungankeluarga, update_time, update_loginpemakai_id, keteranganberhutang, tgljatuhtempo, penanggungjawabhutang, noktp_hutang, notelp_hutang, jaminanygditinggal', 'safe'),
			array('nama_penanggungjawab, alamatktp_penanggungjawab, umur_penanggungjawab, pekerjaan_penanggungjawab, notelp_penanggungjawab, nomobile_penanggungjawab, 
			tglmrs_krs, tempat_layanan, tanggal_akad, jangka_waktu, catatan, jumlah_total, jumlah_bayarhutang, jumlah_sisahutang', 'safe'),
			array('create_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('update_time', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => false, 'on' => 'update,insert'),
			array('create_loginpemakai_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'insert'),
			array('update_loginpemakai_id', 'default', 'value' => Yii::app()->user->id, 'on' => 'update,insert'),
			array('create_ruangan', 'default', 'value' => Yii::app()->user->getState('ruangan_id'), 'on' => 'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgljatuhtempo, pembayaranpelayanan_id, pembebasantarif_id, pembklaimdetal_id, suratketjaminan_id, pasien_id, carabayar_id, penjamin_id, ruangan_id, tandabuktibayar_id, pendaftaran_id, pasienadmisi_id, nopembayaran, tglpembayaran, noresep, nosjp, totalbiayaoa, totalbiayatindakan, totalbiayapelayanan, totalsubsidiasuransi, totalsubsidipemerintah, totalsubsidirs, totaliurbiaya, totalbayartindakan, totaldiscount, totalpembebasan, totalsisatagihan, ruanganpelakhir_id, statusbayar, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jasapelayanan_farmasi', 'safe', 'on' => 'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ruanganpelakhir' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpelakhir_id'),
			'tandabukti' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'detailklaim' => array(self::BELONGS_TO, 'PembklaimdetalT', 'pembklaimdetal_id'),
			'tandabuktibayar' => array(self::BELONGS_TO, 'TandabuktibayarT', 'tandabuktibayar_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'no_rekem_medik' => 'No. Rekem Medik',
			'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
			'pembebasantarif_id' => 'Pembebasan Tarif',
			'suratketjaminan_id' => 'Surat Keterangan Jaminan',
			'pembklaimdetal_id' => 'Detail Pembayaran Klaim',
			'pasien_id' => 'Pasien',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'ruangan_id' => 'Nama Ruangan',
			'tandabuktibayar_id' => 'Tanda Bukti Bayar',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasien Admisi',
			'nopembayaran' => 'No. Pembayaran',
			'tglpembayaran' => 'Tanggal Pembayaran',
			'noresep' => 'No. Resep',
			'nosjp' => 'No. SJP',
			'totalbiayaoa' => 'Total Biaya OA',
			'totalbiayatindakan' => 'Total Biaya Tindakan',
			'totalbiayapelayanan' => 'Total Biaya Pelayanan',
			'totalsubsidiasuransi' => 'Total Tanggungan Asuransi',
			'totalsubsidipemerintah' => 'Total Tanggungan Pemerintah',
			'totalsubsidirs' => 'Total Tanggungan Rumah Sakit',
			'totaliurbiaya' => 'Tanggungan Pasien', //Tanggungan Pasien = Iur Biaya
			'totalbayartindakan' => 'Total Bayar Tindakan',
			'totaldiscount' => 'Total Keringanan',
			'totalpembebasan' => 'Total Pembebasan',
			'totalsisatagihan' => 'Total Sisa Tagihan',
			'ruanganpelakhir_id' => 'Ruangan Pelayanan Akhir',
			'statusbayar' => 'Status Bayar',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'nama_bin' => 'Nama Panggilan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'no_pendaftaran' => 'No. Pendaftaran',
			'selisihuntungrugibpjs' => 'Selisih Untuk/Rugi BPJS',
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
		$criteria = new CDbCriteria;
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		$criteria->compare('pembebasantarif_id', $this->pembebasantarif_id);
		$criteria->compare('suratketjaminan_id', $this->suratketjaminan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('tandabuktibayar_id', $this->tandabuktibayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)', strtolower($this->nopembayaran), true);
		$criteria->compare('LOWER(tglpembayaran)', strtolower($this->tglpembayaran), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('LOWER(nosjp)', strtolower($this->nosjp), true);
		$criteria->compare('totalbiayaoa', $this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan', $this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan', $this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi', $this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah', $this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs', $this->totalsubsidirs);
		$criteria->compare('totaliurbiaya', $this->totaliurbiaya);
		$criteria->compare('totalbayartindakan', $this->totalbayartindakan);
		$criteria->compare('totaldiscount', $this->totaldiscount);
		$criteria->compare('totalpembebasan', $this->totalpembebasan);
		$criteria->compare('totalsisatagihan', $this->totalsisatagihan);
		$criteria->compare('ruanganpelakhir_id', $this->ruanganpelakhir_id);
		$criteria->compare('pembklaimdetal_id', $this->pembklaimdetal_id);
		$criteria->compare('LOWER(statusbayar)', strtolower($this->statusbayar), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->order = 'tglpembayaran DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		$criteria->compare('pembebasantarif_id', $this->pembebasantarif_id);
		$criteria->compare('suratketjaminan_id', $this->suratketjaminan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('tandabuktibayar_id', $this->tandabuktibayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)', strtolower($this->nopembayaran), true);
		$criteria->compare('LOWER(tglpembayaran)', strtolower($this->tglpembayaran), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('LOWER(nosjp)', strtolower($this->nosjp), true);
		$criteria->compare('totalbiayaoa', $this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan', $this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan', $this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi', $this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah', $this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs', $this->totalsubsidirs);
		$criteria->compare('totaliurbiaya', $this->totaliurbiaya);
		$criteria->compare('totalbayartindakan', $this->totalbayartindakan);
		$criteria->compare('totaldiscount', $this->totaldiscount);
		$criteria->compare('totalpembebasan', $this->totalpembebasan);
		$criteria->compare('totalsisatagihan', $this->totalsisatagihan);
		$criteria->compare('ruanganpelakhir_id', $this->ruanganpelakhir_id);
		$criteria->compare('pembklaimdetal_id', $this->pembklaimdetal_id);
		$criteria->compare('LOWER(statusbayar)', strtolower($this->statusbayar), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->order = 'tglpembayaran DESC';
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	protected function beforeValidate()
	{
		// convert to storage format
		//$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
		$format = new MyFormatter();
		//$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
		foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
			if ($column->dbType == 'date') {
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			} elseif ($column->dbType == 'timestamp without time zone') {
				//$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			}
		}
		return parent::beforeValidate();
	}
	//        RND-6992 Format date langsung diedit di view nya.        
	//        protected function afterFind()
	//        {
	//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
	//
	//                if (!strlen($this->$columnName)) continue;
	//
	//                if ($column->dbType == 'date'){                         
	//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
	//                        }elseif ($column->dbType == 'timestamp without time zone'){
	//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
	//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
	//                        }
	//            }
	//            return true;
	//        }
	public function searchPembayaranKlaim()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		$criteria->compare('pembebasantarif_id', $this->pembebasantarif_id);
		$criteria->compare('suratketjaminan_id', $this->suratketjaminan_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('tandabuktibayar_id', $this->tandabuktibayar_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('LOWER(nopembayaran)', strtolower($this->nopembayaran), true);
		$criteria->compare('LOWER(tglpembayaran)', strtolower($this->tglpembayaran), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('LOWER(nosjp)', strtolower($this->nosjp), true);
		$criteria->compare('totalbiayaoa', $this->totalbiayaoa);
		$criteria->compare('totalbiayatindakan', $this->totalbiayatindakan);
		$criteria->compare('totalbiayapelayanan', $this->totalbiayapelayanan);
		$criteria->compare('totalsubsidiasuransi', $this->totalsubsidiasuransi);
		$criteria->compare('totalsubsidipemerintah', $this->totalsubsidipemerintah);
		$criteria->compare('totalsubsidirs', $this->totalsubsidirs);
		$criteria->compare('totaliurbiaya', $this->totaliurbiaya);
		$criteria->compare('totalbayartindakan', $this->totalbayartindakan);
		$criteria->compare('totaldiscount', $this->totaldiscount);
		$criteria->compare('totalpembebasan', $this->totalpembebasan);
		$criteria->compare('totalsisatagihan', $this->totalsisatagihan);
		$criteria->compare('ruanganpelakhir_id', $this->ruanganpelakhir_id);
		$criteria->compare('pembklaimdetal_id', $this->pembklaimdetal_id);
		$criteria->compare('LOWER(statusbayar)', strtolower($this->statusbayar), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->order = 'tglpembayaran DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}
