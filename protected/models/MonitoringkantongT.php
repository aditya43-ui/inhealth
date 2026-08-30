<?php

/**
 * @author Tantowy <tantowijaya@.com>
 * This is the model class for table "monitoringkantong_t".
 *
 * The followings are the available columns in table 'monitoringkantong_t':
 * @property integer $monitoringkantong_id
 * @property string $tglmonitoring
 * @property string $jammonitoring
 * @property integer $monitoring_ke
 * @property double $suhu_monitoring
 * @property string $kosongtanpalistrik
 * @property string $kosongdenganlistrik
 * @property string $listrikdanicepack
 * @property string $mulaiisikantong
 * @property string $setelahdiisikantong
 * @property string $lepaslistrik
 * @property string $observasi15mnt
 * @property integer $petugasmonitoring_id
 * @property string $ket_monitoring
 * @property integer $coolboxdarah_id
 * @property integer $kirimkantongdarah_id
 * @property string $kirimkelabitd
 * @property string $sampaidilabitd
 * The followings are the available model relations:
 * @property TerimakantongdarahT[] $terimakantongdarahTs
 * @property CoolboxdarahM $coolboxdarah
 * @property KirimkantongdarahT $kirimkantongdarah
 */
class MonitoringkantongT extends CActiveRecord
{
	public $ruangan_id,$petugasmonitoring_nama, $jam_monitoring;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringkantongT the static model class
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
		return 'monitoringkantong_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglmonitoring, jammonitoring, monitoring_ke, coolboxdarah_id', 'required'),
			array('monitoring_ke, petugasmonitoring_id, coolboxdarah_id, kirimkantongdarah_id', 'numerical', 'integerOnly'=>true),
			array('suhu_monitoring', 'numerical'),
			array('kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, kirimkelabitd, sampaidilabitd', 'length', 'max'=>100),
			array('ket_monitoring,kosongtanpalistrik_suhu,kosongdenganlistrik_suhu,listrikdanicepack_suhu,mulaiisikantong_suhu,setelahdiisikantong_suhu,lepaslistrik_suhu,kirimkelabitd_suhu,sampaidilabitd_suhu', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringkantong_id, tglmonitoring, jammonitoring, monitoring_ke, suhu_monitoring, kosongtanpalistrik, kosongdenganlistrik, listrikdanicepack, mulaiisikantong, setelahdiisikantong, lepaslistrik, observasi15mnt, petugasmonitoring_id, ket_monitoring, coolboxdarah_id, kirimkantongdarah_id, kirimkelabitd, sampaidilabitd', 'safe', 'on'=>'search'),
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
			'terimakantongdarahTs' => array(self::HAS_MANY, 'TerimakantongdarahT', 'monitoringkantong_id'),
			'coolboxdarah' => array(self::BELONGS_TO, 'CoolboxdarahM', 'coolboxdarah_id'),
			'kirimkantongdarah' => array(self::BELONGS_TO, 'KirimkantongdarahT', 'kirimkantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringkantong_id' => 'Monitoringkantong',
			'tglmonitoring' => 'Tglmonitoring',
			'jammonitoring' => 'Jammonitoring',
			'monitoring_ke' => 'Monitoring Ke',
			'suhu_monitoring' => 'Suhu Monitoring',
			'kosongtanpalistrik' => 'Kosongtanpalistrik',
			'kosongdenganlistrik' => 'Kosongdenganlistrik',
			'listrikdanicepack' => 'Listrikdanicepack',
			'mulaiisikantong' => 'Mulaiisikantong',
			'setelahdiisikantong' => 'Setelahdiisikantong',
			'lepaslistrik' => 'Lepaslistrik',
			'observasi15mnt' => 'Observasi15mnt',
			'petugasmonitoring_id' => 'Petugasmonitoring',
			'ket_monitoring' => 'Ket Monitoring',
			'coolboxdarah_id' => 'Coolboxdarah',
			'kirimkantongdarah_id' => 'Kirimkantongdarah',
			'kirimkelabitd' => 'Kirimkelabitd',
			'sampaidilabitd' => 'Sampaidilabitd',
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

		if(!empty($this->monitoringkantong_id)){
			$criteria->addCondition('monitoringkantong_id = '.$this->monitoringkantong_id);
		}
		$criteria->compare('LOWER(tglmonitoring)',strtolower($this->tglmonitoring),true);
		$criteria->compare('LOWER(jammonitoring)',strtolower($this->jammonitoring),true);
		if(!empty($this->monitoring_ke)){
			$criteria->addCondition('monitoring_ke = '.$this->monitoring_ke);
		}
		$criteria->compare('suhu_monitoring',$this->suhu_monitoring);
		$criteria->compare('LOWER(kosongtanpalistrik)',strtolower($this->kosongtanpalistrik),true);
		$criteria->compare('LOWER(kosongdenganlistrik)',strtolower($this->kosongdenganlistrik),true);
		$criteria->compare('LOWER(listrikdanicepack)',strtolower($this->listrikdanicepack),true);
		$criteria->compare('LOWER(mulaiisikantong)',strtolower($this->mulaiisikantong),true);
		$criteria->compare('LOWER(setelahdiisikantong)',strtolower($this->setelahdiisikantong),true);
		$criteria->compare('LOWER(lepaslistrik)',strtolower($this->lepaslistrik),true);
		$criteria->compare('LOWER(observasi15mnt)',strtolower($this->observasi15mnt),true);
		if(!empty($this->petugasmonitoring_id)){
			$criteria->addCondition('petugasmonitoring_id = '.$this->petugasmonitoring_id);
		}
		$criteria->compare('LOWER(ket_monitoring)',strtolower($this->ket_monitoring),true);
		if(!empty($this->coolboxdarah_id)){
			$criteria->addCondition('coolboxdarah_id = '.$this->coolboxdarah_id);
		}
		if(!empty($this->kirimkantongdarah_id)){
			$criteria->addCondition('kirimkantongdarah_id = '.$this->kirimkantongdarah_id);
		}
		$criteria->compare('LOWER(kirimkelabitd)',strtolower($this->kirimkelabitd),true);
		$criteria->compare('LOWER(sampaidilabitd)',strtolower($this->sampaidilabitd),true);

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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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