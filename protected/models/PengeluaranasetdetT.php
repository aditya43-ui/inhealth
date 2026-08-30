<?php

/**
 * This is the model class for table "pengeluaranasetdet_t".
 *
 * The followings are the available columns in table 'pengeluaranasetdet_t':
 * @property integer $pengeluaranasetdet_id
 * @property integer $pengeluaranaset_id
 * @property integer $invperalatan_id
 */
class PengeluaranasetdetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengeluaranasetdetT the static model class
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
		return 'pengeluaranasetdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengeluaranaset_id, invperalatan_id', 'required'),
			array('pengeluaranaset_id, invperalatan_id', 'numerical', 'integerOnly'=>true),
			array('ket_pengeluaranaset,pengeluaranaset_keadaan', 'safe'),
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengeluaranasetdet_id, pengeluaranaset_id, invperalatan_id', 'safe', 'on'=>'search'),
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
			'pengeluaranasetdet_id' => 'Pengeluaranasetdet',
			'pengeluaranaset_id' => 'Pengeluaranaset',
			'invperalatan_id' => 'Invperalatan',
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

		if(!empty($this->pengeluaranasetdet_id)){
			$criteria->addCondition('pengeluaranasetdet_id = '.$this->pengeluaranasetdet_id);
		}
		if(!empty($this->pengeluaranaset_id)){
			$criteria->addCondition('pengeluaranaset_id = '.$this->pengeluaranaset_id);
		}
		if(!empty($this->invperalatan_id)){
			$criteria->addCondition('invperalatan_id = '.$this->invperalatan_id);
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