<?php

/**
 * This is the model class for table "sumberdanarek_m".
 *
 * The followings are the available columns in table 'sumberdanarek_m':
 * @property integer $sumberdanarek_id
 * @property integer $rekening3_id
 * @property integer $sumberdana_id
 * @property integer $rekening1_id
 * @property integer $rekening2_id
 * @property integer $rekening4_id
 * @property integer $rekening5_id
 * @property string $saldonormal
 */
class SumberdanarekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumberdanarekM the static model class
	 */
	public $rekDebit, $rekKredit, $sumberdana_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sumberdanarek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sumberdana_id', 'required'),
			array('rekening3_id, sumberdana_id, rekening1_id, rekening2_id, rekening4_id, rekening5_id', 'numerical', 'integerOnly'=>true),
			array('saldonormal', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sumberdanarek_id, rekening3_id, sumberdana_id, rekening1_id, rekening2_id, rekening4_id, rekening5_id, saldonormal', 'safe', 'on'=>'search'),
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
			'sumberdana' => array(self::BELONGS_TO,'SumberdanaM','sumberdana_id'),
			'rekening5' => array(self::BELONGS_TO,'Rekening5M','rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sumberdanarek_id' => 'Sumberdanarek',
			'rekening3_id' => 'Rekening3',
			'sumberdana_id' => 'Sumberdana',
			'rekening1_id' => 'Rekening1',
			'rekening2_id' => 'Rekening2',
			'rekening4_id' => 'Rekening4',
			'rekening5_id' => 'Rekening5',
			'saldonormal' => 'Saldo Normal',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('sumberdanarek_id',$this->sumberdanarek_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// untuk menampilkan daftar sumberdanarek group by sumberdana
	public function searchIndex($print)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->select = 't.sumberdana_id, sumberdana_m.sumberdana_nama';
		$criteria->join = "JOIN sumberdana_m ON t.sumberdana_id = sumberdana_m.sumberdana_id";
		$criteria->group = 't.sumberdana_id, sumberdana_m.sumberdana_nama';
        $criteria->order = 'sumberdana_m.sumberdana_nama';

		if(isset($this->rekDebit)){
            $debit = "D";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekDebit),true);
            
            $record = SumberdanarekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->sumberdana_id;
            }
            if(count((array)$data)>0){
                   $condition = 't.sumberdana_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }

        if(isset($this->rekKredit)){
            $debit = "K";
            $criteria_satu = new CDbCriteria;
            $criteria_satu->compare('LOWER(rekening5.nmrekening5)', strtolower($this->rekKredit),true);
            
            $record = SumberdanarekM::model()->with("rekening5")->findAll($criteria_satu);
            //var_dump($record->attributes);
            $data = array();
            foreach($record as $value)
            {
                $data[] = $value->sumberdana_id;
            }
            if(count((array)$data)>0){
                   $condition = 't.sumberdana_id IN ('. implode(',', $data) .')';
                   $criteria->addCondition($condition);
            }
        }

        if($print=='print'){
        	return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        	));
        }else{
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sumberdanarek_id',$this->sumberdanarek_id);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}