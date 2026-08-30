<?php

/**
 * This is the model class for table "rencanaoperasi_t".
 *
 * The followings are the available columns in table 'rencanaoperasi_t':
 * @property integer $rencanaoperasi_id
 * @property integer $operasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglrencanaoperasi
 * @property string $norencanaoperasi
 * @property string $mulaioperasi
 * @property string $selesaioperasi
 * @property string $statusoperasi
 * @property string $dokterpelaksana1_id
 * @property string $dokterpelaksana2_id
 * @property string $dokteranastesi_id
 * @property string $dokterresusitasi_id
 * @property string $dokterdelegasi_id
 * @property string $bidan_id
 * @property string $suster_id
 * @property string $perawat_id
 * @property string $keterangan_rencana
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class RencanaoperasiT extends CActiveRecord
{
        public $tgl_awal, $tgl_akhir, $nama_pasien, $nama_bin, $no_rekam_medik, $no_pendaftaran, $perawat_id;
        public $operasi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaoperasiT the static model class
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
		return 'rencanaoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id,pasien_id,tglrencanaoperasi,norencanaoperasi,dokterpelaksana1_id','required'),
			array('operasi_id, pasienmasukpenunjang_id, pendaftaran_id, kamarruangan_id,ppds_id, pasienadmisi_id, pasien_id,pasienanastesi_id, pegmengetahui_id', 'numerical', 'integerOnly'=>true),
			array('norencanaoperasi, statusoperasi', 'length', 'max'=>50),
			array('mulaioperasi, selesaioperasi, dokterpelaksana2_id, dokterresusitasi_id,ppds_id, dokteranastesi_id, tgl_awal, tgl_akhir, nama_pasien, nama_bin, no_rekam_medik, no_pendaftaran, dokterdelegasi_id, bidan_id, suster_id, perawat_id, keterangan_rencana, update_time, update_loginpemakai_id, is_operasibersama, is_cyto, perawatsirkuler_id, pegmengetahui_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time,update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('rencanaoperasi_id, pasienanastesi_id, operasi_id, ppds_id, dokterresusitasi_id, pasienmasukpenunjang_id, tgl_awal, tgl_akhir, pendaftaran_id, nama_pasien, nama_bin, no_rekam_medik, no_pendaftaran, kamarruangan_id, pasienadmisi_id, pasien_id, tglrencanaoperasi, norencanaoperasi, mulaioperasi, selesaioperasi, statusoperasi, dokterpelaksana1_id, dokterpelaksana2_id, dokteranastesi_id, dokterdelegasi_id, bidan_id, suster_id, perawat_id, keterangan_rencana, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, is_operasibersama, is_cyto, tgl_mengetahui, pegmengetahui_id', 'safe', 'on'=>'search'),
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
                    'operasi'=>array(self::BELONGS_TO, 'OperasiM', 'operasi_id'),
                    'golonganoperasi'=>array(self::BELONGS_TO, 'GolonganoperasiM','golonganoperasi_id'),
                    'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananM','tindakanpelayanan_id'),
                    'dokter1'=>array(self::BELONGS_TO,'PegawaiM','dokterpelaksana1_id'),
					'suster'=>array(self::BELONGS_TO,'PegawaiM','suster_id'),
					'bidan'=>array(self::BELONGS_TO,'PegawaiM','bidan_id'),
					'perawatsirkuler'=>array(self::BELONGS_TO,'PegawaiM','perawatsirkuler_id'),
					'paramedis'=>array(self::BELONGS_TO,'PegawaiM','paramedis_id'),
                    'dokter2'=>array(self::BELONGS_TO,'PegawaiM','dokterpelaksana2_id'),
                    'dokteranastesi'=>array(self::BELONGS_TO, 'PegawaiM','dokteranastesi_id'),
                    'dokterresusitasi'=>array(self::BELONGS_TO, 'PegawaiM','dokterresusitasi_id'),
				    'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
                    'pasienanastesi'=>array(self::BELONGS_TO,'PasienanastesiT','pasienanastesi_id'),
					'pasienmasukpenunjang'=>array(self::BELONGS_TO,'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
                    'pegmengetahuis'=>array(self::BELONGS_TO, 'PegawaiM','pegmengetahui_id'),
					'ppds'=>array(self::BELONGS_TO, 'PpdsM','ppds_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanaoperasi_id' => 'ID',
			'operasi_id' => 'Operasi',
			'ppds_id'=> 'PPDS',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'pendaftaran_id' => 'Pendaftaran',
			'kamarruangan_id' => 'Kamar Ruangan',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pasien_id' => 'Pasien',
			'dokterresusitasi_id'=>'Dokter Resusitasi',
			'tglrencanaoperasi' => 'Tanggal Rencana Operasi',
			'norencanaoperasi' => 'No. Rencana Operasi',
			'mulaioperasi' => 'Mulai Operasi',
			'selesaioperasi' => 'Tanggal Selesai',
			'statusoperasi' => 'Status Operasi',
			'dokterpelaksana1_id' => 'Dokter Pelaksana 1',
			'dokterpelaksana2_id' => 'Dokter Pelaksana 2',
			'dokteranastesi_id' => 'Dokter Anastesi',
			'dokterdelegasi_id' => 'Dokter Delegasi',
			'perawat_id' => 'Perawat',
			'paramedis_id' => 'Perawat',
			'suster_id' => 'Perawat 2',
			'bidan_id' => 'Perawat 3',
                        'perawatsirkuler_id' => 'Perawat 4',
			'keterangan_rencana' => 'Keterangan Rencana',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('LOWER(tglrencanaoperasi)',strtolower($this->tglrencanaoperasi),true);
		$criteria->compare('LOWER(norencanaoperasi)',strtolower($this->norencanaoperasi),true);
		$criteria->compare('LOWER(mulaioperasi)',strtolower($this->mulaioperasi),true);
		$criteria->compare('LOWER(selesaioperasi)',strtolower($this->selesaioperasi),true);
		$criteria->compare('LOWER(statusoperasi)',strtolower($this->statusoperasi),true);
		$criteria->compare('LOWER(dokterpelaksana1_id)',strtolower($this->dokterpelaksana1_id),true);
		$criteria->compare('LOWER(dokterpelaksana2_id)',strtolower($this->dokterpelaksana2_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterresusitasi_id)',strtolower($this->dokterresusitasi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('LOWER(perawat_id)',strtolower($this->perawat_id),true);
		$criteria->compare('LOWER(keterangan_rencana)',strtolower($this->keterangan_rencana),true);
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
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('ppds_id', $this->kamarruangan_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglrencanaoperasi)',strtolower($this->tglrencanaoperasi),true);
		$criteria->compare('LOWER(norencanaoperasi)',strtolower($this->norencanaoperasi),true);
		$criteria->compare('LOWER(mulaioperasi)',strtolower($this->mulaioperasi),true);
		$criteria->compare('LOWER(selesaioperasi)',strtolower($this->selesaioperasi),true);
		$criteria->compare('LOWER(statusoperasi)',strtolower($this->statusoperasi),true);
		$criteria->compare('LOWER(dokterpelaksana1_id)',strtolower($this->dokterpelaksana1_id),true);
		$criteria->compare('LOWER(dokterpelaksana2_id)',strtolower($this->dokterpelaksana2_id),true);
		$criteria->compare('LOWER(dokteranastesi_id)',strtolower($this->dokteranastesi_id),true);
		$criteria->compare('LOWER(dokterdelegasi_id)',strtolower($this->dokterdelegasi_id),true);
		$criteria->compare('LOWER(bidan_id)',strtolower($this->bidan_id),true);
		$criteria->compare('LOWER(suster_id)',strtolower($this->suster_id),true);
		$criteria->compare('LOWER(perawat_id)',strtolower($this->perawat_id),true);
		$criteria->compare('LOWER(keterangan_rencana)',strtolower($this->keterangan_rencana),true);
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
                            //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {          
            return parent::beforeSave();
        }
                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
		
		public function getKruBedahByLookup($lookup, $rencanaoperasi_id){
			$cri = new CDbCriteria();
			$cri->compare(" LOWER(krubedah) ", strtolower($lookup));
			$cri->addCondition(" batalpelaksanaoperasi_id IS NULL ");
			$cri->addCondition(" rencanaoperasi_id = ".$rencanaoperasi_id." ");
			
			return BSPelaksanaoperasiT::model()->findAll($cri);
		}
}