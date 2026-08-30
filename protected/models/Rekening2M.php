<?php

/**
 * This is the model class for table "rekening2_m".
 *
 * The followings are the available columns in table 'rekening2_m':
 * @property integer $rekening2_id
 * @property integer $rekening1_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property string $nmrekeninglain2
 * @property string $rekening2_nb
 * @property boolean $rekening2_aktif
 */
class Rekening2M extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening2M the static model class
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
		return 'rekening2_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening1_id, kdrekening2, nmrekening2, nmrekeninglain2', 'required'),
			array('rekening1_id', 'numerical', 'integerOnly'=>true),
			array('kdrekening2', 'length', 'max'=>10),
			array('nmrekening2, nmrekeninglain2', 'length', 'max'=>200),
			array('rekening2_nb', 'length', 'max'=>1),
			array('rekening2_aktif,rekening2_nb', 'safe'),						
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening2_id, rekening1_id, kdrekening2, nmrekening2, nmrekeninglain2, rekening2_aktif', 'safe', 'on'=>'search'),
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
			'rekening2_id' => 'Rekening ID',
			'rekening1_id' => 'Rekening 1 ID',
			'kdrekening2' => 'Kode Akun',
			'nmrekening2' => 'Nama Akun',
			'nmrekeninglain2' => 'Nama Lain',
			'rekening2_nb' => 'Saldo Normal',
			'rekening2_aktif' => 'Status',
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

		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('LOWER(nmrekeninglain2)',strtolower($this->nmrekeninglain2),true);
		$criteria->compare('rekening2_aktif',$this->rekening2_aktif);
		$criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('LOWER(nmrekeninglain2)',strtolower($this->nmrekeninglain2),true);
		$criteria->compare('rekening2_aktif',$this->rekening2_aktif);
		$criteria->compare('LOWER(rekening2_nb)',strtolower($this->rekening2_nb),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}