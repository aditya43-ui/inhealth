<?php

/**
 * This is the model class for table "diagnosaobat_m".
 *
 * The followings are the available columns in table 'diagnosaobat_m':
 * @property integer $diagnosa_id
 * @property integer $obatalkes_id
 */
class DiagnosaobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaobatM the static model class
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
		return 'diagnosaobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosa_id, obatalkes_id', 'required'),
                                                array('diagnosa_id, obatalkes_id', 'cekdata'),
			array('diagnosa_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosa_id, obatalkes_id', 'safe', 'on'=>'search'),
		);
	}
        
                public function cekdata()
                {
                    $querydata = DiagnosaobatM::model()->findAllByAttributes(array('diagnosa_id'=>$this->diagnosa_id,'obatalkes_id'=>$this->obatalkes_id));
                    if (!$this->hasErrors()) {
                        if (count((array)$querydata) > 0) {
                            $this->addError('diagnosa_id, obatalkes_id', 'Obat alkes '.$this->obatalkes->obatalkes_nama.' untuk diagnosa'.$this->diagnosa->diagnosa_nama.' telah tersedia');
                            return false;
                        }
                    }
                }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                                            'diagnosa'=>array(self::BELONGS_TO,'DiagnosaM','diagnosa_id'),
                                            'obatalkes'=>array(self::BELONGS_TO,'ObatalkesM','obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'diagnosa_id' => 'Diagnosa',
			'obatalkes_id' => 'Obat Alkes',
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

		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getDiagnosaItems()
        {
            return DiagnosaM::model()->findAll('diagnosa_aktif=TRUE ORDER BY diagnosa_nama');
        }
        
        public function getObatalkesItems()
        {
            return ObatalkesM::model()->findAll('obatalkes_aktif=TRUE ORDER BY obatalkes_nama');
        }
}