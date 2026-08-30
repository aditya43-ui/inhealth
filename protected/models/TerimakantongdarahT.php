<?php

/**
 * This is the model class for table "terimakantongdarah_t".
 *
 * The followings are the available columns in table 'terimakantongdarah_t': 
 * 
 * @package models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Rusdiyanto <rusdiyanto@.com>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * @property integer $terimakantongdarah_id
 * @property string $tglterimakantong
 * @property string $no_terimakantong
 * @property integer $ruanganterima_id
 * @property integer $petugasterima_id
 * @property integer $kirimkantongdarah_id
 * @property integer $monitoringkantong_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property double $suhu
 *
 * The followings are the available model relations:
 * @property KirimkantongdarahT $kirimkantongdarah
 * @property MonitoringkantongT $monitoringkantong
 * @property TerimakantongdetT[] $terimakantongdetTs
 * @property KirimkantongdetT[] $kirimkantongdetTs
 */
class TerimakantongdarahT extends CActiveRecord
{       
        public $jenisterima_nama;
        public $gol_darah;
        public $rhesus;
        public $ruangankirim_nama, $ruangankirim_id;
        public $nomorbarcode_sample;
        public $kantongdarahdet_id;
        public $kantongdarah_id;
        public $pendonor_id;
        public $berubahdata;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimakantongdarahT the static model class
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
		return 'terimakantongdarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglterimakantong, no_terimakantong, ruanganterima_id, petugasterima_id, kirimkantongdarah_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruanganterima_id, petugasterima_id, kirimkantongdarah_id, monitoringkantong_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('suhu', 'numerical'),
			array('no_terimakantong', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimakantongdarah_id, tglterimakantong, no_terimakantong, ruanganterima_id, petugasterima_id, kirimkantongdarah_id, monitoringkantong_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, suhu', 'safe', 'on'=>'search'),
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
			'kirimkantongdarah' => array(self::BELONGS_TO, 'KirimkantongdarahT', 'kirimkantongdarah_id'),
			'monitoringkantong' => array(self::BELONGS_TO, 'MonitoringkantongT', 'monitoringkantong_id'),
			'terimakantongdetTs' => array(self::HAS_MANY, 'TerimakantongdetT', 'terimakantongdarah_id'),
			'kirimkantongdetTs' => array(self::HAS_MANY, 'KirimkantongdetT', 'terimakantongdarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimakantongdarah_id' => 'Terimakantongdarah',
			'tglterimakantong' => 'Tgl. Penerimaan Kantong',
			'no_terimakantong' => 'No Terimakantong',
			'ruanganterima_id' => 'Ruanganterima',
			'petugasterima_id' => 'Petugas Terima',
			'kirimkantongdarah_id' => 'Kirimkantongdarah',
			'monitoringkantong_id' => 'Monitoringkantong',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'suhu' => 'Suhu',  
                        'ruangankirim_nama'=>'Ruangan Asal',
                        'nomorbarcode_sample'=>'Nomor Barcode Sample'
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

		if(!empty($this->terimakantongdarah_id)){
			$criteria->addCondition('terimakantongdarah_id = '.$this->terimakantongdarah_id);
		}
		$criteria->compare('LOWER(tglterimakantong)',strtolower($this->tglterimakantong),true);
		$criteria->compare('LOWER(no_terimakantong)',strtolower($this->no_terimakantong),true);
		if(!empty($this->ruanganterima_id)){
			$criteria->addCondition('ruanganterima_id = '.$this->ruanganterima_id);
		}
		if(!empty($this->petugasterima_id)){
			$criteria->addCondition('petugasterima_id = '.$this->petugasterima_id);
		}
		if(!empty($this->kirimkantongdarah_id)){
			$criteria->addCondition('kirimkantongdarah_id = '.$this->kirimkantongdarah_id);
		}
		if(!empty($this->monitoringkantong_id)){
			$criteria->addCondition('monitoringkantong_id = '.$this->monitoringkantong_id);
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
		$criteria->compare('suhu',$this->suhu);

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