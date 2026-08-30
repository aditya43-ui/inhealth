<?php

/**
 * This is the model class for table "usulanpns_r".
 *
 * The followings are the available columns in table 'usulanpns_r':
 * @property integer $usulanpns_id
 * @property integer $pengangkatanpns_id
 * @property string $usulanpns_tglsk
 * @property string $usulanpns_nosk
 * @property integer $usulanpns_masakerjatahun
 * @property integer $usulanpns_masakerjabulan
 * @property double $usulanpns_gajipokok
 * @property string $usulanpns_pejabatygberwenang
 */
class UsulanpnsR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsulanpnsR the static model class
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
		return 'usulanpns_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usulanpns_tglsk, usulanpns_nosk, usulanpns_masakerjatahun, usulanpns_masakerjabulan, usulanpns_gajipokok, usulanpns_pejabatygberwenang', 'required'),
			array('pengangkatanpns_id','numerical', 'integerOnly'=>true),
			//array('usulanpns_gajipokok, usulanpns_masakerjatahun, usulanpns_masakerjabulan', 'numerical'),
			array('usulanpns_nosk, usulanpns_pejabatygberwenang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usulanpns_id, pengangkatanpns_id, usulanpns_tglsk, usulanpns_nosk, usulanpns_masakerjatahun, usulanpns_masakerjabulan, usulanpns_gajipokok, usulanpns_pejabatygberwenang', 'safe', 'on'=>'search'),
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

			'usulanpns_id' => 'Usulan PNS',
			'pengangkatanpns_id' => 'Pengangkatan PNS',
			'usulanpns_tglsk' => 'Tanggal SK',
			'usulanpns_nosk' => 'No. SK',
			'usulanpns_masakerjatahun' => 'Tahun Masa Kerja',
			'usulanpns_masakerjabulan' => 'Bulan Masa Kerja',
			'usulanpns_gajipokok' => 'Gaji Pokok',
			'usulanpns_pejabatygberwenang' => 'Pejabat Berwenang',

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

		$criteria->compare('usulanpns_id',$this->usulanpns_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(usulanpns_tglsk)',strtolower($this->usulanpns_tglsk),true);
		$criteria->compare('LOWER(usulanpns_nosk)',strtolower($this->usulanpns_nosk),true);
		$criteria->compare('usulanpns_masakerjatahun',$this->usulanpns_masakerjatahun);
		$criteria->compare('usulanpns_masakerjabulan',$this->usulanpns_masakerjabulan);
		$criteria->compare('usulanpns_gajipokok',$this->usulanpns_gajipokok);
		$criteria->compare('LOWER(usulanpns_pejabatygberwenang)',strtolower($this->usulanpns_pejabatygberwenang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('usulanpns_id',$this->usulanpns_id);
		$criteria->compare('pengangkatanpns_id',$this->pengangkatanpns_id);
		$criteria->compare('LOWER(usulanpns_tglsk)',strtolower($this->usulanpns_tglsk),true);
		$criteria->compare('LOWER(usulanpns_nosk)',strtolower($this->usulanpns_nosk),true);
		$criteria->compare('usulanpns_masakerjatahun',$this->usulanpns_masakerjatahun);
		$criteria->compare('usulanpns_masakerjabulan',$this->usulanpns_masakerjabulan);
		$criteria->compare('usulanpns_gajipokok',$this->usulanpns_gajipokok);
		$criteria->compare('LOWER(usulanpns_pejabatygberwenang)',strtolower($this->usulanpns_pejabatygberwenang),true);
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
            if($this->usulanpns_tglsk===null || trim($this->usulanpns_tglsk)==''){
	        $this->setAttribute('usulanpns_tglsk', null);
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