<?php

/**
 * This is the model class for table "distribusidarahdet_t".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 *
 * The followings are the available columns in table 'distribusidarahdet_t':
 * @property integer $distribusidarahdet_id
 * @property integer $distribusidarah_id
 * @property integer $komponendarah_id
 * @property integer $terimadistribusidarah_id
 * @property integer $jeniskantongdarah_id
 * @property string $nomorbarcode
 * @property string $golongan_darah
 * @property string $rhesus
 */
class DistribusidarahdetT extends CActiveRecord
{
    public $checklist;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DistribusidarahdetT the static model class
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
		return 'distribusidarahdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('distribusidarah_id, komponendarah_id, terimadistribusidarah_id, jeniskantongdarah_id', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode, rhesus', 'length', 'max'=>50),
			array('golongan_darah', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('distribusidarahdet_id, distribusidarah_id, komponendarah_id, terimadistribusidarah_id, jeniskantongdarah_id, nomorbarcode, golongan_darah, rhesus', 'safe', 'on'=>'search'),
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
			'distribusidarahdet_id' => 'Distribusidarahdet',
			'distribusidarah_id' => 'Distribusidarah',
			'komponendarah_id' => 'Komponendarah',
			'terimadistribusidarah_id' => 'Terimadistribusidarah',
			'jeniskantongdarah_id' => 'Jeniskantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'golongan_darah' => 'Golongan Darah',
			'rhesus' => 'Rhesus',
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

		if(!empty($this->distribusidarahdet_id)){
			$criteria->addCondition('distribusidarahdet_id = '.$this->distribusidarahdet_id);
		}
		if(!empty($this->distribusidarah_id)){
			$criteria->addCondition('distribusidarah_id = '.$this->distribusidarah_id);
		}
		if(!empty($this->komponendarah_id)){
			$criteria->addCondition('komponendarah_id = '.$this->komponendarah_id);
		}
		if(!empty($this->terimadistribusidarah_id)){
			$criteria->addCondition('terimadistribusidarah_id = '.$this->terimadistribusidarah_id);
		}
		if(!empty($this->jeniskantongdarah_id)){
			$criteria->addCondition('jeniskantongdarah_id = '.$this->jeniskantongdarah_id);
		}
		$criteria->compare('LOWER(nomorbarcode)',strtolower($this->nomorbarcode),true);
		$criteria->compare('LOWER(golongan_darah)',strtolower($this->golongan_darah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);

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