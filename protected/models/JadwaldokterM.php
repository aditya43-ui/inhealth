<?php

/**
 * This is the model class for table "jadwaldokter_m".
 *
 * The followings are the available columns in table 'jadwaldokter_m':
 * @property integer $jadwaldokter_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $jadwaldokter_hari
 * @property string $jadwaldokter_buka
 * @property string $jadwaldokter_mulai
 * @property string $jadwaldokter_tutup
 * @property integer $maximumantrian
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $tutupjadwaldokter_id
 * @property string $jadwaldokterpengganti_id
 */
class JadwaldokterM extends CActiveRecord
{
	public $jadwal_awal;
	public $jadwal_akhir;
	public $nama_pegawai, $gelardepan, $gelarbelakang_nama;
        public $photopegawai, $ruangan_nama;
		public $ceklis;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwaldokterM the static model class
	 */
	public $bulan;
	public $instalasi_id;	 
		
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jadwaldokter_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, jadwaldokter_hari, jadwaldokter_buka, jadwaldokter_mulai, jadwaldokter_tutup', 'required'),
			array('instalasi_id, ruangan_id, pegawai_id, maximumantrian, maximumbpjsantrian', 'numerical', 'integerOnly'=>true),
			array('jadwaldokter_hari', 'length', 'max'=>20),
			array('jadwaldokter_buka', 'length', 'max'=>50),
                        array('jadwaldokter_mulai, jadwaldokter_tutup', 'date', 'format'=>'H:m:s'),
			array('jadwaldokter_tgl, maksbuatjanji, bulan, jadwaldokter_mulai, jadwaldokter_tutup, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
                        array('jadwaldokter_mulai, jadwaldokter_tutup','setValidation'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tutupjadwaldokter_id, jadwaldokterpengganti_id, estimasipelayanan', 'safe'),
			array('maximumbpjsantrian, maksbuatjanji, jadwaldokter_id, instalasi_id, ruangan_id, pegawai_id, jadwaldokter_hari, jadwaldokter_buka, jadwaldokter_mulai, jadwaldokter_tutup, maximumantrian, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
		);
	}
        
        public function setValidation(){
            /*
            if (!$this->hasErrors()){
                $tgl_mulai = strtotime(date("Y-m-d").' '.$this->jadwaldokter_mulai);
                $tgl_tutup = strtotime(date("Y-m-d").' '.$this->jadwaldokter_tutup);
                
                if ($tgl_tutup < $tgl_mulai){
                    $this->addError('jadwaldokter_mulai', 'Jadwal dokter mulai tidak boleh lebih dari '.$this->jadwaldokter_tutup);
                }
            }
             * 
             */
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                        'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
                        'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
                        'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwaldokter_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Dokter',
			'jadwaldokter_hari' => 'Hari',
			'jadwaldokter_buka' => 'Jadwal Buka',
			'jadwaldokter_mulai' => 'Jadwal Mulai',
			'jadwaldokter_tutup' => 'Jadwal Tutup',
			'maximumantrian' => 'Maximum Antrian',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'maksbuatjanji' => 'Maximum Buat Janji',
			'maximumbpjsantrian' => 'Maximum Antrian BPJS'
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

		$criteria->join = 'join pegawai_m p on p.pegawai_id = t.pegawai_id';
		$criteria->compare('lower(p.nama_pegawai)', strtolower($this->nama_pegawai), true);

		$criteria->compare('t.jadwaldokter_id',$this->jadwaldokter_id);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.jadwaldokter_hari)',strtolower($this->jadwaldokter_hari),true);
		$criteria->compare('LOWER(t.jadwaldokter_buka)',strtolower($this->jadwaldokter_buka),true);
//		$criteria->addBetweenCondition('jadwaldokter_mulai', $this->jadwaldokter_mulai, $this->jadwaldokter_tutup);
		$criteria->compare('t.jadwaldokter_tutup',strtolower($this->jadwaldokter_tutup));
		$criteria->compare('t.jadwaldokter_mulai',strtolower($this->jadwaldokter_mulai));
		$criteria->compare('t.maximumantrian',$this->maximumantrian);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
                


                if (!empty($this->bulan)) {
                    
                    $criteria->addBetweenCondition('t.jadwaldokter_tgl::date'
                            , date('Y-m-d', strtotime(date('Y')."-".$this->bulan."-01"))
                            , date('Y-m-t', strtotime(date('Y')."-".$this->bulan."-01"))
                    );
                }
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                 if (!empty($this->bulan)){                    
                    $criteria->addBetweenCondition('DATE(jadwaldokter_tgl)', date('Y-m-1', strtotime(date('Y-'.$this->bulan.'-1'))), date('Y-m-t',strtotime(date('Y-'.$this->bulan.'-t'))));
                }else{                    
                    $criteria->addBetweenCondition('DATE(jadwaldokter_tgl)', date('Y-m-1'), date('Y-m-t'));
                }
		$criteria->compare('jadwaldokter_id',$this->jadwaldokter_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(jadwaldokter_hari)',strtolower($this->jadwaldokter_hari),true);
		$criteria->compare('LOWER(jadwaldokter_buka)',strtolower($this->jadwaldokter_buka),true);
		$criteria->compare('LOWER(jadwaldokter_mulai)',strtolower($this->jadwaldokter_mulai),true);
		$criteria->compare('LOWER(jadwaldokter_tutup)',strtolower($this->jadwaldokter_tutup),true);
		$criteria->compare('maximumantrian',$this->maximumantrian);
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
        
        public function getListHari()
        { 
           return $list = array('listHari'=>'Senin',
                                    'Selasa',
                                    'Rabu',
                                    'Kamis',
                                    'Jumat',
                                    'Sabtu',
                                    'Minggu',
                                );
        }
        
        public function getNamaLengkap(){
            return (!empty($this->gelardepan)?$this->gelardepan.' ':'').$this->nama_pegawai.(!empty($this->gelarbelakang_nama)?', '.$this->gelarbelakang_nama:'');
        }
}