<?php

/**
 * This is the model class for table "hasilpemeriksaanrad_t".
 *
 * The followings are the available columns in table 'hasilpemeriksaanrad_t':
 * @property integer $hasilpemeriksaanrad_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property string $tglpemeriksaanrad
 * @property string $hasilexpertise
 * @property string $kesan_hasilrad
 * @property string $kesimpulan_hasilrad
 * @property string $tglpegambilanhasilrad
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class HasilpemeriksaanradT extends CActiveRecord
{
	public $refhasildet_id, $is_sendiri; 
	public $hasperiksaraddet_id, $dokter_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilpemeriksaanradT the static model class
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
		return 'hasilpemeriksaanrad_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasienmasukpenunjang_id, pasien_id, tglpemeriksaanrad, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('pasienadmisi_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id, pemeriksaanrad_id', 'numerical', 'integerOnly'=>true),
            array('statusperiksahasil, hasil_radiologi', 'length', 'max'=>20),
            array('respondtime', 'length', 'max'=>50),
            array('hasilexpertise, kesan_hasilrad, kesimpulan_hasilrad, tglpegambilanhasilrad, printhasilrad, update_time, update_loginpemakai_id, dokterpj_luarrs, tglpengambilanhasil, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat', 'safe'),
                    
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilpemeriksaanrad_id, pasienadmisi_id, pendaftaran_id, pasienmasukpenunjang_id, tindakanpelayanan_id, pasien_id, pemeriksaanrad_id, tglpemeriksaanrad, hasilexpertise, kesan_hasilrad, kesimpulan_hasilrad, tglpegambilanhasilrad, printhasilrad, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, dokterpj_luarrs, statusperiksahasil, tglpengambilanhasil, namapenerimahasil, notelppenerimahasil, namaygmenyerahkan, ketpenyerahan, jenisidentitas, no_identitas, alamat, respondtime, hasil_radiologi', 'safe', 'on'=>'search'),
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
					'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
					'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
					'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
					'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
					'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
					'hasildet' => array(self::BELONGS_TO, 'HasilperiksaraddetT', 'hasilpemeriksaanrad_id'),
					'tindakanpelayananTs' => array(self::HAS_MANY, 'TindakanpelayananT', 'hasilpemeriksaanrad_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'hasilpemeriksaanrad_id' => 'Hasilpemeriksaanrad',
			'pemeriksaanrad_id' => 'Pemeriksaan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasien_id' => 'Pasien',
			'tglpemeriksaanrad' => 'Tanggal Pemeriksaan',
			'hasilexpertise' => 'Hasil Expertise',
			'kesan_hasilrad' => 'Kesan',
			'kesimpulan_hasilrad' => 'Kesimpulan',
			'tglpegambilanhasilrad' => 'Tanggal Pengambilan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'statusperiksahasil' => 'Status Hasil',
                        'tglpengambilanhasil' => 'Tgl. Penyerahan Hasil',
                        'namapenerimahasil' => 'Nama Pengambil Hasil',
                        'notelppenerimahasil' => 'No. Telp Pengambil Hasil',
                        'namaygmenyerahkan' => 'Nama yg menyerahkan',
                        'ketpenyerahan' => 'Keterangan Pengambilan',
                        'alamat' => 'Alamat'
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

		$criteria->compare('hasilpemeriksaanrad_id',$this->hasilpemeriksaanrad_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglpemeriksaanrad)',strtolower($this->tglpemeriksaanrad),true);
		$criteria->compare('LOWER(hasilexpertise)',strtolower($this->hasilexpertise),true);
		$criteria->compare('LOWER(kesan_hasilrad)',strtolower($this->kesan_hasilrad),true);
		$criteria->compare('LOWER(kesimpulan_hasilrad)',strtolower($this->kesimpulan_hasilrad),true);
		$criteria->compare('LOWER(tglpegambilanhasilrad)',strtolower($this->tglpegambilanhasilrad),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('hasilpemeriksaanrad_id',$this->hasilpemeriksaanrad_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglpemeriksaanrad)',strtolower($this->tglpemeriksaanrad),true);
		$criteria->compare('LOWER(hasilexpertise)',strtolower($this->hasilexpertise),true);
		$criteria->compare('LOWER(kesan_hasilrad)',strtolower($this->kesan_hasilrad),true);
		$criteria->compare('LOWER(kesimpulan_hasilrad)',strtolower($this->kesimpulan_hasilrad),true);
		$criteria->compare('LOWER(tglpegambilanhasilrad)',strtolower($this->tglpegambilanhasilrad),true);
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
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'timestamp without time zone'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }
                
//        HINDARI PENGGUNAAN AFTER FIND 
//        UNTUK FORMATTING TANGGAL BAIKNYA DILAKUKAN DI VIEW/CONTROLLER
//        KARNA SETIAP REQUEST DATA BISA JADI FORMAT YG DIINGINKAN BERBEDA2
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
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
//                        }
//            }
//            return true;
//        }
        
        protected function beforeSave() {
            if($this->tglpegambilanhasilrad===null || trim($this->tglpegambilanhasilrad)==''){
                $this->setAttribute('tglpegambilanhasilrad', null);
            }
            return parent::beforeSave();
        }
		
		/**
		 * load data untuk dikirim ke HL-7 Broker
		 * RND-8272
		 * @return string
		 */
		public function getDataBroker(){
			$data = "";
			$criteria = new CDbCriteria();
			$criteria->join = "JOIN pemeriksaanmapalatrad_m ON pemeriksaanmapalatrad_m.pemeriksaanalatrad_id = t.pemeriksaanalatrad_id";
			$criteria->addCondition("t.pemeriksaanalatrad_aktif = TRUE");
			$criteria->addCondition("pemeriksaanmapalatrad_m.pemeriksaanrad_id = ".$this->pemeriksaanrad_id);
			$modAlat = PemeriksaanalatradM::model()->find($criteria);
			if($modAlat){
				$data = $this->pasien->no_rekam_medik
						."+".$this->pasien->nama_pasien
						."+".$this->pasien->tanggal_lahir
						."+".$this->pasien->jeniskelamin
						."+".$this->pendaftaran->no_pendaftaran
						."+".$this->pemeriksaanrad->pemeriksaanrad_id
						."+".$this->pemeriksaanrad->pemeriksaanrad_nama
						."+".$this->pemeriksaanrad->pemeriksaanrad_kode
						."+".$this->hasilpemeriksaanrad_id
						."+".$modAlat->pemeriksaanalatrad_aetitle
						."+".$modAlat->pemeriksaanalatrad_nama;
			}
			return $data;
		}
		
		
		
}