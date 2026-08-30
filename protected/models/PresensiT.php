<?php

/**
 * This is the model class for table "presensi_t".
 *
 * The followings are the available columns in table 'presensi_t':
 * @property integer $presensi_id
 * @property integer $statuskehadiran_id
 * @property integer $pegawai_id
 * @property integer $statusscan_id
 * @property string $tglpresensi
 * @property string $no_fingerprint
 * @property boolean $verifikasi
 * @property string $keterangan
 * @property string $jamkerjamasuk
 * @property string $jamkerjapulang
 * @property integer $terlambat_mnt
 * @property integer $pulangawal_mnt
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PresensiT extends CActiveRecord
{
        public $tglpresensi_akhir;
        public $nama_pegawai, $nomorindukpegawai;
        public $tgl_awal, $tgl_akhir, $kategoripegawai;
        public $tick;
        public $data;
        public $jumlah;
        public $user_id;
        public $jam;         
		public $jenistenagamedis_id;
		public $kategoripegawaiasal;
		public $kelompokjabatan;
		public $tgl_jammasuk;
		public $tgl_jampulang;
		public $tgl_jamdatang;
		public $tgl_jamkeluar;
		public $jamscanmasuk;
		public $jamscanpulang;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PresensiT the static model class
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
		return 'presensi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statuskehadiran_id, pegawai_id, tglpresensi, no_fingerprint', 'required'),
			array('statuskehadiran_id, pegawai_id, statusscan_id, terlambat_mnt, pulangawal_mnt', 'numerical', 'integerOnly'=>true),
			array('no_fingerprint', 'length', 'max'=>30),                        
			array('shift_id, verifikasi, keterangan, update_time, tgl_awal, tgl_akhir, tglpresensi, update_loginpemakai_id', 'safe'),                        
			array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('bukti_file, shift_id, jamscanmasuk, jamscanpulang','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tglpresensi_akhir, nama_pegawai, tgl_awal, tgl_akhir, nomorindukpegawai, kategoripegawai, presensi_id, statuskehadiran_id, pegawai_id, statusscan_id, tglpresensi, no_fingerprint, verifikasi, keterangan, jamkerjamasuk, jamkerjapulang, terlambat_mnt, pulangawal_mnt, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'statuskehadiran'=>array(self::BELONGS_TO, 'StatuskehadiranM', 'statuskehadiran_id'),
					'statuskehadiranpresensi'=>array(self::BELONGS_TO, 'StatuskehadiranM', 'statuskehadiran_id'),			
                    'statusscan'=>array(self::BELONGS_TO, 'StatusscanM', 'statusscan_id'),
					'statusscanpresensi'=>array(self::BELONGS_TO, 'StatusscanM', 'statusscan_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
					'shift'=>array(self::BELONGS_TO, 'ShiftM', 'shift_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'presensi_id' => 'Presensi',
			'statuskehadiran_id' => 'Status Kehadiran',
			'pegawai_id' => 'Pegawai',
			'statusscan_id' => 'Status Scan',
			'tglpresensi' => 'Tanggal Presensi',
			'no_fingerprint' => 'No Finger Print',
			'verifikasi' => 'Verifikasi',
			'keterangan' => 'Keterangan',
			'jamkerjamasuk' => 'Jam Kerja Masuk',
			'jamkerjapulang' => 'Jam Kerja Pulang',
			'terlambat_mnt' => 'Terlambat Menit',
			'pulangawal_mnt' => 'Pulang Awal Menit',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglpresensi_akhir'=>'Sampai Dengan',
			'nomorindukpegawai'=>'NIP',
			'kategoripegawai'=>'Kategori Pegawai',
			'nama_pegawai'=>'Nama Pegawai',
			'jenistenagamedis_id' => 'Jenis Tenaga Medis',
			'kategoripegawaiasal' => 'Kategori Pegawai Asal',
			'kelompokjabatan' => 'Kelompok Jabatan',
			'jamscanmasuk' => 'Jam Scan Masuk',
			'jamscanpulang' => 'Jam Scan Pulang'
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

		$criteria->compare('presensi_id',$this->presensi_id);
		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
		$criteria->compare('LOWER(no_fingerprint)',strtolower($this->no_fingerprint),true);
		$criteria->compare('verifikasi',$this->verifikasi);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('jamkerjamasuk',$this->jamkerjamasuk);
		$criteria->compare('jamkerjapulang',$this->jamkerjapulang);
		$criteria->compare('terlambat_mnt',$this->terlambat_mnt);
		$criteria->compare('pulangawal_mnt',$this->pulangawal_mnt);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(pegawai.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
                $criteria->compare('kategoripegawai',$this->kategoripegawai,true);
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
//        
        
        public function searchPresensi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('pegawai');
		$criteria->compare('presensi_id',$this->presensi_id);
		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
                $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
		$criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
		$criteria->compare('no_fingerprint',$this->no_fingerprint,true);
		$criteria->compare('verifikasi',$this->verifikasi);
		$criteria->compare('keterangan',$this->keterangan,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchDetailAbsen()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->compare('statusscan_id',$this->statusscan_id);
            $criteria->compare('pegawai_id',$this->pegawai_id);
            $criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir);
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	}        
        
          public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('pegawai');
		$criteria->compare('presensi_id',$this->presensi_id);
		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
                $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
//		$criteria->addBetweenCondition('tglpresensi',$this->tglpresensi, $this->tglpresensi_akhir);
		$criteria->compare('no_fingerprint',$this->no_fingerprint,true);
		$criteria->compare('verifikasi',$this->verifikasi);
		$criteria->compare('keterangan',$this->keterangan,true);
                $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
         public function searchPresensiGrafik()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->select = 'count(pegawai_id) as jumlah, no_fingerprint as data';
                $criteria->group = 'no_fingerprint';
                $criteria->addBetweenCondition('tglpresensi', $this->tglpresensi, $this->tglpresensi_akhir);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('statusscan_id',$this->statusscan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
                $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('statuskehadiran_id',$this->statuskehadiran_id);
//		$criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi, $this->tglpresensi_akhir,true);
		$criteria->compare('no_fingerprint',$this->no_fingerprint,true);
		$criteria->compare('verifikasi',$this->verifikasi);
		$criteria->compare('keterangan',$this->keterangan,true);
               
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglpresensi===null || trim($this->tglpresensi)==''){
	        $this->setAttribute('tglpresensi', null);
            }
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;
                /*
                if (in_array($column->dbType, array('date', 'timestamp without time zone'))) {                         
                        $this->$columnName = MyFormatter::formatDateTimeForUser($this->$columnName);
                } */
            }
            return true;
        }
        
      public function criteriaLaporanpresensi()
            {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

                $criteria=new CDbCriteria;
                
//              $criteria->with = array('pegawai');
                $criteria->select = 't.pegawai_id, t.no_fingerprint';
                $criteria->group = ' t.pegawai_id, t.no_fingerprint';
                $criteria->join = 'INNER JOIN pegawai_m ON pegawai_m.pegawai_id=t.pegawai_id';
                $criteria->addBetweenCondition('DATE(tglpresensi)',$this->tglpresensi,$this->tglpresensi_akhir);
                $criteria->compare('LOWER(pegawai_m.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('pegawai_m.kategoripegawai',$this->kategoripegawai);
                return $criteria;
            }
        
	public function searchLaporanpresensi()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporanpresensi(),
		));
	}
        
	public function searchLaporanpresensiprint()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaLaporanpresensi(),
                                                'pagination'=>false,
		));
	}
        
        public function getJam($scan, $tanggal, $pegawai_id)
        {
            $format = new MyFormatter();
            $tgl = $format->formatDateTimeForDb(date('Y-m-d'), strtotime($tanggal));
            
            $get = $this->find(" statusscan_id = '$scan' AND tglpresensi::text iLike '$tanggal%' AND pegawai_id = '$pegawai_id' ");
            
            if (count((array)$get)>0){
                if ($scan == Params::STATUSSCAN_MASUK)
                {
                    return $get->jamkerjamasuk;
                }elseif ($scan == Params::STATUSSCAN_PULANG){
                    return $get->jamkerjapulang;
                }else{
                    return '';
                }
            }else{
                return '';
            }
        }
		
		public function getRealJam($scan, $tanggal, $pegawai_id)
        {
            $format = new MyFormatter();
            $tgl = $format->formatDateTimeForDb(date('Y-m-d'), strtotime($tanggal));
            
            $get = $this->find(" statusscan_id = '$scan' AND tglpresensi::text iLike '$tanggal%' AND pegawai_id = '$pegawai_id' ");
            
            if (count((array)$get)>0){
                if ($scan == Params::STATUSSCAN_MASUK)
                {
                    return date('H:i:s', strtotime($get->tglpresensi));
                }elseif ($scan == Params::STATUSSCAN_PULANG){
                    return date('H:i:s', strtotime($get->tglpresensi));
                }else{
                    return '';
                }
            }else{
                return '';
            }
        }
        
        public function getWarnaKehadiran($status_kehadiran){
            if (strtolower($status_kehadiran) == strtolower(Params::STATUSKEHADIRAN_NAMA_HADIR)){
                return "<button class = 'nohover btn' style = 'width:70px;background:#11ba01;border:1px solid #11ba01;'>".$status_kehadiran."</button>";                
            }elseif (strtolower($status_kehadiran) == strtolower(Params::STATUSKEHADIRAN_NAMA_ALPHA)){
                return "<button class = 'nohover btn' style = 'width:70px;background:#c90202;border:1px solid #c90202;'>".$status_kehadiran."</button>";
            }elseif (strtolower($status_kehadiran) == strtolower(Params::STATUSKEHADIRAN_NAMA_SAKIT)){
                return "<button class = 'nohover btn' style = 'width:70px;background:#777271;border:1px solid #777271;'>".$status_kehadiran."</button>";
            }elseif (strtolower($status_kehadiran) == strtolower(Params::STATUSKEHADIRAN_NAMA_IZIN)){
                return "<button class = 'nohover btn' style = 'width:70px;background:#0303a5;border:1px solid #0303a5;'>".$status_kehadiran."</button>";
            }elseif (strtolower($status_kehadiran) == strtolower(Params::STATUSKEHADIRAN_NAMA_DINAS)){
                return "<button class = 'nohover btn btn-primary' style = 'width:70px;'>".$status_kehadiran."</button>";
            }
        }
        
}