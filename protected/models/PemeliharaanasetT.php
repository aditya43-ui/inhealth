<?php

/**
 * This is the model class for table "pemeliharaanaset_t".
 *
 * The followings are the available columns in table 'pemeliharaanaset_t':
 * @property integer $pemeliharaanaset_id
 * @property string $pemeliharaanaset_no
 * @property string $pemeliharaanaset_tgl
 * @property string $pemeliharaanaset_ket
 * @property integer $pegmengetahui_id
 * @property integer $pegpetugas1_id
 * @property integer $pegpetugas2_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PemeliharaanasetT extends CActiveRecord
{
        public $waktuCek;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeliharaanasetT the static model class
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
		return 'pemeliharaanaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeliharaanaset_no, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegmengetahui_id, pegpetugas1_id, pegpetugas2_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pemeliharaanaset_no', 'length', 'max'=>20),
			array('pemeliharaanaset_tgl, pemeliharaanaset_ket, update_time, waktuCek', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeliharaanaset_id, pemeliharaanaset_no, pemeliharaanaset_tgl, pemeliharaanaset_ket, pegmengetahui_id, pegpetugas1_id, pegpetugas2_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegmengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegmengetahui_id'),
			'pegpetugas1' => array(self::BELONGS_TO, 'PegawaiM', 'pegpetugas1_id'),
			'pegpetugas2' => array(self::BELONGS_TO, 'PegawaiM', 'pegpetugas2_id'),	
            'asalaset' => array(self::BELONGS_TO, 'AsalasetM', 'asalaset_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeliharaanaset_id' => 'Pemeliharaanaset',
			'pemeliharaanaset_no' => 'No. Pemeliharaan',
			'pemeliharaanaset_tgl' => 'Tanggal Pemeliharaan',
			'pemeliharaanaset_ket' => 'Keterangan',
			'pegmengetahui_id' => 'Mengetahui',
			'pegpetugas1_id' => 'Petugas 1',
			'pegpetugas2_id' => 'Petugas 2',
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

		if(!empty($this->pemeliharaanaset_id)){
			$criteria->addCondition('pemeliharaanaset_id = '.$this->pemeliharaanaset_id);
		}
		$criteria->compare('LOWER(pemeliharaanaset_no)',strtolower($this->pemeliharaanaset_no),true);
		$criteria->compare('LOWER(pemeliharaanaset_tgl)',strtolower($this->pemeliharaanaset_tgl),true);
		$criteria->compare('LOWER(pemeliharaanaset_ket)',strtolower($this->pemeliharaanaset_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpetugas1_id)){
			$criteria->addCondition('pegpetugas1_id = '.$this->pegpetugas1_id);
		}
		if(!empty($this->pegpetugas2_id)){
			$criteria->addCondition('pegpetugas2_id = '.$this->pegpetugas2_id);
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