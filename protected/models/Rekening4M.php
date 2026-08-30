<?php

/**
 * This is the model class for table "rekening4_m".
 *
 * The followings are the available columns in table 'rekening4_m':
 * @property integer $rekening4_id
 * @property integer $rekening3_id
 * @property integer $rekening2_id
 * @property integer $rekening1_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property string $nmrekeninglain4
 * @property string $rekening4_nb
 * @property boolean $rekening4_aktif
 */
class Rekening4M extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening4M the static model class
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
		return 'rekening4_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kdrekening4, nmrekening4, nmrekeninglain4', 'required'),
			array('rekening3_id', 'numerical', 'integerOnly'=>true),
			array('kdrekening4', 'length', 'max'=>10),
			array('nmrekening4, nmrekeninglain4', 'length', 'max'=>400),
			array('rekening4_nb', 'length', 'max'=>1),
			array('rekening4_aktif, rekening4_nb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening4_id, rekening3_id, kdrekening4, nmrekening4, nmrekeninglain4, rekening4_aktif', 'safe', 'on'=>'search'),
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
			'rekening4_id' => 'Rekening ID 4',
			'rekening3_id' => 'Rekening ID 3',
			'kdrekening4' => 'Kode Akun',
			'nmrekening4' => 'Nama Akun',
			'nmrekeninglain4' => 'Nama Lain',
			'rekening4_nb' => 'Saldo Normal',
			'rekening4_aktif' => 'Status',
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

		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('LOWER(nmrekeninglain4)',strtolower($this->nmrekeninglain4),true);
		$criteria->compare('rekening4_aktif',$this->rekening4_aktif);
		$criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('LOWER(nmrekeninglain4)',strtolower($this->nmrekeninglain4),true);
		$criteria->compare('rekening4_aktif',$this->rekening4_aktif);
		$criteria->compare('LOWER(rekening4_nb)',strtolower($this->rekening4_nb),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}