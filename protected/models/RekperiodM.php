<?php

/**
 * This is the model class for table "rekperiod_m".
 *
 * The followings are the available columns in table 'rekperiod_m':
 * @property integer $rekperiod_id
 * @property string $perideawal
 * @property string $sampaidgn
 * @property string $deskripsi
 * @property boolean $isclosing
 */
class RekperiodM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekperiodM the static model class
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
		return 'rekperiod_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perideawal, sampaidgn, deskripsi', 'required'),
			array('deskripsi', 'length', 'max'=>200),
			array('isclosing', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekperiod_id, perideawal, sampaidgn, deskripsi, isclosing', 'safe', 'on'=>'search'),
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
			'rekperiod_id' => 'ID Rekening Period',
			'perideawal' => 'Periode Awal',
			'sampaidgn' => 'Sampai Dengan',
			'deskripsi' => 'Deskripsi',
			'isclosing' => 'Is Closing',
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

		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('date(perideawal)',$this->perideawal,true);
		$criteria->compare('date(sampaidgn)',$this->sampaidgn,true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',isset($this->isclosing)?$this->isclosing:0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(perideawal)',strtolower($this->perideawal),true);
		$criteria->compare('LOWER(sampaidgn)',strtolower($this->sampaidgn),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('isclosing',isset($this->isclosing)?$this->isclosing:false);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function items()
        {
            $models = self::model()->findAll(
                array(
                    'condition'=>'isclosing = false',
                    'order'=>'rekperiod_id',
                )
            );
            $result = array();
            foreach($models as $model){
                $result[$model->rekperiod_id] = $model->deskripsi . ' [' . $model->perideawal . ' s/d ' . $model->sampaidgn . ']';
            }
            return $result;
        }
        
		/*
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }*/
}