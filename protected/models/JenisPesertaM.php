<?php

/**
 * This is the model class for table "jenispeserta_m".
 *
 * The followings are the available columns in table 'jenispeserta_m':
 * @property integer $jenispeserta_id
 * @property string $jenispeserta_nama
 * @property string $jenispeserta_namalain
 * @property string $jenispeserta_keterangan
 * @property boolean $jenispeserta_aktif
 *
 * The followings are the available model relations:
 * @property AsuransipasienM[] $asuransipasienMs
 */
class JenisPesertaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisPesertaM the static model class
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
		return 'jenispeserta_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenispeserta_nama, jenispeserta_namalain, jenispeserta_aktif', 'required'),
			array('jenispeserta_nama, jenispeserta_namalain', 'length', 'max'=>200),
			array('jenispeserta_keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispeserta_id, jenispeserta_nama, jenispeserta_namalain, jenispeserta_keterangan, jenispeserta_aktif', 'safe', 'on'=>'search'),
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
			'asuransipasienMs' => array(self::HAS_MANY, 'AsuransipasienM', 'jenispeserta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenispeserta_id' => 'Jenispeserta',
			'jenispeserta_nama' => 'Jenispeserta Nama',
			'jenispeserta_namalain' => 'Jenispeserta Namalain',
			'jenispeserta_keterangan' => 'Jenispeserta Keterangan',
			'jenispeserta_aktif' => 'Jenispeserta Aktif',
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

		$criteria->compare('jenispeserta_id',$this->jenispeserta_id);
		$criteria->compare('LOWER(jenispeserta_nama)',strtolower($this->jenispeserta_nama),true);
		$criteria->compare('LOWER(jenispeserta_namalain)',strtolower($this->jenispeserta_namalain),true);
		$criteria->compare('LOWER(jenispeserta_keterangan)',strtolower($this->jenispeserta_keterangan),true);
		$criteria->compare('jenispeserta_aktif',$this->jenispeserta_aktif);

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