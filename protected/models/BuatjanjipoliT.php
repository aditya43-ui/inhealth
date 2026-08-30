<?php

/**
 * This is the model class for table "buatjanjipoli_t".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * The followings are the available columns in table 'buatjanjipoli_t':
 * @property integer $buatjanjipoli_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property string $tglbuatjanji
 * @property string $harijadwal
 * @property string $tgljadwal
 * @property string $slot_jadwal
 * @property boolean $byphone
 * @property string $keteranganbuatjanji
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BuatjanjipoliT extends CActiveRecord
{
        public $nama_pegawai;
        public $ruangan_nama;
        public $nama_pasien;
        public $nama_bin;
        public $no_rekam_medik;
        public $tgl_awal;

		public $slot_jadwal;
        public $tgl_akhir;
        public $jamjadwal;
        public $tglperiksa;
        public $umur;
        public $antrian_id, $alamatemail;
        public $statusperiksa, $is_hadir, $kouta_sakit, $kouta_sehat, $kouta_merr;
        public $no_urutantri, $waktumulai;

        public $waktutindakan;
        public $jadwalpegawai_id,$rv_kecamatan_id,$tempatbekerja_id,$tempatbekerja_nama;
        public $rencanatindakan, $daftartindakan_id;
        public $golongandarah,$tekanandarah,$statuskehamilan,$usia_kehamilan,$riwayatpenyakitterdahulu,$riwayatalergiobat,$riwayatmakanan;
		public $slotantrian;
                /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BuatjanjipoliT the static model class
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
		return 'buatjanjipoli_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, tglbuatjanji, harijadwal, tgljadwal', 'required'),
			array('pegawai_id, ruangan_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('harijadwal', 'length', 'max'=>20),
			array('whatsapp, is_pasiensakit, jenis_pasien,slotantrian, antrian_id, asuransipasienjanjipoli_id, rujukanjanjipoli_id, penanggungjawab_id, norm_poli, keterangan_daftar, jeniskasuspenyakit_id, carabayar_id, penjamin_id, tglperiksa, byphone, nama_pegawai, ruangan_nama, nama_pasien, no_rekam_medik, keteranganbuatjanji, isonsite, bukti_pembayaran, is_aktif, kelaspelayanan_id, total_tarif, trx_id, virtual_account, code_booking, estimasiperiksa, is_checkin, no_kartu_bpjs', 'safe'),   
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
//                      JANGAN GUNAKAN SCRIPT INI DI MODEL KARENA BISA ERROR JIKA DIGUNAKAN DI BRIDGING SISTEM
//                      NILAI DIATUR DI CONTROLLER MASING2
//                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
//                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buatjanjipoli_id, nama_pegawai, ruangan_nama,slotantrian, nama_pasien, no_rekam_medik, pegawai_id, ruangan_id, pasien_id, tglbuatjanji, harijadwal, tgljadwal, byphone, keteranganbuatjanji, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, penjamin_id, isonsite, bukti_pembayaran, is_aktif, kelaspelayanan_id, total_tarif, trx_id, virtual_account, code_booking, estimasiperiksa, is_pasiensakit, jadwaldokter_id, is_checkin, waktucheckin, no_kartu_bpjs', 'safe', 'on'=>'search'),
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
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM','penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'buatjanjipoli_id' => 'ID',
			'pegawai_id' => 'Dokter',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien ID',
			'tglbuatjanji' => 'Tanggal Buat Janji',
			'harijadwal' => 'Hari',
			'slot_jadwal'=> 'Slot',
			'tgljadwal' => 'Tanggal Janji',
			'byphone' => 'By Phone',
			'whatsapp' => 'By Whatsapp',
			'keteranganbuatjanji' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'nama_pasien'=>'Nama Pasien',
            'nama_pegawai'=>'Dokter',
            'no_rekam_medik'=>'No. Rekam Medik',
            'ruangan_nama'=>'Ruangan',
            'tgl_awal'=>'Tanggal Buat Janji',
            'tgl_akhir'=>'Sampai Dengan',
            'NamaNamaBIN' => 'Nama Pasien',
            'CaraBayarPenjamin'=>'Cara Bayar/Penjamin',
			'no_kartu_bpjs'=>'No Peserta BPJS/Asuransi',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('buatjanjipoli_id',$this->buatjanjipoli_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglbuatjanji)',strtolower($this->tglbuatjanji),true);
		$criteria->compare('LOWER(slot_jadwal)',strtolower($this->slot_jadwal),true);
		$criteria->compare('LOWER(harijadwal)',strtolower($this->harijadwal),true);
		$criteria->compare('LOWER(tgljadwal)',strtolower($this->tgljadwal),true);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('LOWER(keteranganbuatjanji)',strtolower($this->keteranganbuatjanji),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
//        3 FUNCTION INI SUDAH TIDAK DIGUNAKAN LAGI DI SEMUA MODEL !!
//        NILAI DEFAULT DI ATUR DI CONTROLLER MASING2
//        
//        protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                     else if ($column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }    
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {         
//            if($this->tglbuatjanji===null || trim($this->tglbuatjanji)==''){
//	        $this->setAttribute('tglbuatjanji', null);
//            }
//            return parent::beforeSave();
//        }
//
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
//        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('instalasi_id='.Params::INSTALASI_ID_RJ.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
        }
        
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = $this->ruangan_id;
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
        public function getNamaNamaBIN()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.'/'.$this->penjamin_nama;
        }
        
 
}