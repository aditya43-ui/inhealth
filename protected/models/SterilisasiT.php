<?php

/**
 * This is the model class for table "sterilisasi_t".
 *
 * The followings are the available columns in table 'sterilisasi_t':
 * @property integer $sterilisasi_id
 * @property string $sterilisasi_no
 * @property string $sterilisasi_tgl
 * @property string $sterilisasi_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegsterilisasi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class SterilisasiT extends CActiveRecord
{
    public $pegsterilisasi_nama,$pegmengetahui_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SterilisasiT the static model class
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
		return 'sterilisasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sterilisasi_no, sterilisasi_tgl, pegsterilisasi_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegmengetahui_id, pegsterilisasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('sterilisasi_no', 'length', 'max'=>20),
			array('sterilisasi_ket', 'length', 'max'=>500),
			array('status_proses, update_time,sterilisasi_status,sterilisasi_siklus,tglmulaisterilisasi,tglselesaisterilisasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sterilisasi_id, sterilisasi_no, sterilisasi_tgl, sterilisasi_ket, pegmengetahui_id, pegsterilisasi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegmengetahui'=>array(self::BELONGS_TO,'PegawaiM','pegmengetahui_id'),
			'pegsterilisasi'=>array(self::BELONGS_TO,'PegawaiM','pegsterilisasi_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sterilisasi_id' => 'Sterilisasi',
			'sterilisasi_no' => 'No. Sterilisasi',
			'sterilisasi_tgl' => 'Tanggal Sterilisasi',
			'sterilisasi_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegsterilisasi_id' => 'Petugas Sterilisasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'sterilisasi_siklus' => 'Siklus Mesin / Siklus Komputer',
			'sterilisasi_status' => 'Status Proses',
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

		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(sterilisasi_no)',strtolower($this->sterilisasi_no),true);
		$criteria->compare('LOWER(sterilisasi_tgl)',strtolower($this->sterilisasi_tgl),true);
		$criteria->compare('LOWER(sterilisasi_ket)',strtolower($this->sterilisasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegsterilisasi_id)){
			$criteria->addCondition('pegsterilisasi_id = '.$this->pegsterilisasi_id);
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