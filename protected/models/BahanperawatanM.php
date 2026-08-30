<?php

/**
 * This is the model class for table "bahanperawatan_m".
 *
 * The followings are the available columns in table 'bahanperawatan_m':
 * @property integer $bahanperawatan_id
 * @property string $bahanperawatan_jenis
 * @property string $bahanperawatan_nama
 * @property string $bahanperawatan_namalain
 * @property boolean $bahanperawatan_aktif
 */
class BahanperawatanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahanperawatanM the static model class
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
		return 'bahanperawatan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bahanperawatan_nama, bahanperawatan_namalain', 'required'),
			array('bahanperawatan_jenis', 'length', 'max'=>10),
			array('bahanperawatan_nama, bahanperawatan_namalain', 'length', 'max'=>100),
			array('bahanperawatan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bahanperawatan_id, bahanperawatan_jenis, bahanperawatan_nama, bahanperawatan_namalain, bahanperawatan_aktif', 'safe', 'on'=>'search'),
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
			'bahanperawatan_id' => 'Bahan Perawatan',
			'bahanperawatan_jenis' => 'Jenis Bahan Perawatan',
			'bahanperawatan_nama' => 'Nama Bahan Perawatan',
			'bahanperawatan_namalain' => 'Nama Lain Bahan Perawatan',
			'bahanperawatan_aktif' => 'Aktif',
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

		if(!empty($this->bahanperawatan_id)){
			$criteria->addCondition('bahanperawatan_id = '.$this->bahanperawatan_id);
		}
		$criteria->compare('LOWER(bahanperawatan_jenis)',strtolower($this->bahanperawatan_jenis),true);
		$criteria->compare('LOWER(bahanperawatan_nama)',strtolower($this->bahanperawatan_nama),true);
		$criteria->compare('LOWER(bahanperawatan_namalain)',strtolower($this->bahanperawatan_namalain),true);
		$criteria->compare('bahanperawatan_aktif',isset($this->bahanperawatan_aktif)?$this->bahanperawatan_aktif:true);

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