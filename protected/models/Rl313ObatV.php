<?php

/**
 * This is the model class for table "rl3_13_obat_v".
 *
 * The followings are the available columns in table 'rl3_13_obat_v':
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $koders
 * @property integer $profilrs_id
 * @property string $kabupaten
 * @property string $namars
 * @property string $golonganobat
 * @property string $jumlahitemobat
 * @property string $jumlahitemobattersedia
 * @property string $jumlahitemobatformulatoriumtersedia
 * @property string $rawatjalan
 * @property string $rawatdarurat
 * @property string $rawatinap
 */
class Rl313ObatV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rl313ObatV the static model class
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
		return 'rl3_13_obat_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('propinsi, koders, kabupaten, namars, golonganobat', 'length', 'max'=>50),
			array('date, jumlahitemobat, jumlahitemobattersedia, jumlahitemobatformulatoriumtersedia, rawatjalan, rawatdarurat, rawatinap', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, propinsi, koders, profilrs_id, kabupaten, namars, golonganobat, jumlahitemobat, jumlahitemobattersedia, jumlahitemobatformulatoriumtersedia, rawatjalan, rawatdarurat, rawatinap', 'safe', 'on'=>'search'),
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
			'date' => 'Tgl. Laporan',
			'propinsi' => 'Provinsi',
			'koders' => 'Koders',
			'profilrs_id' => 'Profilrs',
			'kabupaten' => 'Kabupaten',
			'namars' => 'Namars',
			'golonganobat' => 'Golonganobat',
			'jumlahitemobat' => 'Jumlahitemobat',
			'jumlahitemobattersedia' => 'Jumlahitemobattersedia',
			'jumlahitemobatformulatoriumtersedia' => 'Jumlahitemobatformulatoriumtersedia',
			'rawatjalan' => 'Rawatjalan',
			'rawatdarurat' => 'Rawatdarurat',
			'rawatinap' => 'Rawatinap',
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

		$criteria->compare('DATE(date)',$this->date);
		$criteria->compare('LOWER(propinsi)',strtolower($this->propinsi),true);
		$criteria->compare('LOWER(koders)',strtolower($this->koders),true);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		$criteria->compare('LOWER(kabupaten)',strtolower($this->kabupaten),true);
		$criteria->compare('LOWER(namars)',strtolower($this->namars),true);
		$criteria->compare('LOWER(golonganobat)',strtolower($this->golonganobat),true);
		$criteria->compare('LOWER(jumlahitemobat)',strtolower($this->jumlahitemobat),true);
		$criteria->compare('LOWER(jumlahitemobattersedia)',strtolower($this->jumlahitemobattersedia),true);
		$criteria->compare('LOWER(jumlahitemobatformulatoriumtersedia)',strtolower($this->jumlahitemobatformulatoriumtersedia),true);
		$criteria->compare('LOWER(rawatjalan)',strtolower($this->rawatjalan),true);
		$criteria->compare('LOWER(rawatdarurat)',strtolower($this->rawatdarurat),true);
		$criteria->compare('LOWER(rawatinap)',strtolower($this->rawatinap),true);

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