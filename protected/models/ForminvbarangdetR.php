<?php

/**
 * This is the model class for table "forminvbarangdet_r".
 *
 * The followings are the available columns in table 'forminvbarangdet_r':
 * @property integer $forminvbarangdet_id
 * @property integer $barang_id
 * @property integer $formulirinvbarang_id
 * @property integer $invbarangdet_id
 * @property double $volume_inventaris
 *
 * The followings are the available model relations:
 * @property InvbarangdetT[] $invbarangdetTs
 * @property BarangM $barang
 */
class ForminvbarangdetR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ForminvbarangdetR the static model class
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
		return 'forminvbarangdet_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, formulirinvbarang_id, volume_inventaris', 'required'),
			array('barang_id, formulirinvbarang_id, invbarangdet_id', 'numerical', 'integerOnly'=>true),
			array('volume_inventaris', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('forminvbarangdet_id, barang_id, formulirinvbarang_id, invbarangdet_id, volume_inventaris', 'safe', 'on'=>'search'),
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
			'invbarangdetTs' => array(self::HAS_MANY, 'InvbarangdetT', 'forminvbarangdet_id'),
			'barang' => array(self::BELONGS_TO, 'BarangM', 'barang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'forminvbarangdet_id' => 'Formulir Inventarisasi Detail ID',
			'barang_id' => 'Barang',
			'formulirinvbarang_id' => 'Formulir Inventarisasi Barang ID',
			'invbarangdet_id' => 'Inventarisasi Barang Detail ID',
			'volume_inventaris' => 'Volume Inventaris',
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

		if(!empty($this->forminvbarangdet_id)){
			$criteria->addCondition('forminvbarangdet_id = '.$this->forminvbarangdet_id);
		}
		if(!empty($this->barang_id)){
			$criteria->addCondition('barang_id = '.$this->barang_id);
		}
		if(!empty($this->formulirinvbarang_id)){
			$criteria->addCondition('formulirinvbarang_id = '.$this->formulirinvbarang_id);
		}
		if(!empty($this->invbarangdet_id)){
			$criteria->addCondition('invbarangdet_id = '.$this->invbarangdet_id);
		}
		$criteria->compare('volume_inventaris',$this->volume_inventaris);

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