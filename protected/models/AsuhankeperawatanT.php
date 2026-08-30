<?php

/**
 * This is the model class for table "asuhankeperawatan_t".
 *
 * The followings are the available columns in table 'asuhankeperawatan_t':
 * @property integer $asuhankeperawatan_id
 * @property integer $diagnosa_id
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property integer $shift_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $diagnosakeperawatan_id
 * @property string $tglaskep
 * @property string $evaluasi_subjektif
 * @property string $evaluasi_objektif
 * @property string $tglassesment
 * @property string $evaluasi_assesment
 * @property string $askep_tujuan
 * @property string $askep_kriteriahasil
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class AsuhankeperawatanT extends CActiveRecord
{
        public $paramedis_nama;
        public $dokter_nama;
        public $diagnosa_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuhankeperawatanT the static model class
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
		return 'asuhankeperawatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pegawai_id, shift_id, pendaftaran_id, pasien_id, diagnosakeperawatan_id, tglaskep, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('diagnosa_id, ruangan_id, pegawai_id, shift_id, pasienadmisi_id, pendaftaran_id, pasien_id, diagnosakeperawatan_id', 'numerical', 'integerOnly'=>true),
			array('evaluasi_assesment', 'length', 'max'=>50),
			array('paramedis_nama, evaluasi_subjektif, evaluasi_objektif, tglassesment, askep_tujuan, askep_kriteriahasil, update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asuhankeperawatan_id, diagnosa_id, ruangan_id, pegawai_id, shift_id, pasienadmisi_id, pendaftaran_id, pasien_id, diagnosakeperawatan_id, tglaskep, evaluasi_subjektif, evaluasi_objektif, tglassesment, evaluasi_assesment, askep_tujuan, askep_kriteriahasil, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'diagnosakeperawatan'=>array(self::BELONGS_TO, 'DiagnosakeperawatanM', 'diagnosakeperawatan_id'),
			'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien'=>array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asuhankeperawatan_id' => 'Asuhan Keperawatan',
			'diagnosa_id' => 'Diagnosa',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'shift_id' => 'Shift',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'diagnosakeperawatan_id' => 'Diagnosa Keperawatan',
			'tglaskep' => 'Tanggal Askep',
			'evaluasi_subjektif' => 'Evaluasi Subjektif',
			'evaluasi_objektif' => 'Evaluasi Objektif',
			'tglassesment' => 'Tanggal Assesment',
			'evaluasi_assesment' => 'Evaluasi Assesment',
			'askep_tujuan' => 'Askep Tujuan',
			'askep_kriteriahasil' => 'Askep Kriteria Hasil',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
                        'paramedis_nama'=>'Nama Paramedis',
                        'dokter_nama'=>'Nama Dokter',
                        'diagnosa_nama'=>'Diagnosa',
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

		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('datet(tglaskep)',strtolower($this->tglaskep),true);
		$criteria->compare('LOWER(evaluasi_subjektif)',strtolower($this->evaluasi_subjektif),true);
		$criteria->compare('LOWER(evaluasi_objektif)',strtolower($this->evaluasi_objektif),true);
		$criteria->compare('LOWER(tglassesment)',strtolower($this->tglassesment),true);
		$criteria->compare('LOWER(evaluasi_assesment)',strtolower($this->evaluasi_assesment),true);
		$criteria->compare('LOWER(askep_tujuan)',strtolower($this->askep_tujuan),true);
		$criteria->compare('LOWER(askep_kriteriahasil)',strtolower($this->askep_kriteriahasil),true);
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
		$criteria->compare('asuhankeperawatan_id',$this->asuhankeperawatan_id);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('LOWER(tglaskep)',strtolower($this->tglaskep),true);
		$criteria->compare('LOWER(evaluasi_subjektif)',strtolower($this->evaluasi_subjektif),true);
		$criteria->compare('LOWER(evaluasi_objektif)',strtolower($this->evaluasi_objektif),true);
		$criteria->compare('LOWER(tglassesment)',strtolower($this->tglassesment),true);
		$criteria->compare('LOWER(evaluasi_assesment)',strtolower($this->evaluasi_assesment),true);
		$criteria->compare('LOWER(askep_tujuan)',strtolower($this->askep_tujuan),true);
		$criteria->compare('LOWER(askep_kriteriahasil)',strtolower($this->askep_kriteriahasil),true);
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
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglaskep===null || trim($this->tglaskep)==''){
	        $this->setAttribute('tglaskep', null);
            }
            if($this->tglassesment===null || trim($this->tglassesment)==''){
	        $this->setAttribute('tglassesment', null);
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