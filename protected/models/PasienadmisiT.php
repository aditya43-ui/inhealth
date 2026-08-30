<?php

/**
 * This is the model class for table "pasienadmisi_t".
 *
 * The followings are the available columns in table 'pasienadmisi_t':
 * @property integer $pasienadmisi_id
 * @property integer $penjamin_id
 * @property integer $kelaspelayanan_id
 * @property integer $caramasuk_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $carabayar_id
 * @property integer $bookingkamar_id
 * @property string $tgladmisi
 * @property string $tglpendaftaran
 * @property string $tglpulang
 * @property string $kunjungan
 * @property boolean $statuskeluar
 * @property boolean $rawatgabung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $rencanapulang
 */
class PasienadmisiT extends CActiveRecord
{
        public $masukkamar = true;
		public $isKontrol;
        public $jeniskelamin, $jeniskasuspenyakit_id;
        public $diagnosisutama_masuk, $diagnosisutama_akhir, $is_nonkelas;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienadmisiT the static model class
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
		return 'pasienadmisi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjamin_id, kelaspelayanan_id, caramasuk_id, pasien_id, ruangan_id, carabayar_id, tgladmisi, tglpendaftaran, kunjungan', 'required'),
			array('penjamin_id, kelaspelayanan_id, caramasuk_id, pendaftaran_id, kamarruangan_id, pegawai_id, pasien_id, ruangan_id, carabayar_id, bookingkamar_id, sep_id', 'numerical', 'integerOnly'=>true),
			array('kunjungan', 'length', 'max'=>50),
			array('dokterpenerima_id,dokter_pengirim, dpjp1_id, dpjp2_id, dpjp3_id, dpjp4_id, dpjp5_id, tglpulang, statuskeluar, rawatgabung, rencanapulang', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('shift_id','default','value'=>Yii::app()->user->getState('shift_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dokterpenerima_id, dpjp2_id, dpjp3_id, dpjp4_id, dpjp5_id, pasienadmisi_id, penjamin_id, kelaspelayanan_id, caramasuk_id, pendaftaran_id, kamarruangan_id, pegawai_id, pasien_id, ruangan_id, carabayar_id, bookingkamar_id, tgladmisi, tglpendaftaran, tglpulang, kunjungan, statuskeluar, rawatgabung, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rencanapulang, sep_id', 'safe', 'on'=>'search'),
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
                    'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
                    'carabayar'=>array(self::BELONGS_TO,  'CarabayarM', 'carabayar_id'),
                    'penjamin'=>array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
                    'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                    'kelaspelayanan'=>array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
					'pegawai2'=>array(self::BELONGS_TO, 'PegawaiM', 'dpjp2_id'),
					'pegawai3'=>array(self::BELONGS_TO, 'PegawaiM', 'dpjp3_id'),
					'pegawai4'=>array(self::BELONGS_TO, 'PegawaiM', 'dpjp4_id'),
					'pegawai5'=>array(self::BELONGS_TO, 'PegawaiM', 'dpjp5_id'),
					
                    'kamarruangan'=>array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
                    'caramasuk'=>array(self::BELONGS_TO, 'CaramasukM', 'caramasuk_id'),
                    'dokpenerima'=>array(self::BELONGS_TO, 'PegawaiM', 'dokterpenerima_id'),
					'sepTs' => array(self::BELONGS_TO, 'SepT', 'sep_id'),

					'spesialis' => array(self::BELONGS_TO, 'JeniskasuspenyakitM', 'spesialis_id'),
					'carakeluar' => array(self::BELONGS_TO, 'CarakeluarM', 'rencanacarakeluar_id'),
					'kondisikeluar' => array(self::BELONGS_TO, 'KondisiKeluarM', 'rencanakondisikeluar_id'),

					'pasienpulang' => array(self::BELONGS_TO, 'PasienpulangT', 'pasienpulang_id'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienadmisi_id' => 'Pasien Admisi',
			'penjamin_id' => 'Penjamin',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'caramasuk_id' => 'Cara Masuk',
			'pendaftaran_id' => 'Pendaftaran',
			'kamarruangan_id' => 'Kamar',
			'dokterpenerima_id' => 'Dokter Penerima',
			'pegawai_id' => 'DPJP 1',
			'dpjp2_id' => 'DPJP 2',
			'dpjp3_id' => 'DPJP 3',
			'dpjp4_id' => 'DPJP 4',
			'dpjp5_id' => 'DPJP 5',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan Inap',
			'carabayar_id' => 'Jenis Penjamin',
			'bookingkamar_id' => 'Pemesanan Kamar',
			'tgladmisi' => 'Tanggal Admisi',
			'tglpendaftaran' => 'Tanggal Pendaftaran',
			'tglpulang' => 'Tanggal Pulang',
			'kunjungan' => 'Kunjungan',
			'statuskeluar' => 'Status Keluar',
			'rawatgabung' => 'Rawat Gabung',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'rencanapulang'=>'Tanggal Rencana Pulang',
			'is_titipan' => 'Pasien Titipan'
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

		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpendaftaran)',strtolower($this->tglpendaftaran),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('rencanapulang',$this->rencanapulang);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
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
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpendaftaran)',strtolower($this->tglpendaftaran),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
                $criteria->compare('rencanapulang',$this->rencanapulang);
		$criteria->compare('rawatgabung',$this->rawatgabung);
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
            $format = new MyFormatter();
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                    $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
            }
            return parent::beforeValidate ();
        }
        
        protected function beforeSave()
        {
            if($this->tglpulang === null || trim($this->tglpulang) == ''){
	        $this->setAttribute('tglpulang', null);
            }
            if($this->tgladmisi===null || trim($this->tgladmisi)==''){
	        $this->setAttribute('tgladmisi', null);
            }
            if($this->tglpendaftaran===null || trim($this->tglpendaftaran)==''){
	        $this->setAttribute('tglpendaftaran', null);
            }
            if($this->rencanapulang===null || trim($this->rencanapulang)==''){
	        $this->setAttribute('rencanapulang', null);
            }

            return parent::beforeSave();
        }                
        
}