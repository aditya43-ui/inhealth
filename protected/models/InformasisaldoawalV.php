<?php

/**
 * This is the model class for table "informasisaldoawal_v".
 *
 * The followings are the available columns in table 'informasisaldoawal_v':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $tiperekening_id
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property double $jmlsaldoawald
 * @property double $jmlsaldoawalk
 */
class InformasisaldoawalV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisaldoawalV the static model class
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
		return 'informasisaldoawal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, tiperekening_id, rekperiod_id', 'numerical', 'integerOnly'=>true),
			array('jmlsaldoawald, jmlsaldoawalk', 'numerical'),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('nmrekening1', 'length', 'max'=>100),
			array('nmrekening2', 'length', 'max'=>200),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('perideawal, sampaidgn', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, tiperekening_id, rekperiod_id, perideawal, sampaidgn, jmlsaldoawald, jmlsaldoawalk', 'safe', 'on'=>'search'),
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
			'rekening1_id' => 'Rekening1',
			'kdrekening1' => 'Kdrekening1',
			'nmrekening1' => 'Nmrekening1',
			'rekening2_id' => 'Rekening2',
			'kdrekening2' => 'Kdrekening2',
			'nmrekening2' => 'Nmrekening2',
			'rekening3_id' => 'Rekening3',
			'kdrekening3' => 'Kdrekening3',
			'nmrekening3' => 'Nmrekening3',
			'rekening4_id' => 'Rekening4',
			'kdrekening4' => 'Kdrekening4',
			'nmrekening4' => 'Nmrekening4',
			'rekening5_id' => 'Rekening5',
			'kdrekening5' => 'Kode Akun',
			'nmrekening5' => 'Nama Akun',
			'tiperekening_id' => 'Tiperekening',
			'rekperiod_id' => 'Rekperiod',
			'perideawal' => 'Perideawal',
			'sampaidgn' => 'Sampaidgn',
			'jmlsaldoawald' => 'Jmlsaldoawald',
			'jmlsaldoawalk' => 'Jmlsaldoawalk',
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

		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		if(!empty($this->tiperekening_id)){
			$criteria->addCondition('tiperekening_id = '.$this->tiperekening_id);
		}
		if(!empty($this->rekperiod_id)){
			$criteria->addCondition('rekperiod_id = '.$this->rekperiod_id);
		}
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('jmlsaldoawald',$this->jmlsaldoawald);
		$criteria->compare('jmlsaldoawalk',$this->jmlsaldoawalk);

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