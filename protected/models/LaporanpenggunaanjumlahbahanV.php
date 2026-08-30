<?php

/**
 * This is the model class for table "laporanpenggunaanjumlahbahan_v".
 *
 * The followings are the available columns in table 'laporanpengirimanlinen_v':
 * @property string $jmlpemakaian
 * @property string $tglpencucianlinen
 * @property string $bahanperawatan_nama
 * @property string $satuanpemakaian
 */
class LaporanpenggunaanjumlahbahanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpenggunaanjumlahbahanV the static model class
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
		return 'laporanpenggunaanjumlahbahan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jmlpemakaian', 'numerical', 'integerOnly'=>true),
			array('bahanperawatan_nama', 'length', 'max'=>100),
			array('satuanpemakaian', 'length', 'max'=>50),
			array('tglpencucianlinen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jmlpemakaian, bahanperawatan_nama, satuanpemakaian, tglpencucianlinen', 'safe', 'on'=>'search'),
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
			'jmlpemakaian' => 'Nama Bahan',
			'bahanperawatan_nama' => 'Jumlah Bahan',
			'satuanpemakaian' => 'Satuan',	
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

		$criteria->compare('LOWER(jmlpemakaian)',strtolower($this->jmlpemakaian),true);
		$criteria->compare('LOWER(bahanperawatan_nama)',strtolower($this->bahanperawatan_nama),true);
		$criteria->compare('LOWER(tglpencucianlinen)',strtolower($this->tglpencucianlinen),true);
		$criteria->compare('LOWER(satuanpemakaian)',strtolower($this->satuanpemakaian),true);

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