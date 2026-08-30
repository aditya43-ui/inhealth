<?php

/**
 * This is the model class for table "renanggaranpenerimaandet_t".
 *
 * The followings are the available columns in table 'renanggaranpenerimaandet_t':
 * @property integer $renanggaranpenerimaandet_id
 * @property integer $renanggpenerimaan_id
 * @property integer $renanggaran_ke
 * @property string $tglrenanggaranpen
 * @property double $nilaipenerimaan
 */
class RenanggaranpenerimaandetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RenanggaranpenerimaandetT the static model class
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
		return 'renanggaranpenerimaandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('renanggpenerimaan_id, renanggaran_ke, nilaipenerimaan', 'required'),
			array('renanggpenerimaan_id, renanggaran_ke', 'numerical', 'integerOnly'=>true),
			array('nilaipenerimaan', 'numerical'),
			array('tglrenanggaranpen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('renanggaranpenerimaandet_id, renanggpenerimaan_id, renanggaran_ke, tglrenanggaranpen, nilaipenerimaan', 'safe', 'on'=>'search'),
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
			'renanggaranpenerimaandet_id' => 'Renanggaranpenerimaandet',
			'renanggpenerimaan_id' => 'Renanggpenerimaan',
			'renanggaran_ke' => 'Renanggaran Ke',
			'tglrenanggaranpen' => 'Tglrenanggaranpen',
			'nilaipenerimaan' => 'Nilaipenerimaan',
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

		if(!empty($this->renanggaranpenerimaandet_id)){
			$criteria->addCondition('renanggaranpenerimaandet_id = '.$this->renanggaranpenerimaandet_id);
		}
		if(!empty($this->renanggpenerimaan_id)){
			$criteria->addCondition('renanggpenerimaan_id = '.$this->renanggpenerimaan_id);
		}
		if(!empty($this->renanggaran_ke)){
			$criteria->addCondition('renanggaran_ke = '.$this->renanggaran_ke);
		}
		$criteria->compare('LOWER(tglrenanggaranpen)',strtolower($this->tglrenanggaranpen),true);
		$criteria->compare('nilaipenerimaan',$this->nilaipenerimaan);

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