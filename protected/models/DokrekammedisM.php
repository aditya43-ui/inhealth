<?php

/**
 * This is the model class for table "dokrekammedis_m".
 *
 * The followings are the available columns in table 'dokrekammedis_m':
 * @property integer $dokrekammedis_id
 * @property integer $warnadokrm_id
 * @property integer $subrak_id
 * @property integer $lokasirak_id
 * @property integer $pasien_id
 * @property string $nodokumenrm
 * @property string $tglrekammedis
 * @property string $tglmasukrak
 * @property string $statusrekammedis
 * @property string $tglkeluarakhir
 * @property string $tglmasukakhir
 * @property string $nomortertier
 * @property string $nomorsekunder
 * @property string $nomorprimer
 * @property string $warnanorm_i
 * @property string $warnanorm_ii
 * @property string $tgl_in_aktif
 * @property string $tglpemusnahan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class DokrekammedisM extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $nama_pasien;
        public $no_rekam_medik;
        public $print;
        public $tglpendaftaran;
        public $instalasi;
        public $ruangan;
		public $lookup_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DokrekammedisM the static model class
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
		return 'dokrekammedis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warnadokrm_id, tglrekammedis, tglmasukrak', 'required'),
			array('warnadokrm_id, subrak_id, lokasirak_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('nodokumenrm', 'length', 'max'=>20),
			array('statusrekammedis', 'length', 'max'=>10),
			array('nomortertier, nomorsekunder, nomorprimer', 'length', 'max'=>2),
			array('warnanorm_i, warnanorm_ii', 'length', 'max'=>50),
			array('nama_pasien, tgl_awal, tgl_akhir, tglkeluarakhir, tglmasukakhir, tgl_in_aktif, tglpemusnahan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nama_pasien, tgl_awal, tgl_akhir, print, instalasi, ruangan, no_rekam_medik, dokrekammedis_id, warnadokrm_id, subrak_id, lokasirak_id, pasien_id, nodokumenrm, tglrekammedis, tglmasukrak, statusrekammedis, tglkeluarakhir, tglmasukakhir, nomortertier, nomorsekunder, nomorprimer, warnanorm_i, warnanorm_ii, tgl_in_aktif, tglpemusnahan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'warnadok'=>array(self::BELONGS_TO, 'WarnadokrmM', 'warnadokrm_id'),
			'subrak'=>array(self::BELONGS_TO, 'SubrakM', 'subrak_id'),
			'lokasirak'=>array(self::BELONGS_TO, 'LokasirakM', 'lokasirak_id'),
			'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangan'=>array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dokrekammedis_id' => 'Dokumen Rekam Medis Id',
			'warnadokrm_id' => 'Warna Dokumen',
			'subrak_id' => 'Sub Rak',
			'lokasirak_id' => 'Lokasi Rak',
			'pasien_id' => 'Nama Pasien',
			'nodokumenrm' => 'No. Dokumen RM',
			'tglrekammedis' => 'Tanggal Rekam Medis',
			'tglmasukrak' => 'Tanggal Masuk Rak',
			'statusrekammedis' => 'Status',
			'tglkeluarakhir' => 'Tanggal Keluar Akhir',
			'tglmasukakhir' => 'Tanggal Masuk Akhir',
			'nomortertier' => 'Nomor Tertier',
			'nomorsekunder' => 'Nomor Sekunder',
			'nomorprimer' => 'Nomor Primer',
			'warnanorm_i' => 'Warna Norm I',
			'warnanorm_ii' => 'Warna Norm II',
			'tgl_in_aktif' => 'Tanggal Inaktif',
			'tglpemusnahan' => 'Tanggal Pemusnahan',
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
		if (!empty($this->dokrekammedis_id)){
		$criteria->addCondition('dokrekammedis_id ='.$this->dokrekammedis_id);
		}
		if (!empty($this->warnadokrm_id)){
		$criteria->addCondition('warnadokrm_id ='.$this->warnadokrm_id);
		}
		if (!empty($this->subrak_id)){
		$criteria->addCondition('subrak_id ='.$this->subrak_id);
		}
		if (!empty($this->lokasirak_id)){
		$criteria->addCondition('lokasirak_id ='.$this->lokasirak_id);
		}
		if (!empty($this->pasien_id)){
		$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
		$criteria->compare('LOWER(tglmasukrak)',strtolower($this->tglmasukrak),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(tglkeluarakhir)',strtolower($this->tglkeluarakhir),true);
		$criteria->compare('LOWER(tglmasukakhir)',strtolower($this->tglmasukakhir),true);
		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
		$criteria->compare('LOWER(warnanorm_i)',strtolower($this->warnanorm_i),true);
		$criteria->compare('LOWER(warnanorm_ii)',strtolower($this->warnanorm_ii),true);
		$criteria->compare('LOWER(tgl_in_aktif)',strtolower($this->tgl_in_aktif),true);
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchinformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pasien');
		$criteria->compare('LOWER(pasien.nama_pasien)',$this->nama_pasien,true);
		if (!empty($this->subrak_id)){
		$criteria->addCondition('subrak_id ='.$this->subrak_id);
		}
		if (!empty($this->lokasirak_id)){
		$criteria->addCondition('lokasirak_id ='.$this->lokasirak_id);
		}
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
		$criteria->addBetweenCondition('date(tglrekammedis)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->dokrekammedis_id)){
		$criteria->addCondition('dokrekammedis_id ='.$this->dokrekammedis_id);
		}
		if (!empty($this->warnadokrm_id)){
		$criteria->addCondition('warnadokrm_id ='.$this->warnadokrm_id);
		}
		if (!empty($this->subrak_id)){
		$criteria->addCondition('subrak_id ='.$this->subrak_id);
		}
		if (!empty($this->lokasirak_id)){
		$criteria->addCondition('lokasirak_id ='.$this->lokasirak_id);
		}
		if (!empty($this->pasien_id)){
		$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
		
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('LOWER(tglrekammedis)',strtolower($this->tglrekammedis),true);
		$criteria->compare('LOWER(tglmasukrak)',strtolower($this->tglmasukrak),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(tglkeluarakhir)',strtolower($this->tglkeluarakhir),true);
		$criteria->compare('LOWER(tglmasukakhir)',strtolower($this->tglmasukakhir),true);
		$criteria->compare('LOWER(nomortertier)',strtolower($this->nomortertier),true);
		$criteria->compare('LOWER(nomorsekunder)',strtolower($this->nomorsekunder),true);
		$criteria->compare('LOWER(nomorprimer)',strtolower($this->nomorprimer),true);
		$criteria->compare('LOWER(warnanorm_i)',strtolower($this->warnanorm_i),true);
		$criteria->compare('LOWER(warnanorm_ii)',strtolower($this->warnanorm_ii),true);
		$criteria->compare('LOWER(tgl_in_aktif)',strtolower($this->tgl_in_aktif),true);
		$criteria->compare('LOWER(tglpemusnahan)',strtolower($this->tglpemusnahan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order = 'dokrekammedis_id';
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
            if($this->tglrekammedis===null || trim($this->tglrekammedis)==''){
	        $this->setAttribute('tglrekammedis', null);
            }
            if($this->tgl_in_aktif===null || trim($this->tgl_in_aktif)==''){
	        $this->setAttribute('tgl_in_aktif', null);
            }
            if($this->tglkeluarakhir===null || trim($this->tglkeluarakhir)==''){
	        $this->setAttribute('tglkeluarakhir', null);
            }
            if($this->tglmasukakhir===null || trim($this->tglmasukakhir)==''){
	        $this->setAttribute('tglmasukakhir', null);
            }
            if($this->tglmasukrak===null || trim($this->tglmasukrak)==''){
	        $this->setAttribute('tglmasukrak', null);
            }
            if($this->tglpemusnahan===null || trim($this->tglpemusnahan)==''){
	        $this->setAttribute('tglpemusnahan', null);
            }
            if($this->tglpendaftaran===null || trim($this->tglpendaftaran)==''){
	        $this->setAttribute('tglpendaftaran', null);
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
        
        public function getLokasirakItems() {
            return LokasirakM::model()->findAll('lokasirak_aktif=TRUE ORDER BY lokasirak_nama');
        }        
        
        public function getSubrakItems() {
            return SubrakM::model()->findAll('subrak_aktif=TRUE ORDER BY subrak_nama');
        }
		
        public function getWarnaItems() {
            return WarnadokrmM::model()->findAll('warnadokrm_aktif=TRUE ORDER BY warnadokrm_namawarna');
        }
		
		
}