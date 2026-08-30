<?php

/**
 * This is the model class for table "rencanggaranpengdetail_t".
 *
 * The followings are the available columns in table 'rencanggaranpengdetail_t':
 * @property integer $rencanggaranpengdet_id
 * @property integer $subkegiatanprogram_id
 * @property integer $rencanggaranpeng_id
 * @property integer $apprrencanggaran_id
 * @property string $tglrencanapengdet
 * @property double $nilairencpengeluaran
 */
class RencanggaranpengdetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanggaranpengdetailT the static model class
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
		return 'rencanggaranpengdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subkegiatanprogram_id, rencanggaranpeng_id, tglrencanapengdet, nilairencpengeluaran', 'required'),
			array('subkegiatanprogram_id, rencanggaranpeng_id, apprrencanggaran_id', 'numerical', 'integerOnly'=>true),
			array('nilairencpengeluaran', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanggaranpengdet_id, subkegiatanprogram_id, rencanggaranpeng_id, apprrencanggaran_id, tglrencanapengdet, nilairencpengeluaran', 'safe', 'on'=>'search'),
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
			'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanggaranpengdet_id' => 'Rencanggaranpengdet',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'rencanggaranpeng_id' => 'Rencanggaranpeng',
			'apprrencanggaran_id' => 'Apprrencanggaran',
			'tglrencanapengdet' => 'Tglrencanapengdet',
			'nilairencpengeluaran' => 'Nilai Pengeluaran',
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

		if(!empty($this->rencanggaranpengdet_id)){
			$criteria->addCondition('rencanggaranpengdet_id = '.$this->rencanggaranpengdet_id);
		}
		if(!empty($this->subkegiatanprogram_id)){
			$criteria->addCondition('subkegiatanprogram_id = '.$this->subkegiatanprogram_id);
		}
		if(!empty($this->rencanggaranpeng_id)){
			$criteria->addCondition('rencanggaranpeng_id = '.$this->rencanggaranpeng_id);
		}
		if(!empty($this->apprrencanggaran_id)){
			$criteria->addCondition('apprrencanggaran_id = '.$this->apprrencanggaran_id);
		}
		$criteria->compare('LOWER(tglrencanapengdet)',strtolower($this->tglrencanapengdet),true);
		$criteria->compare('nilairencpengeluaran',$this->nilairencpengeluaran);

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