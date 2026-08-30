<?php

/**
 * This is the model class for table "atc_m".
 *
 * The followings are the available columns in table 'atc_m':
 * @property integer $atc_id
 * @property string $atc_kode
 * @property string $atc_nama
 * @property string $atc_namalain
 * @property string $atc_singkatan
 * @property string $atc_ddd
 * @property string $atc_units
 * @property string $atc_admr
 * @property string $atc_note
 * @property boolean $atc_aktif
 *
 * The followings are the available model relations:
 * @property ObatalkesM[] $obatalkesMs
 */
class AtcM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AtcM the static model class
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
		return 'atc_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('atc_kode, atc_nama', 'required'),
			array('atc_kode', 'length', 'max'=>10),
			array('atc_nama, atc_namalain', 'length', 'max'=>100),
			array('atc_singkatan', 'length', 'max'=>20),
			array('atc_units, atc_admr', 'length', 'max'=>50),
			array('atc_note', 'length', 'max'=>200),
			array('atc_ddd, atc_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('atc_id, atc_kode, atc_nama, atc_namalain, atc_singkatan, atc_ddd, atc_units, atc_admr, atc_note, atc_aktif', 'safe', 'on'=>'search'),
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
			'obatalkesMs' => array(self::HAS_MANY, 'ObatalkesM', 'atc_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'atc_id' => 'ATC',
			'atc_kode' => 'Kode ATC',
			'atc_nama' => 'Nama ATC',
			'atc_namalain' => 'Nama Lain ATC',
			'atc_singkatan' => 'Singkatan ATC',
			'atc_ddd' => 'Ddd ATC',
			'atc_units' => 'Units ATC',
			'atc_admr' => 'Route of Adm ATC',
			'atc_note' => 'Keterangan ATC',
			'atc_aktif' => 'Status Aktif',
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

		if(!empty($this->atc_id)){
			$criteria->addCondition('atc_id = '.$this->atc_id);
		}
		$criteria->compare('LOWER(atc_kode)',strtolower($this->atc_kode),true);
		$criteria->compare('LOWER(atc_nama)',strtolower($this->atc_nama),true);
		$criteria->compare('LOWER(atc_namalain)',strtolower($this->atc_namalain),true);
		$criteria->compare('LOWER(atc_singkatan)',strtolower($this->atc_singkatan),true);
		$criteria->compare('LOWER(atc_ddd)',strtolower($this->atc_ddd),true);
		$criteria->compare('LOWER(atc_units)',strtolower($this->atc_units),true);
		$criteria->compare('LOWER(atc_admr)',strtolower($this->atc_admr),true);
		$criteria->compare('LOWER(atc_note)',strtolower($this->atc_note),true);
		$criteria->compare('atc_aktif',$this->atc_aktif);

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