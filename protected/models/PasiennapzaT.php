<?php

/**
 * This is the model class for table "pasiennapza_t".
 *
 * The followings are the available columns in table 'pasiennapza_t':
 * @property integer $pasiennapza_id
 * @property integer $detailnapza_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglperiksanapza
 * @property integer $kunjunganke
 * @property string $metodenapza
 * @property string $keteranganmetode
 * @property string $hasilpemeriksaannapza
 * @property string $catatannapza
 * @property integer $lamarehabilitasi
 * @property string $satuanlama
 * @property integer $paramedis_id
 * @property integer $dokter_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class PasiennapzaT extends CActiveRecord
{
        public $diagnosa_nama;
        public $tgl_awal;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasiennapzaT the static model class
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
		return 'pasiennapza_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id,jml_kunjungan, pasien_id, tglperiksanapza, metodenapza', 'required'),
			array('detailnapza_id, pendaftaran_id, pasien_id, kunjunganke, lamarehabilitasi, paramedis_id, dokter_id', 'numerical', 'integerOnly'=>true),
			array('metodenapza', 'length', 'max'=>50),
			array('satuanlama', 'length', 'max'=>20),
			array('keteranganmetode, hasilpemeriksaannapza, catatannapza, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasiennapza_id, ruangan,detailnapza_id, pendaftaran_id, pasien_id, tglperiksanapza, kunjunganke, metodenapza, keteranganmetode, hasilpemeriksaannapza, catatannapza, lamarehabilitasi, satuanlama, paramedis_id, dokter_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::HAS_MANY, 'PendaftaranT', 'ruangan_id'),
			'paramedis' => array(self::BELONGS_TO, 'PegawaiM', 'paramedis_id'),
                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jml_kunjungan' => 'Kunjungan ke ',
			'pasiennapza_id' => 'ID Pasien Napza',
			'detailnapza_id' => 'ID detail Napza',
			'pendaftaran_id' => 'ID Pendaftaran',
			'pasien_id' => 'ID Pasien',
			'tglperiksanapza' => 'Tanggal Periksa Napza',
			'kunjunganke' => 'Kunjungan Ke',
			'metodenapza' => 'Metode Napza',
			'keteranganmetode' => 'Keterangan Metode',
			'hasilpemeriksaannapza' => 'Hasil Pemeriksaan Napza',
			'catatannapza' => 'Catatan Napza',
			'lamarehabilitasi' => 'Lama Rehabilitasi',
			'satuanlama' => 'Satuan Lama',
			'paramedis_id' => 'Paramedis',
			'dokter_id' => 'ID Dokter',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pasiennapza_id',$this->pasiennapza_id);
		$criteria->compare('detailnapza_id',$this->detailnapza_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('COUNT(jml_kunjungan)',$this->pendaftaran_id->ruangan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('DATE(tglperiksanapza)',strtolower($this->tglperiksanapza),true);
		$criteria->compare('kunjunganke',$this->kunjunganke);
		$criteria->compare('LOWER(metodenapza)',strtolower($this->metodenapza),true);
		$criteria->compare('LOWER(keteranganmetode)',strtolower($this->keteranganmetode),true);
		$criteria->compare('LOWER(hasilpemeriksaannapza)',strtolower($this->hasilpemeriksaannapza),true);
		$criteria->compare('LOWER(catatannapza)',strtolower($this->catatannapza),true);
		$criteria->compare('lamarehabilitasi',$this->lamarehabilitasi);
		$criteria->compare('LOWER(satuanlama)',strtolower($this->satuanlama),true);
		$criteria->compare('paramedis_id',$this->paramedis_id);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pasiennapza_id',$this->pasiennapza_id);
		$criteria->compare('detailnapza_id',$this->detailnapza_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglperiksanapza)',strtolower($this->tglperiksanapza),true);
		$criteria->compare('kunjunganke',$this->kunjunganke);
		$criteria->compare('LOWER(metodenapza)',strtolower($this->metodenapza),true);
		$criteria->compare('LOWER(keteranganmetode)',strtolower($this->keteranganmetode),true);
		$criteria->compare('LOWER(hasilpemeriksaannapza)',strtolower($this->hasilpemeriksaannapza),true);
		$criteria->compare('LOWER(catatannapza)',strtolower($this->catatannapza),true);
		$criteria->compare('lamarehabilitasi',$this->lamarehabilitasi);
		$criteria->compare('LOWER(satuanlama)',strtolower($this->satuanlama),true);
		$criteria->compare('paramedis_id',$this->paramedis_id);
		$criteria->compare('dokter_id',$this->dokter_id);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
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

        public function beforeSave() {         
            if($this->tglperiksanapza===null || trim($this->tglperiksanapza)==''){
	        $this->setAttribute('tglperiksanapza', null);
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
         public function getRuangan()
        {
        	$criteria = new CDbCriteria();
        	$criteria->select='count(pendaftaran_id) as jumlah_kunjungan';
        	$criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));

        	$pendaftaran = PendaftaranT::model()->findAll($criteria);
        	return $pendaftaran->jumlah_kunjungan;
            // return PendaftaranT::model()->findAll('COUNT("ruangan_id") as Jumlah_kunjungan');
        }
}