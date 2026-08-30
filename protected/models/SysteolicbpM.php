<?php

/**
 * This is the model class for table "systeolicbp_m".
 *
 * The followings are the available columns in table 'systeolicbp_m':
 * @property integer $systeolicbp_id
 * @property string $jeniskelamin
 * @property string $systeolicbp_nama
 * @property integer $systeolicbp_min
 * @property integer $systeolicbp_max
 * @property integer $ifuntreated_points
 * @property integer $iftreated_points
 * @property boolean $systeolicbp_aktif
 */
class SysteolicbpM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SysteolicbpM the static model class
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
		return 'systeolicbp_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskelamin, systeolicbp_nama, systeolicbp_min, systeolicbp_max, ifuntreated_points, iftreated_points', 'required'),
			array('systeolicbp_min, systeolicbp_max, ifuntreated_points, iftreated_points', 'numerical', 'integerOnly'=>true),
			array('jeniskelamin', 'length', 'max'=>1),
			array('systeolicbp_nama', 'length', 'max'=>10),
			array('systeolicbp_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('systeolicbp_id, jeniskelamin, systeolicbp_nama, systeolicbp_min, systeolicbp_max, ifuntreated_points, iftreated_points, systeolicbp_aktif', 'safe', 'on'=>'search'),
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
			'systeolicbp_id' => 'Systeolicbp',
			'jeniskelamin' => 'Jenis Kelamin',
			'systeolicbp_nama' => 'Systeolicbp Nama',
			'systeolicbp_min' => 'Systeolicbp Min',
			'systeolicbp_max' => 'Systeolicbp Max',
			'ifuntreated_points' => 'Ifuntreated Points',
			'iftreated_points' => 'Iftreated Points',
			'systeolicbp_aktif' => 'Systeolicbp Aktif',
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

		if(!empty($this->systeolicbp_id)){
			$criteria->addCondition('systeolicbp_id = '.$this->systeolicbp_id);
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(systeolicbp_nama)',strtolower($this->systeolicbp_nama),true);
		if(!empty($this->systeolicbp_min)){
			$criteria->addCondition('systeolicbp_min = '.$this->systeolicbp_min);
		}
		if(!empty($this->systeolicbp_max)){
			$criteria->addCondition('systeolicbp_max = '.$this->systeolicbp_max);
		}
		if(!empty($this->ifuntreated_points)){
			$criteria->addCondition('ifuntreated_points = '.$this->ifuntreated_points);
		}
		if(!empty($this->iftreated_points)){
			$criteria->addCondition('iftreated_points = '.$this->iftreated_points);
		}
		$criteria->compare('systeolicbp_aktif',$this->systeolicbp_aktif);

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