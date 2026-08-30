<?php

/**
 * This is the model class for table "jenisspesimen_pa_m".
 *
 * The followings are the available columns in table 'jenisspesimen_pa_m':
 * @property integer $jenisspesimen_pa_id
 * @property string $jenisspesimen_pa_nama
 * @property string $jenisspesimen_pa_namalainnya
 * @property boolean $jenisspesimen_pa_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class JenisspesimenPaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisspesimenPaM the static model class
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
		return 'jenisspesimen_pa_m';
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
			array('jenisspesimen_pa_nama', 'length', 'max'=>200),
			array('jenisspesimen_pa_namalainnya', 'length', 'max'=>300),
			array('jenisspesimen_pa_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisspesimen_pa_id, jenisspesimen_pa_nama, jenisspesimen_pa_namalainnya, jenisspesimen_pa_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jenisspesimen_pa_id' => 'Jenisspesimen Pa',
			'jenisspesimen_pa_nama' => 'Jenisspesimen Pa Nama',
			'jenisspesimen_pa_namalainnya' => 'Jenisspesimen Pa Namalainnya',
			'jenisspesimen_pa_aktif' => 'Jenisspesimen Pa Aktif',
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

		if(!empty($this->jenisspesimen_pa_id)){
			$criteria->addCondition('jenisspesimen_pa_id = '.$this->jenisspesimen_pa_id);
		}
		$criteria->compare('LOWER(jenisspesimen_pa_nama)',strtolower($this->jenisspesimen_pa_nama),true);
		$criteria->compare('LOWER(jenisspesimen_pa_namalainnya)',strtolower($this->jenisspesimen_pa_namalainnya),true);
		$criteria->compare('jenisspesimen_pa_aktif',$this->jenisspesimen_pa_aktif);
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