<?php

/**
 * This is the model class for table "lappenjualanresep_r".
 *
 * The followings are the available columns in table 'lappenjualanresep_r':
 * @property integer $lappenjualanresep_id
 * @property string $tanggal
 * @property integer $penjualanresep
 * @property integer $penjualanresepluar
 * @property integer $penjualanbebas
 * @property integer $penjualandokter
 * @property integer $penjualankaryawan
 */
class LappenjualanresepR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LappenjualanresepR the static model class
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
		return 'lappenjualanresep_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penjualanresep, penjualanresepluar, penjualanbebas, penjualandokter, penjualankaryawan', 'numerical', 'integerOnly'=>true),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lappenjualanresep_id, tanggal, penjualanresep, penjualanresepluar, penjualanbebas, penjualandokter, penjualankaryawan', 'safe', 'on'=>'search'),
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
			'lappenjualanresep_id' => 'Lappenjualanresep',
			'tanggal' => 'Tanggal',
			'penjualanresep' => 'Penjualanresep',
			'penjualanresepluar' => 'Penjualanresepluar',
			'penjualanbebas' => 'Penjualanbebas',
			'penjualandokter' => 'Penjualandokter',
			'penjualankaryawan' => 'Penjualankaryawan',
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

		if(!empty($this->lappenjualanresep_id)){
			$criteria->addCondition('lappenjualanresep_id = '.$this->lappenjualanresep_id);
		}
		$criteria->compare('LOWER(tanggal)',strtolower($this->tanggal),true);
		if(!empty($this->penjualanresep)){
			$criteria->addCondition('penjualanresep = '.$this->penjualanresep);
		}
		if(!empty($this->penjualanresepluar)){
			$criteria->addCondition('penjualanresepluar = '.$this->penjualanresepluar);
		}
		if(!empty($this->penjualanbebas)){
			$criteria->addCondition('penjualanbebas = '.$this->penjualanbebas);
		}
		if(!empty($this->penjualandokter)){
			$criteria->addCondition('penjualandokter = '.$this->penjualandokter);
		}
		if(!empty($this->penjualankaryawan)){
			$criteria->addCondition('penjualankaryawan = '.$this->penjualankaryawan);
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