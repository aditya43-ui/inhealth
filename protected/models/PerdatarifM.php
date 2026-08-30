<?php

/**
 * This is the model class for table "perdatarif_m".
 *
 * The followings are the available columns in table 'perdatarif_m':
 * @property integer $perdatarif_id
 * @property string $perdanama_sk
 * @property string $noperda
 * @property string $tglperda
 * @property string $perdatentang
 * @property string $ditetapkanoleh
 * @property string $tempatditetapkan
 * @property boolean $perda_aktif
 */
class PerdatarifM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerdatarifM the static model class
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
		return 'perdatarif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perdanama_sk', 'length', 'max'=>200),
			array('noperda', 'length', 'max'=>20),
			array('ditetapkanoleh, tempatditetapkan', 'length', 'max'=>30),
			array('tglperda, perdatentang, perda_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perdatarif_id, perdanama_sk, noperda, tglperda, perdatentang, ditetapkanoleh, tempatditetapkan, perda_aktif', 'safe', 'on'=>'search'),
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
			'perdatarif_id' => 'ID',
			'perdanama_sk' => 'SK Tarif',
			'noperda' => 'No. SK Tarif',
			'tglperda' => 'Tanggal SK Tarif',
			'perdatentang' => 'SK Tarif Tentang',
			'ditetapkanoleh' => 'Ditetapkan Oleh',
			'tempatditetapkan' => 'Tempat Ditetapkan',
			'perda_aktif' => 'Aktif',
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

		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
		$criteria->compare('perda_aktif',isset($this->perda_aktif)?$this->perda_aktif:true);
//                $criteria->addCondition('perda_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('perdatarif_id',$this->perdatarif_id);
		$criteria->compare('LOWER(perdanama_sk)',strtolower($this->perdanama_sk),true);
		$criteria->compare('LOWER(noperda)',strtolower($this->noperda),true);
		$criteria->compare('LOWER(tglperda)',strtolower($this->tglperda),true);
		$criteria->compare('LOWER(perdatentang)',strtolower($this->perdatentang),true);
		$criteria->compare('LOWER(ditetapkanoleh)',strtolower($this->ditetapkanoleh),true);
		$criteria->compare('LOWER(tempatditetapkan)',strtolower($this->tempatditetapkan),true);
//		$criteria->compare('perda_aktif',$this->perda_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->perdanama_sk = ucwords(strtolower($this->perdanama_sk));
             if($this->tglperda===null || trim($this->tglperda)==''){
	        $this->setAttribute('tglperda', null);
            } 
            
            if($this->tglperda===null || trim($this->tglperda)==''){
	        $this->setAttribute('tglperda', null);
            } 
            return parent::beforeSave();
        }
        
         protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date'){
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                    }elseif ($column->dbType == 'datetime'){
                            $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                    }

            }

            return parent::beforeValidate ();
        }


        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'datetime'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
}