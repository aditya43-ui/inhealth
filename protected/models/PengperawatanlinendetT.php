<?php

/**
 * This is the model class for table "pengperawatanlinendet_t".
 *
 * The followings are the available columns in table 'pengperawatanlinendet_t':
 * @property integer $pengperawatanlinendet_id
 * @property integer $pengperawatanlinen_id
 * @property integer $linen_id
 * @property string $jenisperawatan
 * @property string $keterangan_pengperawatan
 */
class PengperawatanlinendetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengperawatanlinendetT the static model class
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
		return 'pengperawatanlinendet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengperawatanlinen_id, linen_id, jenisperawatan', 'required'),
			array('pengperawatanlinen_id, linen_id', 'numerical', 'integerOnly'=>true),
			array('jenisperawatan', 'length', 'max'=>50),
			array('keterangan_pengperawatan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengperawatanlinendet_id, pengperawatanlinen_id, linen_id, jenisperawatan, keterangan_pengperawatan', 'safe', 'on'=>'search'),
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
            'linen' => array(self::BELONGS_TO, 'LinenM', 'linen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengperawatanlinendet_id' => 'Pengperawatanlinendet',
			'pengperawatanlinen_id' => 'Pengperawatanlinen',
			'linen_id' => 'Linen',
			'jenisperawatan' => 'Jenisperawatan',
			'keterangan_pengperawatan' => 'Keterangan Pengperawatan',
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

		if(!empty($this->pengperawatanlinendet_id)){
			$criteria->addCondition('pengperawatanlinendet_id = '.$this->pengperawatanlinendet_id);
		}
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		if(!empty($this->linen_id)){
			$criteria->addCondition('linen_id = '.$this->linen_id);
		}
		$criteria->compare('LOWER(jenisperawatan)',strtolower($this->jenisperawatan),true);
		$criteria->compare('LOWER(keterangan_pengperawatan)',strtolower($this->keterangan_pengperawatan),true);

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