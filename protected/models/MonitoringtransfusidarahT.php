<?php

/**
 * This is the model class for table "monitoringtransfusidarah_t".
 *
 * The followings are the available columns in table 'monitoringtransfusidarah_t':
 * @property integer $monitoringtransfusidarah_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $monitoring_jeniswaktu
 * @property string $monitoring_tanggal
 * @property string $monitoring_jam
 * @property integer $petugasmonitoring_id
 * @property integer $stokkantongdarah_id
 * @property string $no_kantongdarah
 * @property double $isi_kantongdarah
 * @property string $reaksi_transfusi
 * @property string $reaksidetail_transfusi
 * @property integer $ttv_tdsystolic
 * @property integer $ttv_tddiastolic
 * @property integer $ttv_nadi
 * @property integer $ttv_respirasi
 * @property double $ttv_suhutubuh
 * @property integer $ruanganmonitoring_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PegawaiM $petugasmonitoring
 */
class MonitoringtransfusidarahT extends CActiveRecord
{
    public $nama_kantong;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringtransfusidarahT the static model class
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
		return 'monitoringtransfusidarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, petugasmonitoring_id, ruanganmonitoring_id, monitoring_jeniswaktu, monitoring_tanggal, monitoring_jam, stokkantongdarah_id, isi_kantongdarah, '
                . 'ttv_tdsystolic, ttv_nadi, ttv_respirasi, ttv_suhutubuh', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, petugasmonitoring_id, stokkantongdarah_id, ttv_tdsystolic, ttv_tddiastolic, ttv_nadi, ttv_respirasi, ruanganmonitoring_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('isi_kantongdarah, ttv_suhutubuh', 'numerical'),
			array('monitoring_jeniswaktu, no_kantongdarah', 'length', 'max'=>100),
			array('reaksi_transfusi', 'length', 'max'=>20),
			array('reaksidetail_transfusi, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringtransfusidarah_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, monitoring_jeniswaktu, monitoring_tanggal, monitoring_jam, petugasmonitoring_id, stokkantongdarah_id, no_kantongdarah, isi_kantongdarah, reaksi_transfusi, reaksidetail_transfusi, ttv_tdsystolic, ttv_tddiastolic, ttv_nadi, ttv_respirasi, ttv_suhutubuh, ruanganmonitoring_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'petugasmonitoring' => array(self::BELONGS_TO, 'PegawaiM', 'petugasmonitoring_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringtransfusidarah_id' => 'Monitoringtransfusidarah',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'monitoring_jeniswaktu' => 'Jenis Waktu Monitoring',
			'monitoring_tanggal' => 'Tanggal Monitoring',
			'monitoring_jam' => 'Jam Monitoring',
			'petugasmonitoring_id' => 'Nama Perawat/Bidan',
			'stokkantongdarah_id' => 'Jenis Darah',
			'no_kantongdarah' => 'No. Kantong',
			'isi_kantongdarah' => 'Isi (ml)',
			'reaksi_transfusi' => 'Reaksi',
			'reaksidetail_transfusi' => 'Sebutkan',
			'ttv_tdsystolic' => 'Tekanan Darah',
			'ttv_tddiastolic' => 'Ttv Tddiastolic',
			'ttv_nadi' => 'Nadi',
			'ttv_respirasi' => 'RR (Respiration Rate)',
			'ttv_suhutubuh' => 'Suhu',
			'ruanganmonitoring_id' => 'Ruanganmonitoring',
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

		if(!empty($this->monitoringtransfusidarah_id)){
			$criteria->addCondition('monitoringtransfusidarah_id = '.$this->monitoringtransfusidarah_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(monitoring_jeniswaktu)',strtolower($this->monitoring_jeniswaktu),true);
		$criteria->compare('LOWER(monitoring_tanggal)',strtolower($this->monitoring_tanggal),true);
		$criteria->compare('LOWER(monitoring_jam)',strtolower($this->monitoring_jam),true);
		if(!empty($this->petugasmonitoring_id)){
			$criteria->addCondition('petugasmonitoring_id = '.$this->petugasmonitoring_id);
		}
		if(!empty($this->stokkantongdarah_id)){
			$criteria->addCondition('stokkantongdarah_id = '.$this->stokkantongdarah_id);
		}
		$criteria->compare('LOWER(no_kantongdarah)',strtolower($this->no_kantongdarah),true);
		$criteria->compare('isi_kantongdarah',$this->isi_kantongdarah);
		$criteria->compare('LOWER(reaksi_transfusi)',strtolower($this->reaksi_transfusi),true);
		$criteria->compare('LOWER(reaksidetail_transfusi)',strtolower($this->reaksidetail_transfusi),true);
		if(!empty($this->ttv_tdsystolic)){
			$criteria->addCondition('ttv_tdsystolic = '.$this->ttv_tdsystolic);
		}
		if(!empty($this->ttv_tddiastolic)){
			$criteria->addCondition('ttv_tddiastolic = '.$this->ttv_tddiastolic);
		}
		if(!empty($this->ttv_nadi)){
			$criteria->addCondition('ttv_nadi = '.$this->ttv_nadi);
		}
		if(!empty($this->ttv_respirasi)){
			$criteria->addCondition('ttv_respirasi = '.$this->ttv_respirasi);
		}
		$criteria->compare('ttv_suhutubuh',$this->ttv_suhutubuh);
		if(!empty($this->ruanganmonitoring_id)){
			$criteria->addCondition('ruanganmonitoring_id = '.$this->ruanganmonitoring_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
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