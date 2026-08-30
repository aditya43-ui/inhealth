<?php

/**
 * This is the model class for table "kirimperlinensterildet_t".
 *
 * The followings are the available columns in table 'kirimperlinensterildet_t':
 * @property integer $kirimperlinensterildet_id
 * @property integer $barang_id
 * @property integer $kirimperlinensteril_id
 * @property integer $linen_id
 * @property integer $kirimperlinensterildet_jml
 * @property string $kirimperlinensterildet_ket
 */
class KirimperlinensterildetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KirimperlinensterildetT the static model class
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
		return 'kirimperlinensterildet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kirimperlinensteril_id, kirimperlinensterildet_jml', 'required'),
			array('barang_id, kirimperlinensteril_id, linen_id, kirimperlinensterildet_jml', 'numerical', 'integerOnly'=>true),
			array('kirimperlinensterildet_ket', 'length', 'max'=>200),
			array('barang_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kirimperlinensterildet_id, barang_id, kirimperlinensteril_id, linen_id, kirimperlinensterildet_jml, kirimperlinensterildet_ket', 'safe', 'on'=>'search'),
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
			'kirimperlinensteril'=>array(self::BELONGS_TO,'KirimperlinensterilT','kirimperlinensteril_id'),
			'barang'=>array(self::BELONGS_TO,'BarangM','barang_id'),
                        'peralatansterilisasi'=>array(self::BELONGS_TO,'PeralatansterilisasiM','peralatansterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kirimperlinensterildet_id' => 'Kirimperlinensterildet',
			'barang_id' => 'Barang',
			'kirimperlinensteril_id' => 'Kirimperlinensteril',
			'linen_id' => 'Linen',
			'kirimperlinensterildet_jml' => 'Kirimperlinensterildet Jml',
			'kirimperlinensterildet_ket' => 'Kirimperlinensterildet Ket',
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

		if(!empty($this->kirimperlinensterildet_id)){
			$criteria->addCondition('kirimperlinensterildet_id = '.$this->kirimperlinensterildet_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->kirimperlinensteril_id)){
			$criteria->addCondition('kirimperlinensteril_id = '.$this->kirimperlinensteril_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		if(!empty($this->kirimperlinensterildet_jml)){
			$criteria->addCondition('kirimperlinensterildet_jml = '.$this->kirimperlinensterildet_jml);
		}
		$criteria->compare('LOWER(kirimperlinensterildet_ket)',strtolower($this->kirimperlinensterildet_ket),true);

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
