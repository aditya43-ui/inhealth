<?php

/**
 * This is the model class for table "penyusutanasetdetail_t".
 *
 * The followings are the available columns in table 'penyusutanasetdetail_t':
 * @property integer $penyusutanasetdetail_id
 * @property integer $penyusutanaset_id
 * @property integer $penyusutanaset_urutan
 * @property string $penyusutanaset_periode
 * @property double $penyusutanaset_saldo
 * @property double $penyusutanaset_persentase
 *
 * The followings are the available model relations:
 * @property PenyusutanasetT $penyusutanaset
 */
class PenyusutanasetdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyusutanasetdetailT the static model class
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
		return 'penyusutanasetdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyusutanaset_id', 'required'),
			array('penyusutanaset_id, penyusutanaset_urutan', 'numerical', 'integerOnly'=>true),
			array('penyusutanaset_saldo, penyusutanaset_persentase', 'numerical'),
			array('penyusutanaset_periode', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyusutanasetdetail_id, penyusutanaset_id, penyusutanaset_urutan, penyusutanaset_periode, penyusutanaset_saldo, penyusutanaset_persentase', 'safe', 'on'=>'search'),
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
			'penyusutanaset' => array(self::BELONGS_TO, 'PenyusutanasetT', 'penyusutanaset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyusutanasetdetail_id' => 'Penyusutanasetdetail',
			'penyusutanaset_id' => 'Penyusutanaset',
			'penyusutanaset_urutan' => 'Penyusutanaset Urutan',
			'penyusutanaset_periode' => 'Penyusutanaset Periode',
			'penyusutanaset_saldo' => 'Penyusutanaset Saldo',
			'penyusutanaset_persentase' => 'Penyusutanaset Persentase',
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

		if(!empty($this->penyusutanasetdetail_id)){
			$criteria->addCondition('penyusutanasetdetail_id = '.$this->penyusutanasetdetail_id);
		}
		if(!empty($this->penyusutanaset_id)){
			$criteria->addCondition('penyusutanaset_id = '.$this->penyusutanaset_id);
		}
		if(!empty($this->penyusutanaset_urutan)){
			$criteria->addCondition('penyusutanaset_urutan = '.$this->penyusutanaset_urutan);
		}
		$criteria->compare('LOWER(penyusutanaset_periode)',strtolower($this->penyusutanaset_periode),true);
		$criteria->compare('penyusutanaset_saldo',$this->penyusutanaset_saldo);
		$criteria->compare('penyusutanaset_persentase',$this->penyusutanaset_persentase);

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