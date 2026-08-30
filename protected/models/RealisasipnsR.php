<?php

/**
 * This is the model class for table "realisasipns_r".
 *
 * The followings are the available columns in table 'realisasipns_r':
 * @property integer $realisasipns_id
 * @property boolean $pengangkatanpns_id
 * @property string $realisasipns_tglsk
 * @property string $realisasipns_nosk
 * @property integer $realisasipns_masakerjatahun
 * @property integer $realisasipns_masakerjabulan
 * @property double $realisasipns_gajipokok
 * @property string $realisasipns_pejabatyangberwena
 */
class RealisasipnsR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasipnsR the static model class
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
		return 'realisasipns_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('realisasipns_masakerjatahun, realisasipns_masakerjabulan', 'numerical', 'integerOnly'=>true),
			//array('realisasipns_gajipokok', 'numerical'),
			array('realisasipns_nosk, realisasipns_pejabatyangberwena', 'length', 'max'=>50),
			array('pengangkatanpns_id, realisasipns_tglsk, realisasipns_gajipokok, realisasipns_masakerjatahun, realisasipns_masakerjabulan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasipns_id, pengangkatanpns_id, realisasipns_tglsk, realisasipns_nosk, realisasipns_masakerjatahun, realisasipns_masakerjabulan, realisasipns_gajipokok, realisasipns_pejabatyangberwena', 'safe', 'on'=>'search'),
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
			'realisasipns_id' => 'Realisasipns',
			'pengangkatanpns_id' => 'Pengangkatan PNS',
			'realisasipns_tglsk' => 'Tanggal Surat Keputusan',
			'realisasipns_nosk' => 'No. Surat Keputusan',
			'realisasipns_masakerjatahun' => 'Masa Kerja',
			'realisasipns_masakerjabulan' => 'Masa Kerja',
			'realisasipns_gajipokok' => 'Gaji Pokok',
			'realisasipns_pejabatyangberwena' => 'Pejabat Yang Berwenang',
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

		$criteria->compare('realisasipns_id',$this->realisasipns_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(realisasipns_tglsk)',strtolower($this->realisasipns_tglsk),true);
		$criteria->compare('LOWER(realisasipns_nosk)',strtolower($this->realisasipns_nosk),true);
		$criteria->compare('realisasipns_masakerjatahun',$this->realisasipns_masakerjatahun);
		$criteria->compare('realisasipns_masakerjabulan',$this->realisasipns_masakerjabulan);
		$criteria->compare('realisasipns_gajipokok',$this->realisasipns_gajipokok);
		$criteria->compare('LOWER(realisasipns_pejabatyangberwena)',strtolower($this->realisasipns_pejabatyangberwena),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('realisasipns_id',$this->realisasipns_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(realisasipns_tglsk)',strtolower($this->realisasipns_tglsk),true);
		$criteria->compare('LOWER(realisasipns_nosk)',strtolower($this->realisasipns_nosk),true);
		$criteria->compare('realisasipns_masakerjatahun',$this->realisasipns_masakerjatahun);
		$criteria->compare('realisasipns_masakerjabulan',$this->realisasipns_masakerjabulan);
		$criteria->compare('realisasipns_gajipokok',$this->realisasipns_gajipokok);
		$criteria->compare('LOWER(realisasipns_pejabatyangberwena)',strtolower($this->realisasipns_pejabatyangberwena),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->realisasipns_tglsk===null || trim($this->realisasipns_tglsk)==''){
	        $this->setAttribute('realisasipns_tglsk', null);
            }
            return parent::beforeSave();
        }

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
        }
}