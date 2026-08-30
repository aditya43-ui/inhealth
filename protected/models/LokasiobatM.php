<?php

/**
 * This is the model class for table "lokasiobat_m".
 *
 * The followings are the available columns in table 'lokasiobat_m':
 * @property integer $lokasiobat_id
 * @property string $lokasiobat_nama
 * @property string $lokasiobat_namalain
 * @property boolean $lokasiobat_aktif
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 */
class LokasiobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasiobatM the static model class
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
		return 'lokasiobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lokasiobat_nama', 'required'),
			array('lokasiobat_nama, lokasiobat_namalain', 'length', 'max'=>100),
			array('lokasiobat_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lokasiobat_id, lokasiobat_nama, lokasiobat_namalain, lokasiobat_aktif', 'safe', 'on'=>'search'),
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
			'stokobatalkesTs' => array(self::HAS_MANY, 'StokobatalkesT', 'lokasiobat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lokasiobat_id' => 'Lokasi Obat',
			'lokasiobat_nama' => 'Lokasi Obat',
			'lokasiobat_namalain' => 'Lokasi Obat Lainnya',
			'lokasiobat_aktif' => 'Lokasi Obat Aktif',
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

		if(!empty($this->lokasiobat_id)){
			$criteria->addCondition('lokasiobat_id = '.$this->lokasiobat_id);
		}
		$criteria->compare('LOWER(lokasiobat_nama)',strtolower($this->lokasiobat_nama),true);
		$criteria->compare('LOWER(lokasiobat_namalain)',strtolower($this->lokasiobat_namalain),true);
		$criteria->compare('lokasiobat_aktif',$this->lokasiobat_aktif);

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