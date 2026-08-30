<?php

/**
 * This is the model class for table "terimaperlinensterildet_t".
 *
 * The followings are the available columns in table 'terimaperlinensterildet_t':
 * @property integer $terimaperlinensterildet_id
 * @property integer $terimaperlinensteril_id
 * @property integer $barang_id
 * @property integer $linen_id
 * @property integer $terimaperlinensterildet_jml
 * @property string $terimaperlinensterildet_ket
 */
class TerimaperlinensterildetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimaperlinensterildetT the static model class
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
		return 'terimaperlinensterildet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimaperlinensteril_id, terimaperlinensterildet_jml', 'required'),
			array('terimaperlinensteril_id, barang_id, linen_id, terimaperlinensterildet_jml', 'numerical', 'integerOnly'=>true),
			array('terimaperlinensterildet_ket', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('terimaperlinensterildet_id, terimaperlinensteril_id, barang_id, linen_id, terimaperlinensterildet_jml, terimaperlinensterildet_ket', 'safe', 'on'=>'search'),
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
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
			'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
			'penerimaansterilisasi'=>array(self::BELONGS_TO,'TerimaperlinensterilT','terimaperlinensteril_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'terimaperlinensterildet_id' => 'Terimaperlinensterildet',
			'terimaperlinensteril_id' => 'Terimaperlinensteril',
			'barang_id' => 'Barang',
			'linen_id' => 'Linen',
			'terimaperlinensterildet_jml' => 'Terimaperlinensterildet Jml',
			'terimaperlinensterildet_ket' => 'Terimaperlinensterildet Ket',
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

		if(!empty($this->terimaperlinensterildet_id)){
			$criteria->addCondition('terimaperlinensterildet_id = '.$this->terimaperlinensterildet_id);
		}
		if(!empty($this->terimaperlinensteril_id)){
			$criteria->addCondition('terimaperlinensteril_id = '.$this->terimaperlinensteril_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->terimaperlinensterildet_jml)){
			$criteria->addCondition('terimaperlinensterildet_jml = '.$this->terimaperlinensterildet_jml);
		}
		$criteria->compare('LOWER(terimaperlinensterildet_ket)',strtolower($this->terimaperlinensterildet_ket),true);

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