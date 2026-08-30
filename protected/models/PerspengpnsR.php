<?php

/**
 * This is the model class for table "perspengpns_r".
 *
 * The followings are the available columns in table 'perspengpns_r':
 * @property integer $perspeng_id
 * @property boolean $pengangkatanpns_id
 * @property string $perspeng_tglsk
 * @property string $perspeng_nosk
 * @property integer $perspeng_masakerjatahun
 * @property integer $perspeng_masakerjabulan
 * @property double $perspeng_gajipokok
 * @property string $perspeng_pejabatygberwenang
 */
class PerspengpnsR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerspengpnsR the static model class
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
		return 'perspengpns_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perspeng_tglsk, perspeng_nosk, perspeng_masakerjatahun, perspeng_masakerjabulan, perspeng_gajipokok, perspeng_pejabatygberwenang', 'required'),
			//array('perspeng_masakerjatahun, perspeng_masakerjabulan', 'numerical', 'integerOnly'=>true),
			//array('perspeng_gajipokok', 'numerical'),
			array('perspeng_nosk, perspeng_pejabatygberwenang', 'length', 'max'=>50),
			array('pengangkatanpns_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perspeng_id, pengangkatanpns_id, perspeng_tglsk, perspeng_nosk, perspeng_masakerjatahun, perspeng_masakerjabulan, perspeng_gajipokok, perspeng_pejabatygberwenang', 'safe', 'on'=>'search'),
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
			'perspeng_id' => 'Perspeng',
			'pengangkatanpns_id' => 'Pengangkatan PNS',
			'perspeng_tglsk' => 'Tanggal Surat Keputusan',
			'perspeng_nosk' => 'No. Surat Keputusan',
			'perspeng_masakerjatahun' => 'Masa Kerja',
			'perspeng_masakerjabulan' => 'Masa Kerja',
			'perspeng_gajipokok' => 'Gaji Pokok',
			'perspeng_pejabatygberwenang' => 'Pejabat Yg Berwenang',
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

		$criteria->compare('perspeng_id',$this->perspeng_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(perspeng_tglsk)',strtolower($this->perspeng_tglsk),true);
		$criteria->compare('LOWER(perspeng_nosk)',strtolower($this->perspeng_nosk),true);
		$criteria->compare('perspeng_masakerjatahun',$this->perspeng_masakerjatahun);
		$criteria->compare('perspeng_masakerjabulan',$this->perspeng_masakerjabulan);
		$criteria->compare('perspeng_gajipokok',$this->perspeng_gajipokok);
		$criteria->compare('LOWER(perspeng_pejabatygberwenang)',strtolower($this->perspeng_pejabatygberwenang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('perspeng_id',$this->perspeng_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(perspeng_tglsk)',strtolower($this->perspeng_tglsk),true);
		$criteria->compare('LOWER(perspeng_nosk)',strtolower($this->perspeng_nosk),true);
		$criteria->compare('perspeng_masakerjatahun',$this->perspeng_masakerjatahun);
		$criteria->compare('perspeng_masakerjabulan',$this->perspeng_masakerjabulan);
		$criteria->compare('perspeng_gajipokok',$this->perspeng_gajipokok);
		$criteria->compare('LOWER(perspeng_pejabatygberwenang)',strtolower($this->perspeng_pejabatygberwenang),true);
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
            if($this->perspeng_tglsk===null || trim($this->perspeng_tglsk)==''){
	        $this->setAttribute('perspeng_tglsk', null);
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