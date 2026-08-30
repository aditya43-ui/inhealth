<?php

/**
 * This is the model class for table "reseptur_t".
 *
 * The followings are the available columns in table 'reseptur_t':
 * @property integer $reseptur_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $ppds_id
 * @property string $tglreseptur
 * @property string $noresep
 * @property integer $ruanganreseptur_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ResepturT extends CActiveRecord
{
        public $noPendaftaran;
        public $namaPasien;
        public $namaBin;
        public $noRekamMedik;
        public $tgl_awal,$qty;
        public $tgl_akhir;
        public $dokter;	
        public $noresep_depan, $noresep_belakang;
        public $pegawai_nama;
        public $kirim_sms_pasien, $penjamin_id;
		public $jml, $admracikan, $administrasi;

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResepturT the static model class
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
		return 'reseptur_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pegawai_id, ruangan_id, pasien_id, tglreseptur, noresep, ruanganreseptur_id', 'required'),
			array('pendaftaran_id, pegawai_id, ppds_id, pasienadmisi_id, ruangan_id, pasien_id, ruanganreseptur_id, jasapelayanan_farmasi', 'numerical', 'integerOnly'=>true),
			array('noresep', 'length', 'max'=>50),
			array('noPendaftaran, tgl_akhir, tgl_awal, noRekamMedik, namaPasien, namaBin, noPendaftaran, update_time, update_loginpemakai_id, itter, ppds_id, isterapipulang, ispasienbaru', 'safe'),
                    
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reseptur_id, pendaftaran_id, pegawai_id, pasienadmisi_id, ruangan_id, pasien_id, tglreseptur, noresep, ruanganreseptur_id, ppds_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, itter, jasapelayanan_farmasi, isterapipulang, ispasienbaru', 'safe', 'on'=>'search'),
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
                    'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PasienM', 'pegawai_id'),
                    'pegawairl'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
                    'ruanganreseptur'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganreseptur_id'),
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                    'penjualanresep'=>array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'),
                    'detailresep'=>array(self::HAS_MANY, 'ResepturdetailT', 'reseptur_id'),
					'pegawai2'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
					'createruangan'=>array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
					'ppds'=>array(self::BELONGS_TO, 'PpdsM', 'ppds_id'),
//			'pegawai'=>array(self::BELONGS_TO, 'pegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reseptur_id' => 'Reseptur',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Dokter',
			'pasienadmisi_id' => 'Pasienadmisi',
			'ruangan_id' => 'Apotek Tujuan',
			'pasien_id' => 'Pasien',
			'ppds_id' => 'PPDS',
			'tglreseptur' => 'Tanggal Resep',
			'noresep' => 'No. Resep',
			'ruanganreseptur_id' => 'Ruanganreseptur',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'itter'=>'itter',
			'is_cito'=>'Resep CITO',
			'isterapipulang'=>'Resep Perawatan',
			'isresepperawatan'=>'Resep Perawatan',
			
			
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

		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('itter',$this->itter);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('itter',$this->itter);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('reseptur_id',$this->reseptur_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
//		$criteria->compare('LOWER(tglreseptur)',strtolower($this->tglreseptur),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('ruanganreseptur_id',$this->ruanganreseptur_id);
                $criteria->order = 'tglreseptur DESC';
                $criteria->with = array('pasien','pendaftaran','penjualanresep');
                $criteria->addBetweenCondition('date(tglreseptur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->noRekamMedik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->namaPasien),true);
		$criteria->compare('LOWER(pasien.nama_bin)',strtolower($this->namaBin),true);
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->noPendaftaran),true);
//                $criteria->addCondition('t.penjualanresep_id IS NULL');

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
        
		public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==false){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
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


		       
        public function getPPDS($ruangan_id=null){
            // if (Yii::app()->user->getState('isppds')==true){
			// 	if(empty($ruangan_id))
			// 		$ruangan_id = Yii::app()->user->getState('ruangan_id');
            //     if(!empty($ruangan_id))
            //         return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'ppds_nama'));
            //     else
            //         return array();
            // }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addCondition("ppds_aktif = TRUE");
				$criteria->order = 'ppds_nama';
                return PpdsM::model()->findAll($criteria);
            }
    
        
        public function getApotekRawatJalan()
        {
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_aktif'=>true), array("order"=>"ruangan_nama ASC"));
        }
}