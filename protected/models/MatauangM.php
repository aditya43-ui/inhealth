<?php

/**
 * This is the model class for table "matauang_m".
 *
 * The followings are the available columns in table 'matauang_m':
 * @property integer $matauang_id
 * @property string $matauang
 * @property string $singkatan
 * @property boolean $matauang_aktif
 */
class MatauangM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MatauangM the static model class
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
		return 'matauang_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('matauang, singkatan', 'required'),
			array('matauang, singkatan', 'length', 'max'=>50),
			array('matauang_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('matauang_id, matauang, singkatan, matauang_aktif', 'safe', 'on'=>'search'),
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
			'matauang_id' => 'ID Mata Uang',
			'matauang' => 'Mata Uang',
			'singkatan' => 'Singkatan',
			'matauang_aktif' => 'Mata Uang Aktif',
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

		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
//		if(!empty($this->matauang)){
//		   $criteria->addCondition("matauang = ".$this->matauang);
//		}		
		$criteria->compare('LOWER(singkatan)',strtolower($this->singkatan),true);
		$criteria->compare('matauang_aktif',isset($this->matauang_aktif)?$this->matauang_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
//		if(!empty($this->matauang)){
//		   $criteria->addCondition("matauang = ".$this->matauang);
//		}		
		$criteria->compare('LOWER(singkatan)',strtolower($this->singkatan),true);
		$criteria->compare('matauang_aktif',isset($this->matauang_aktif)?$this->matauang_aktif:true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function items()
        {
            $models = self::model()->findAll(
                array(
                    'condition'=>'matauang_aktif = true',
                    'order'=>'matauang',
                )
            );
            $result = array();
            foreach($models as $model){
                $result[$model->matauang_id] = $model->matauang;
            }
            return $result;
        }   
		
		
}