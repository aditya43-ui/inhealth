<?php

/**
 * This is the model class for table "pengirimanrm_t".
 *
 * The followings are the available columns in table 'pengirimanrm_t':
 * @property integer $pengirimanrm_id
 * @property integer $peminjamanrm_id
 * @property integer $kembalirm_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $dokrekammedis_id
 * @property integer $ruangan_id
 * @property string $nourut_keluar
 * @property string $tglpengirimanrm
 * @property boolean $kelengkapandokumen
 * @property string $petugaspengirim
 * @property boolean $printpengiriman
 * @property integer $ruanganpengirim_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PengirimanrmT extends CActiveRecord
{
        public $tgl_rekam_medik;
        public $tgl_rekam_medik_akhir; 
        public $no_rekam_medik; 
        public $no_rekam_medik_akhir; 
        public $nama_pasien; 
        public $statusrekammedis;
        public $instalasi_id;
        public $no_pendaftaran;
        public $petugaspengirim_nama;
		public $statusdokrm;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengirimanrmT the static model class
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
		return 'pengirimanrm_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, dokrekammedis_id, ruangan_id, nourut_keluar, tglpengirimanrm', 'required'),
			array('peminjamanrm_id, kembalirm_id, pasien_id, pendaftaran_id, dokrekammedis_id, ruangan_id, ruanganpengirim_id', 'numerical', 'integerOnly'=>true),
			array('nourut_keluar', 'length', 'max'=>5),
			array('petugaspengirim', 'length', 'max'=>100),
			array('petugaspengirim_nama, kelengkapandokumen, printpengiriman, update_time, update_loginpemakai_id', 'safe'),                    
			array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('create_ruangan, ruanganpengirim_id','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('no_pendaftaran, instalasi_id, statusrekammedis, nama_pasien, tgl_rekam_medik, tgl_rekam_medik_akhir, no_rekam_medik, no_rekam_medik_akhir, pengirimanrm_id, peminjamanrm_id, kembalirm_id, pasien_id, pendaftaran_id, dokrekammedis_id, ruangan_id, nourut_keluar, tglpengirimanrm, kelengkapandokumen, petugaspengirim, printpengiriman, ruanganpengirim_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglterimadokrm, ruanganpenerima_id, petugaspenerima_id', 'safe', 'on'=>'search'),
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
			'dokrekammedis'=>array(self::BELONGS_TO, 'DokrekammedisM', 'dokrekammedis_id'),
			'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangantujuan'=>array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'ruanganpengirim'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganpengirim_id'),
			'ruanganpenerima'=>array(self::BELONGS_TO, 'RuanganM', 'ruanganpenerima_id'),
			'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengirimanrm_id' => 'Pengiriman RM',
			'peminjamanrm_id' => 'Peminjaman RM',
			'kembalirm_id' => 'Kembali RM',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'dokrekammedis_id' => 'Dokumen RM',
			'ruangan_id' => 'Ruangan',
			'nourut_keluar' => 'Nourut Keluar',
			'tglpengirimanrm' => 'Tanggal Pengiriman',
			'kelengkapandokumen' => 'Kelengkapandokumen',
			'petugaspengirim' => 'Petugas Pengirim',
			'printpengiriman' => 'Print Pengiriman',
			'ruanganpengirim_id' => 'Ruangan Pengirim',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'instalasi_id'=>'Instalasi',
                        'tgl_rekam_medik'=>'Tanggal Rekam Medis',
                        'tglrekammedis'=>"Tanggal Rekam Medis",
                        'no_rekam_medik' => 'No. Rekam Medik',
                        'no_pendaftaran' => 'No. Pendaftaran'
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

		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('kembalirm_id',$this->kembalirm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(nourut_keluar)',strtolower($this->nourut_keluar),true);
		$criteria->compare('LOWER(tglpengirimanrm)',strtolower($this->tglpengirimanrm),true);
		$criteria->compare('kelengkapandokumen',$this->kelengkapandokumen);
		$criteria->compare('LOWER(petugaspengirim)',strtolower($this->petugaspengirim),true);
		$criteria->compare('printpengiriman',$this->printpengiriman);
		$criteria->compare('ruanganpengirim_id',$this->ruanganpengirim_id);
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
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('kembalirm_id',$this->kembalirm_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(nourut_keluar)',strtolower($this->nourut_keluar),true);
		$criteria->compare('LOWER(tglpengirimanrm)',strtolower($this->tglpengirimanrm),true);
		$criteria->compare('kelengkapandokumen',$this->kelengkapandokumen);
		$criteria->compare('LOWER(petugaspengirim)',strtolower($this->petugaspengirim),true);
		$criteria->compare('printpengiriman',$this->printpengiriman);
		$criteria->compare('ruanganpengirim_id',$this->ruanganpengirim_id);
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
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                     else if ($column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }    
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglpengirimanrm===null || trim($this->tglpengirimanrm)==''){
	        $this->setAttribute('tglpengirimanrm', null);
            }
            
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
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
}