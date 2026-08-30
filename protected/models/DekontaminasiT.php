<?php

/**
 * This is the model class for table "dekontaminasi_t".
 *
 * The followings are the available columns in table 'dekontaminasi_t':
 * @property integer $dekontaminasi_id
 * @property string $dekontaminasi_no
 * @property string $dekontaminasi_tgl
 * @property string $dekontaminasi_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegpetugas_id
 * @property boolean $issterilisasi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class DekontaminasiT extends CActiveRecord
{
    public $pegpetugas_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DekontaminasiT the static model class
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
		return 'dekontaminasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dekontaminasi_no, dekontaminasi_tgl, pegpetugas_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegmengetahui_id, pegpetugas_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dekontaminasi_no', 'length', 'max'=>20),
			array('dekontaminasi_ket', 'length', 'max'=>500),
			array('issterilisasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('dekontaminasi_id, dekontaminasi_no, dekontaminasi_tgl, dekontaminasi_ket, pegmengetahui_id, pegpetugas_id, issterilisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegpetugas'=>array(self::BELONGS_TO,'PegawaiM','pegpetugas_id'),
			'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dekontaminasi_id' => 'ID Dekontaminasi',
			'dekontaminasi_no' => 'No. Dekontaminasi',
			'dekontaminasi_tgl' => 'Tanggal Dekontaminasi',
			'dekontaminasi_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Pegawai Mengetahui',
			'pegpetugas_id' => 'Pegawai Dekontaminasi',
			'issterilisasi' => 'Issterilisasi',
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

		if(!empty($this->dekontaminasi_id)){
			$criteria->addCondition('dekontaminasi_id = '.$this->dekontaminasi_id);
		}
		$criteria->compare('LOWER(dekontaminasi_no)',strtolower($this->dekontaminasi_no),true);
		$criteria->compare('LOWER(dekontaminasi_tgl)',strtolower($this->dekontaminasi_tgl),true);
		$criteria->compare('LOWER(dekontaminasi_ket)',strtolower($this->dekontaminasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpetugas_id)){
			$criteria->addCondition('pegpetugas_id = '.$this->pegpetugas_id);
		}
		$criteria->compare('issterilisasi',$this->issterilisasi);
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