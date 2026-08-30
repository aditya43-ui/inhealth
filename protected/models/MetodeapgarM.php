<?php

/**
 * This is the model class for table "metodeapgar_m".
 *
 * The followings are the available columns in table 'metodeapgar_m':
 * @property integer $metodeapgar_id
 * @property string $akronim
 * @property string $kriteria
 * @property string $nilai_2
 * @property string $nilai_1
 * @property string $nilai_0
 * @property boolean $metodeapgar_aktif
 */
class MetodeapgarM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MetodeapgarM the static model class
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
		return 'metodeapgar_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('akronim, kriteria, nilai_2, nilai_1, nilai_0', 'required'),
			array('akronim', 'length', 'max'=>50),
			array('kriteria', 'length', 'max'=>100),
			array('metodeapgar_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('metodeapgar_id, akronim, kriteria, nilai_2, nilai_1, nilai_0, metodeapgar_aktif', 'safe', 'on'=>'search'),
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
			'metodeapgar_id' => 'ID',
			'akronim' => 'Akronim',
			'kriteria' => 'Kriteria',
			'nilai_2' => 'Nilai 2',
			'nilai_1' => 'Nilai 1',
			'nilai_0' => 'Nilai 0',
			'metodeapgar_aktif' => 'Aktif',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('metodeapgar_id',$this->metodeapgar_id);
		$criteria->compare('LOWER(akronim)',strtolower($this->akronim),true);
		$criteria->compare('LOWER(kriteria)',strtolower($this->kriteria),true);
		$criteria->compare('LOWER(nilai_2)',strtolower($this->nilai_2),true);
		$criteria->compare('LOWER(nilai_1)',strtolower($this->nilai_1),true);
		$criteria->compare('LOWER(nilai_0)',strtolower($this->nilai_0),true);
		$criteria->compare('metodeapgar_aktif',isset($this->metodeapgar_aktif)?$this->metodeapgar_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('metodeapgar_id',$this->metodeapgar_id);
		$criteria->compare('LOWER(akronim)',strtolower($this->akronim),true);
		$criteria->compare('LOWER(kriteria)',strtolower($this->kriteria),true);
		$criteria->compare('LOWER(nilai_2)',strtolower($this->nilai_2),true);
		$criteria->compare('LOWER(nilai_1)',strtolower($this->nilai_1),true);
		$criteria->compare('LOWER(nilai_0)',strtolower($this->nilai_0),true);
		$criteria->compare('metodeapgar_aktif',$this->metodeapgar_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}