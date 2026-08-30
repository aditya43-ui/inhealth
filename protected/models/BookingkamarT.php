<?php

/**
 * This is the model class for table "bookingkamar_t".
 *
 * The followings are the available columns in table 'bookingkamar_t':
 * @property integer $bookingkamar_id
 * @property integer $kelaspelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property string $bookingkamar_no
 * @property string $tglbookingkamar
 * @property string $statusbooking
 * @property string $keteranganbooking
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $statuskonfirmasi
 * @property string $tglakhirkonfirmasi
 */
class BookingkamarT extends CActiveRecord
{
        public $isPasienLama = false;
        public $noRekamMedik = '';
        public $namaPasien;
        public $namaBin;
        public $alamat;
        public $propinsi;
        public $kabupaten;
        public $kecamatan;
        public $kelurahan;
        public $umur = '';
        public $tgl_awal;
        public $tgl_akhir;
        public $isNoPendaftaran;
        public $ruanganJalanGd;
        public $ruanganInap;


        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BookingkamarT the static model class
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
		return 'bookingkamar_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, pasien_id, ruangan_id, bookingkamar_no, tglbookingkamar, statusbooking, kamarruangan_id', 'required'),
			array('kelaspelayanan_id, pendaftaran_id, kamarruangan_id, pasien_id, ruangan_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('bookingkamar_no', 'length', 'max'=>20),
			array('statusbooking, statuskonfirmasi', 'length', 'max'=>50),
			array('keteranganbooking, update_time, update_loginpemakai_id, statuskonfirmasi', 'safe'),                      
			array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bookingkamar_id,no_pendaftaran,tgltransaksibooking, statuskonfirmasi, kelaspelayanan_id, pendaftaran_id, kamarruangan_id, pasien_id, ruangan_id, pasienadmisi_id, bookingkamar_no, tglbookingkamar, statusbooking, keteranganbooking, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, statuskonfirmasi, tglakhirkonfirmasi', 'safe', 'on'=>'search'),
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
                    'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM','kelaspelayanan_id'),
                    'pendaftaran'=>array(self::HAS_MANY, 'PendaftaranT','pasien_id'),
                    'kamarruangan'=>array(self::BELONGS_TO, 'KamarruanganM','kamarruangan_id'),
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                    'pasienadmisi'=>array(self::BELONGS_TO, 'PasienadmisiT','pasienadmisi_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bookingkamar_id' => 'ID',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'pendaftaran_id' => 'No. Pendaftaran',
			'kamarruangan_id' => 'No. Kamar',
			'pasien_id' => 'No. Rekam Medik',
			'ruangan_id' => 'Ruangan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'bookingkamar_no' => 'No. Pemesanan',
			'tglbookingkamar' => 'Tanggal Pemesanan',
			'statusbooking' => 'Status Pemesanan',
			'keteranganbooking' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tgl_awal'=>'Tanggal Transaksi',
			'tgl_akhir'=>'s/d',
			'tgltransaksibooking'=>'Tanggal Transaksi',
			'NamaNamaBIN' => 'Nama Pasien',
			'CaraBayarPenjamin'=>'Cara Bayar/Penjamin',
			'statuskonfirmasi'=>'Status Konfirmasi',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tglakhirkonfirmasi'=>'Tanggal Akhir Konfirmasi'
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

		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(bookingkamar_no)',strtolower($this->bookingkamar_no),true);
		$criteria->compare('LOWER(tglbookingkamar)',strtolower($this->tglbookingkamar),true);
		$criteria->compare('LOWER(statusbooking)',strtolower($this->statusbooking),true);
		$criteria->compare('LOWER(keteranganbooking)',strtolower($this->keteranganbooking),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(statuskonfirmasi)',strtolower($this->statuskonfirmasi),true);
		$criteria->compare('LOWER(tglakhirkonfirmasi)',strtolower($this->tglakhirkonfirmasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
			$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
			$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
			$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
			$criteria->compare('pasien_id',$this->pasien_id);
			$criteria->compare('ruangan_id',$this->ruangan_id);
			$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
			$criteria->compare('LOWER(bookingkamar_no)',strtolower($this->bookingkamar_no),true);
			$criteria->compare('LOWER(tglbookingkamar)',strtolower($this->tglbookingkamar),true);
			$criteria->compare('LOWER(statusbooking)',strtolower($this->statusbooking),true);
			$criteria->compare('LOWER(keteranganbooking)',strtolower($this->keteranganbooking),true);
			$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
			$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
			$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
			$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
			$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
			$criteria->compare('LOWER(statuskonfirmasi)',strtolower($this->statuskonfirmasi),true);
			$criteria->compare('LOWER(tglakhirkonfirmasi)',strtolower($this->tglakhirkonfirmasi),true);
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

//        public function beforeSave() {         
//            if($this->tglbookingkamar===null || trim($this->tglbookingkamar)==''){
//	        $this->setAttribute('tglbookingkamar', null);
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
        
        public function getKamarRuanganItems()
        {
            return KamarruanganM::model()->findAll(array('order'=>'kamarruangan_nokamar '));
          
        } 
        public function getKamarRuangan()
        {
            return KamarruanganM::model()->findAll('ruangan_id='.$this->ruangan_id.'');
        }
        
        public function getKelasPelayanan()
        {
            if(!empty($this->kamarruangan_id))
			{
				return KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id='.$this->kamarruangan_id); 
				 // return KamarruanganM::model()->with('kelaspelayanan')->findAll('kamarruangan_id='.$this->kamarruangan_id.'',array('order'=>'kelaspelayanan.kelaspelayanan_nama'));  
			}
			else
			{
				return array();
			}    
        }   
        
        public function getNamaNamaBIN()
        {
            return $this->pasien->nama_pasien.' bin '.$this->pasien->nama_bin;
        }
        
        public function getCaraBayarPenjamin()
        {
			return $this->carabayar_nama.'/'.$this->penjamin_nama;
        }
                     
}
        
