<?php

/**
 * This is the model class for table "laporanpengirimanlinen_v".
 *
 * The followings are the available columns in table 'laporanpengirimanlinen_v':
 * @property string $pengperawatanlinen_no
 * @property string $tglpengperawatanlinen
 * @property string $instalasi_nama
 * @property string $ruangan_nama
 */
class LaporanpengirimanlinenV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengirimanlinenV the static model class
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
		return 'laporanpengirimanlinen_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengperawatanlinen_no', 'length', 'max'=>20),
			array('instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('tglpengperawatanlinen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengperawatanlinen_no, tglpengperawatanlinen, instalasi_nama, ruangan_nama', 'safe', 'on'=>'search'),
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
			'pengperawatanlinen_no' => 'Pengperawatanlinen No',
			'tglpengperawatanlinen' => 'Tglpengperawatanlinen',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_nama' => 'Ruangan Nama',
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

		$criteria->compare('LOWER(pengperawatanlinen_no)',strtolower($this->pengperawatanlinen_no),true);
		$criteria->compare('LOWER(tglpengperawatanlinen)',strtolower($this->tglpengperawatanlinen),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);

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