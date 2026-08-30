<?php

/**
 * This is the model class for table "monitoringgiziranap_t".
 *
 * The followings are the available columns in table 'monitoringgiziranap_t':
 * @property integer $monitoringgiziranap_id
 * @property integer $asesmengizi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $instalasi_id
 * @property string $tglmonitoringgizi
 * @property string $dietintake
 * @property string $fisik_klinis
 * @property string $rencanapenatalaksanaan_diet
 * @property string $catatanperkembangan
 * @property integer $ahligiziranap_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property AsesmengiziT $asesmengizi
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property InstalasiM $instalasi
 */
class MonitoringgiziranapT extends CActiveRecord
{
    public $ahligizi_nama;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringgiziranapT the static model class
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
		return 'monitoringgiziranap_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmengizi_id, pendaftaran_id, pasien_id, pasienadmisi_id, instalasi_id, tglmonitoringgizi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('asesmengizi_id, pendaftaran_id, pasien_id, pasienadmisi_id, instalasi_id, ahligiziranap_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dietintake, fisik_klinis, rencanapenatalaksanaan_diet, catatanperkembangan', 'length', 'max'=>300),
			array('update_time, update_loginpemakai_id, antropometri, laboratorium, lainlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringgiziranap_id, asesmengizi_id, pendaftaran_id, pasien_id, pasienadmisi_id, instalasi_id, tglmonitoringgizi, dietintake, fisik_klinis, rencanapenatalaksanaan_diet, catatanperkembangan, ahligiziranap_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, antropometri, laboratorium, lainlain', 'safe', 'on'=>'search'),
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
			'asesmengizi' => array(self::BELONGS_TO, 'AsesmengiziT', 'asesmengizi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
            'ahligizi' => array(self::BELONGS_TO, 'PegawaiM', 'ahligiziranap_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringgiziranap_id' => 'Monitoringgiziranap',
			'asesmengizi_id' => 'Asesmengizi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'instalasi_id' => 'Instalasi',
			'tglmonitoringgizi' => 'Tgl. Monitoring',
			'dietintake' => 'Diet Intake',
			'fisik_klinis' => 'Fisik Klinis',
			'rencanapenatalaksanaan_diet' => 'Rencana Penatalaksanaan Diet',
			'catatanperkembangan' => 'Catatan Perkembangan',
			'antropometri' => 'Antropometri',
			'laboratorium' => 'Laboratorium',
			'lainlain' => 'Lain-lain',
			'ahligiziranap_id' => 'Ahli Gizi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->monitoringgiziranap_id)){
			$criteria->addCondition('monitoringgiziranap_id = '.$this->monitoringgiziranap_id);
		}
		if(!empty($this->asesmengizi_id)){
			$criteria->addCondition('asesmengizi_id = '.$this->asesmengizi_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(tglmonitoringgizi)',strtolower($this->tglmonitoringgizi),true);
		$criteria->compare('LOWER(dietintake)',strtolower($this->dietintake),true);
		$criteria->compare('LOWER(fisik_klinis)',strtolower($this->fisik_klinis),true);
		$criteria->compare('LOWER(rencanapenatalaksanaan_diet)',strtolower($this->rencanapenatalaksanaan_diet),true);
		$criteria->compare('LOWER(catatanperkembangan)',strtolower($this->catatanperkembangan),true);
		if(!empty($this->ahligiziranap_id)){
			$criteria->addCondition('ahligiziranap_id = '.$this->ahligiziranap_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}