<?php

/**
 * This is the model class for table "diagnosatindakan_m".
 *
 * The followings are the available columns in table 'diagnosatindakan_m':
 * @property integer $diagnosatindakan_id
 * @property string $diagnosatindakan_kode
 * @property string $diagnosatindakan_nama
 * @property string $diagnosatindakan_namalainnya
 * @property string $diagnosatindakan_katakunci
 * @property integer $diagnosatindakan_nourut
 * @property boolean $diagnosatindakan_aktif
 */
class DiagnosatindakanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosatindakanM the static model class
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
		return 'diagnosatindakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosatindakan_nama', 'required'),
			array('diagnosatindakan_nourut', 'numerical', 'integerOnly'=>true),
			array('diagnosatindakan_kode', 'length', 'max'=>10),
			array('diagnosatindakan_nama, diagnosatindakan_namalainnya, diagnosatindakan_katakunci', 'length', 'max'=>50),
			array('diagnosatindakan_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('diagnosatindakan_id, diagnosatindakan_kode, diagnosatindakan_nama, diagnosatindakan_namalainnya, diagnosatindakan_katakunci, diagnosatindakan_nourut, diagnosatindakan_aktif', 'safe', 'on'=>'search'),
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
			'diagnosatindakan_id' => 'ID',
			'diagnosatindakan_kode' => 'Kode',
			'diagnosatindakan_nama' => 'Nama Diagnosa',
			'diagnosatindakan_namalainnya' => 'Nama Lain',
			'diagnosatindakan_katakunci' => 'Kata Kunci',
			'diagnosatindakan_nourut' => 'No. Urut',
			'diagnosatindakan_aktif' => 'Aktif',
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

		$criteria->compare('diagnosatindakan_id',$this->diagnosatindakan_id);
		$criteria->compare('LOWER(diagnosatindakan_kode)',strtolower($this->diagnosatindakan_kode),true);
		$criteria->compare('LOWER(diagnosatindakan_nama)',strtolower($this->diagnosatindakan_nama),true);
		$criteria->compare('LOWER(diagnosatindakan_namalainnya)',strtolower($this->diagnosatindakan_namalainnya),true);
		$criteria->compare('LOWER(diagnosatindakan_katakunci)',strtolower($this->diagnosatindakan_katakunci),true);
		$criteria->compare('diagnosatindakan_nourut',$this->diagnosatindakan_nourut);
//		$criteria->compare('diagnosatindakan_aktif',$this->diagnosatindakan_aktif);
                $criteria->addCondition('diagnosatindakan_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('diagnosatindakan_id',$this->diagnosatindakan_id);
		$criteria->compare('LOWER(diagnosatindakan_kode)',strtolower($this->diagnosatindakan_kode),true);
		$criteria->compare('LOWER(diagnosatindakan_nama)',strtolower($this->diagnosatindakan_nama),true);
		$criteria->compare('LOWER(diagnosatindakan_namalainnya)',strtolower($this->diagnosatindakan_namalainnya),true);
		$criteria->compare('LOWER(diagnosatindakan_katakunci)',strtolower($this->diagnosatindakan_katakunci),true);
		$criteria->compare('diagnosatindakan_nourut',$this->diagnosatindakan_nourut);
//		$criteria->compare('diagnosatindakan_aktif',$this->diagnosatindakan_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
         public function beforeSave() {
            $this->diagnosatindakan_nama = ucwords(strtolower($this->diagnosatindakan_nama));
            $this->diagnosatindakan_namalainnya = strtoupper($this->diagnosatindakan_namalainnya);
            $this->diagnosatindakan_kode = strtoupper($this->diagnosatindakan_kode);
            $this->diagnosatindakan_katakunci = strtoupper($this->diagnosatindakan_katakunci);

            return parent::beforeSave();
        }
}