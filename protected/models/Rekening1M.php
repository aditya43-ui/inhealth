<?php

/**
 * This is the model class for table "rekening1_m".
 *
 * The followings are the available columns in table 'rekening1_m':
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property string $nmrekeninglain1
 * @property string $rekening1_nb
 * @property boolean $rekening1_aktif
 */
class Rekening1M extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening1M the static model class
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
		return 'rekening1_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kdrekening1, nmrekening1, nmrekeninglain1, kelrekening_id, kelrekening_id', 'required'),
			array('kdrekening1', 'length', 'max'=>10),
			array('nmrekening1, nmrekeninglain1', 'length', 'max'=>100),
			array('rekening1_nb', 'length', 'max'=>1),
			array('rekening1_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening1_nb,rekening1_id, kdrekening1, nmrekening1, nmrekeninglain1, kelrekening_id, rekening1_aktif', 'safe', 'on'=>'search'),
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
            //            'kelrekening_id' => 'Kelompok Rekening',
			'rekening1_id' => 'Rekening ID',
			'kdrekening1' => 'Kode Akun',
			'nmrekening1' => 'Nama Akun',
			'nmrekeninglain1' => 'Nama Lain',
			'kelrekening_id' => 'Kelompok Akun',
			'rekening1_aktif' => 'Status',
			'rekening1_nb' => 'Saldo Normal',
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

		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('LOWER(nmrekeninglain1)',strtolower($this->nmrekeninglain1),true);
		$criteria->compare('LOWER(kelrekening_id)',strtolower($this->kelrekening_id),true);
		$criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
		$criteria->compare('rekening1_aktif',$this->rekening1_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('LOWER(nmrekeninglain1)',strtolower($this->nmrekeninglain1),true);
		$criteria->compare('LOWER(kelrekening_id)',strtolower($this->kelrekening_id),true);
		$criteria->compare('LOWER(rekening1_nb)',strtolower($this->rekening1_nb),true);
		$criteria->compare('rekening1_aktif',$this->rekening1_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}