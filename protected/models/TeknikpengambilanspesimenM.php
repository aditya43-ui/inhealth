<?php

/**
 * This is the model class for table "teknikpengambilanspesimen_m".
 *
 * The followings are the available columns in table 'teknikpengambilanspesimen_m':
 * @property integer $teknikpengambilanspesimen_id
 * @property string $teknikpengambilanspesimen_nama
 * @property string $teknikpengambilanspesimen_namalainnya
 * @property boolean $teknikpengambilanspesimen_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class TeknikpengambilanspesimenM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TeknikpengambilanspesimenM the static model class
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
		return 'teknikpengambilanspesimen_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('teknikpengambilanspesimen_nama', 'length', 'max'=>200),
			array('teknikpengambilanspesimen_namalainnya', 'length', 'max'=>300),
			array('teknikpengambilanspesimen_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('teknikpengambilanspesimen_id, teknikpengambilanspesimen_nama, teknikpengambilanspesimen_namalainnya, teknikpengambilanspesimen_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'teknikpengambilanspesimen_id' => 'Teknikpengambilanspesimen',
			'teknikpengambilanspesimen_nama' => 'Teknikpengambilanspesimen Nama',
			'teknikpengambilanspesimen_namalainnya' => 'Teknikpengambilanspesimen Namalainnya',
			'teknikpengambilanspesimen_aktif' => 'Teknikpengambilanspesimen Aktif',
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

		if(!empty($this->teknikpengambilanspesimen_id)){
			$criteria->addCondition('teknikpengambilanspesimen_id = '.$this->teknikpengambilanspesimen_id);
		}
		$criteria->compare('LOWER(teknikpengambilanspesimen_nama)',strtolower($this->teknikpengambilanspesimen_nama),true);
		$criteria->compare('LOWER(teknikpengambilanspesimen_namalainnya)',strtolower($this->teknikpengambilanspesimen_namalainnya),true);
		$criteria->compare('teknikpengambilanspesimen_aktif',$this->teknikpengambilanspesimen_aktif);
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