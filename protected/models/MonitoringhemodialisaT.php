<?php

/**
 * This is the model class for table "monitoringhemodialisa_t".
 *
 * The followings are the available columns in table 'monitoringhemodialisa_t':
 * @property integer $monitoringhemodialisa_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $jam_monitoring
 * @property double $qb_nilai
 * @property double $vp_nilai
 * @property double $ap_nilai
 * @property double $qd_nilai
 * @property double $tmp_nilai
 * @property integer $td_sistolic
 * @property integer $td_diastolic
 * @property integer $nadi
 * @property double $suhutubuh
 * @property double $uf_nilai
 * @property string $catatan_monitoring
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
 */
class MonitoringhemodialisaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringhemodialisaT the static model class
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
		return 'monitoringhemodialisa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jam_monitoring, pasien_id, pendaftaran_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, td_sistolic, td_diastolic, nadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('qb_nilai, vp_nilai, ap_nilai, qd_nilai, tmp_nilai, suhutubuh, uf_nilai', 'numerical'),
			array('catatan_monitoring, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringhemodialisa_id, pasien_id, pendaftaran_id, pasienadmisi_id, jam_monitoring, qb_nilai, vp_nilai, ap_nilai, qd_nilai, tmp_nilai, td_sistolic, td_diastolic, nadi, suhutubuh, uf_nilai, catatan_monitoring, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringhemodialisa_id' => 'Monitoringhemodialisa',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'jam_monitoring' => 'Jam',
			'qb_nilai' => 'QB',
			'vp_nilai' => 'VP',
			'ap_nilai' => 'AP',
			'qd_nilai' => 'QD',
			'tmp_nilai' => 'TMP',
			'td_sistolic' => 'Tekanan Darah',
			'td_diastolic' => 'Td Diastolic',
			'nadi' => 'Nadi',
			'suhutubuh' => 'Suhu',
			'uf_nilai' => 'UF',
			'catatan_monitoring' => 'Catatan',
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

		if(!empty($this->monitoringhemodialisa_id)){
			$criteria->addCondition('monitoringhemodialisa_id = '.$this->monitoringhemodialisa_id);
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
		$criteria->compare('LOWER(jam_monitoring)',strtolower($this->jam_monitoring),true);
		$criteria->compare('qb_nilai',$this->qb_nilai);
		$criteria->compare('vp_nilai',$this->vp_nilai);
		$criteria->compare('ap_nilai',$this->ap_nilai);
		$criteria->compare('qd_nilai',$this->qd_nilai);
		$criteria->compare('tmp_nilai',$this->tmp_nilai);
		if(!empty($this->td_sistolic)){
			$criteria->addCondition('td_sistolic = '.$this->td_sistolic);
		}
		if(!empty($this->td_diastolic)){
			$criteria->addCondition('td_diastolic = '.$this->td_diastolic);
		}
		if(!empty($this->nadi)){
			$criteria->addCondition('nadi = '.$this->nadi);
		}
		$criteria->compare('suhutubuh',$this->suhutubuh);
		$criteria->compare('uf_nilai',$this->uf_nilai);
		$criteria->compare('LOWER(catatan_monitoring)',strtolower($this->catatan_monitoring),true);
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