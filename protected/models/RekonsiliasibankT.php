<?php

/**
 * This is the model class for table "rekonsiliasibank_t".
 *
 * The followings are the available columns in table 'rekonsiliasibank_t':
 * @property integer $rekonsiliasibank_id
 * @property string $rekonsiliasibank_no
 * @property string $rekonsiliasibank_tgl
 * @property double $rekonsiliasibank_saldokas
 * @property double $rekonsiliasibank_saldobank
 * @property integer $bank_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RekonsiliasibankdetailT[] $rekonsiliasibankdetailTs
 * @property BankM $bank
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class RekonsiliasibankT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekonsiliasibankT the static model class
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
		return 'rekonsiliasibank_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekonsiliasibank_no, rekonsiliasibank_tgl, bank_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('bank_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('rekonsiliasibank_saldokas, rekonsiliasibank_saldobank', 'numerical'),
			array('rekonsiliasibank_no', 'length', 'max'=>25),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasibank_id, rekonsiliasibank_no, rekonsiliasibank_tgl, rekonsiliasibank_saldokas, rekonsiliasibank_saldobank, bank_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'rekonsiliasibankdetailTs' => array(self::HAS_MANY, 'RekonsiliasibankdetailT', 'rekonsiliasibank_id'),
			'bank' => array(self::BELONGS_TO, 'BankM', 'bank_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekonsiliasibank_id' => 'ID Rekonsiliasi Bank',
			'rekonsiliasibank_no' => 'No. Rekonsiliasi Bank',
			'rekonsiliasibank_tgl' => 'Tgl. Rekonsiliasi Bank',
			'rekonsiliasibank_saldokas' => 'Saldo Kas',
			'rekonsiliasibank_saldobank' => 'Saldo Bank',
			'bank_id' => 'Bank',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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
		$criteria->compare('LOWER(rekonsiliasibank_no)',strtolower($this->rekonsiliasibank_no),true);
		$criteria->compare('LOWER(rekonsiliasibank_tgl)',strtolower($this->rekonsiliasibank_tgl),true);
		$criteria->compare('rekonsiliasibank_saldokas',$this->rekonsiliasibank_saldokas);
		$criteria->compare('rekonsiliasibank_saldobank',$this->rekonsiliasibank_saldobank);
		if(!empty($this->bank_id)){
			$criteria->addCondition('bank_id = '.$this->bank_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
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