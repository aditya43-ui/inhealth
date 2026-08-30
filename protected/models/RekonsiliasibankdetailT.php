<?php

/**
 * This is the model class for table "rekonsiliasibankdetail_t".
 *
 * The followings are the available columns in table 'rekonsiliasibankdetail_t':
 * @property integer $rekonsiliasibank_id
 * @property integer $rekonsiliasibankdetail_id
 * @property integer $kelrekening_id
 * @property integer $rekening1_id
 * @property integer $rekening2_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening5_id
 * @property double $saldodebit
 * @property double $saldokredit
 * @property integer $jenisrekonsiliasibank_id
 *
 * The followings are the available model relations:
 * @property RekonsiliasibankT $rekonsiliasibank
 * @property KelrekeningM $kelrekening
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 * @property JenisrekonsiliasibankM $jenisrekonsiliasibank
 */
class RekonsiliasibankdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonsiliasibankdetailT the static model class
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
		return 'rekonsiliasibankdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekonsiliasibank_id, jenisrekonsiliasibank_id', 'required'),
			array('rekonsiliasibank_id, rekening5_id, jenisrekonsiliasibank_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasibank_id, rekonsiliasibankdetail_id, rekening5_id, saldodebit, saldokredit, jenisrekonsiliasibank_id', 'safe', 'on'=>'search'),
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
			'rekonsiliasibank' => array(self::BELONGS_TO, 'RekonsiliasibankT', 'rekonsiliasibank_id'),
//			'kelrekening' => array(self::BELONGS_TO, 'KelrekeningM', 'kelrekening_id'),
//			'rekening1' => array(self::BELONGS_TO, 'Rekening1M', 'rekening1_id'),
//			'rekening2' => array(self::BELONGS_TO, 'Rekening2M', 'rekening2_id'),
//			'rekening3' => array(self::BELONGS_TO, 'Rekening3M', 'rekening3_id'),
//			'rekening4' => array(self::BELONGS_TO, 'Rekening4M', 'rekening4_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'jenisrekonsiliasibank' => array(self::BELONGS_TO, 'JenisrekonsiliasibankM', 'jenisrekonsiliasibank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonsiliasibank_id' => 'ID Rekonsiliasi Bank',
			'rekonsiliasibankdetail_id' => 'ID Rekonsiliasi Bank Detail',
//			'kelrekening_id' => 'Kelompok Rekening',
//			'rekening1_id' => 'Rekening 1',
//			'rekening2_id' => 'Rekening 2',
//			'rekening3_id' => 'Rekening 3',
//			'rekening4_id' => 'Rekening 4',
			'rekening5_id' => 'Rekening 5',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'jenisrekonsiliasibank_id' => 'Jenis Rekonsiliasi Bank',
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

		if(!empty($this->rekonsiliasibank_id)){
			$criteria->addCondition('rekonsiliasibank_id = '.$this->rekonsiliasibank_id);
		}
		if(!empty($this->rekonsiliasibankdetail_id)){
			$criteria->addCondition('rekonsiliasibankdetail_id = '.$this->rekonsiliasibankdetail_id);
		}
//		if(!empty($this->kelrekening_id)){
//			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
//		}
//		if(!empty($this->rekening1_id)){
//			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
//		}
//		if(!empty($this->rekening2_id)){
//			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
//		}
//		if(!empty($this->rekening3_id)){
//			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
//		}
//		if(!empty($this->rekening4_id)){
//			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
//		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		if(!empty($this->jenisrekonsiliasibank_id)){
			$criteria->addCondition('jenisrekonsiliasibank_id = '.$this->jenisrekonsiliasibank_id);
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