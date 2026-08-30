<?php

/**
 * This is the model class for table "jenisrekonsiliasibank_m".
 *
 * The followings are the available columns in table 'jenisrekonsiliasibank_m':
 * @property integer $jenisrekonsiliasibank_id
 * @property string $jenisrekonsiliasibank_nama
 * @property string $jenisrekonsiliasibank_namalain
 * @property boolean $jenisrekonsiliasibank_aktif
 *
 * The followings are the available model relations:
 * @property RekonsiliasibankdetailT[] $rekonsiliasibankdetailTs
 * @property RekonsiliasibankrekeningM[] $rekonsiliasibankrekeningMs
 */
class JenisrekonsiliasibankM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisrekonsiliasibankM the static model class
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
		return 'jenisrekonsiliasibank_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisrekonsiliasibank_nama', 'required'),
			array('jenisrekonsiliasibank_nama, jenisrekonsiliasibank_namalain', 'length', 'max'=>100),
			array('jenisrekonsiliasibank_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisrekonsiliasibank_id, jenisrekonsiliasibank_nama, jenisrekonsiliasibank_namalain, jenisrekonsiliasibank_aktif', 'safe', 'on'=>'search'),
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
			'rekonsiliasibankdetailTs' => array(self::HAS_MANY, 'RekonsiliasibankdetailT', 'jenisrekonsiliasibank_id'),
			'rekonsiliasibankrekeningMs' => array(self::HAS_MANY, 'RekonsiliasibankrekeningM', 'jenisrekonsiliasibank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisrekonsiliasibank_id' => 'ID Jenis Rekonsiliasi Bank',
			'jenisrekonsiliasibank_nama' => 'Nama Jenis Rekonsiliasi Bank',
			'jenisrekonsiliasibank_namalain' => 'Nama Lainnya',
			'jenisrekonsiliasibank_aktif' => 'Aktif',
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

		if(!empty($this->jenisrekonsiliasibank_id)){
			$criteria->addCondition('jenisrekonsiliasibank_id = '.$this->jenisrekonsiliasibank_id);
		}
		$criteria->compare('LOWER(jenisrekonsiliasibank_nama)',strtolower($this->jenisrekonsiliasibank_nama),true);
		$criteria->compare('LOWER(jenisrekonsiliasibank_namalain)',strtolower($this->jenisrekonsiliasibank_namalain),true);
		$criteria->compare('jenisrekonsiliasibank_aktif', isset($this->jenisrekonsiliasibank_aktif)?$this->jenisrekonsiliasibank_aktif:true);

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