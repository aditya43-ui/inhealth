<?php

/**
 * This is the model class for table "pasienimunisasi_t".
 *
 * The followings are the available columns in table 'pasienimunisasi_t':
 * @property integer $pasienimunisasi_id
 * @property integer $statusimunisasi_id
 * @property integer $jadwalttbumil_id
 * @property integer $ruangan_id
 * @property integer $periksakehamilan_id
 * @property integer $diagnosa_id
 * @property integer $pendaftaran_id
 * @property integer $jadwalimunisasi_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property string $tglimunisasi
 * @property string $paramedis_id
 * @property string $catatanimunisasi
 */
class PasienimunisasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienimunisasiT the static model class
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
		return 'pasienimunisasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statusimunisasi_id, ruangan_id, diagnosa_id, pasien_id, tglimunisasi', 'required'),
			array('statusimunisasi_id, jadwalttbumil_id, ruangan_id, periksakehamilan_id, diagnosa_id, pendaftaran_id, jadwalimunisasi_id, pegawai_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('paramedis_id, catatanimunisasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienimunisasi_id, statusimunisasi_id, jadwalttbumil_id, ruangan_id, periksakehamilan_id, diagnosa_id, pendaftaran_id, jadwalimunisasi_id, pegawai_id, pasien_id, tglimunisasi, paramedis_id, catatanimunisasi', 'safe', 'on'=>'search'),
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
                   'paramedis'=>array(self::BELONGS_TO,'PegawaiM','paramedis_id'),
                   'dokter'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                   'jadwalttbumil'=>array(self::BELONGS_TO,'JadwalttbumilM','jadwalttbumil_id'), 
                   'statusimunisasi'=>array(self::BELONGS_TO,'StatusimunisasiM','statusimunisasi_id'),
                   'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'), 
                   'diagnosa'=>array(self::BELONGS_TO,'DiagnosaM','diagnosa_id'), 

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienimunisasi_id' => 'Pasienimunisasi',
			'statusimunisasi_id' => 'Status',
			'jadwalttbumil_id' => 'Jadwalttbumil',
			'ruangan_id' => 'Ruangan',
			'periksakehamilan_id' => 'Periksakehamilan',
			'diagnosa_id' => 'Diagnosa',
			'pendaftaran_id' => 'Pendaftaran',
			'jadwalimunisasi_id' => 'Jadwalimunisasi',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'tglimunisasi' => 'Tanggal Imunisasi',
			'paramedis_id' => 'Paramedis',
			'catatanimunisasi' => 'Catatan',
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

		$criteria->compare('pasienimunisasi_id',$this->pasienimunisasi_id);
		$criteria->compare('statusimunisasi_id',$this->statusimunisasi_id);
		$criteria->compare('jadwalttbumil_id',$this->jadwalttbumil_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('periksakehamilan_id',$this->periksakehamilan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jadwalimunisasi_id',$this->jadwalimunisasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglimunisasi)',strtolower($this->tglimunisasi),true);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(catatanimunisasi)',strtolower($this->catatanimunisasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasienimunisasi_id',$this->pasienimunisasi_id);
		$criteria->compare('statusimunisasi_id',$this->statusimunisasi_id);
		$criteria->compare('jadwalttbumil_id',$this->jadwalttbumil_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('periksakehamilan_id',$this->periksakehamilan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jadwalimunisasi_id',$this->jadwalimunisasi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglimunisasi)',strtolower($this->tglimunisasi),true);
		$criteria->compare('LOWER(paramedis_id)',strtolower($this->paramedis_id),true);
		$criteria->compare('LOWER(catatanimunisasi)',strtolower($this->catatanimunisasi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
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
        
        public function getParamedisItems()
        {
            return ParamedisV::model()->findAll('ruangan_id='.Yii::app()->user->getState('ruangan_id').' ORDER BY nama_pegawai');
        }
        
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
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
        
        public function getStatusImunisasiItems()
        {
            return StatusimunisasiM::model()->findAll('statusimunisasi_aktif=TRUE ORDER BY statusimunisasi_kode');
        }
        
        public function getJadwalImunisasiItems()
        {
            return JadwalimunisasiM::model()->findAll('jadwalimunisasi_aktif=TRUE ORDER BY jenisimunisasi');
        }
        
        public function getDiagnosaItems()
        {
            return DiagnosaM::model()->findAll('diagnosa_aktif=TRUE ORDER BY diagnosa_nama');
        }
        
        public function getTglImunisaniNoPendaftaran() {                         
            return $this->tglimunisasi.PHP_EOL.'<br/>'.$this->pendaftaran->no_pendaftaran;
        }
        

}