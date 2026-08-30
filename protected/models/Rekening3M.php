<?php

/**
 * This is the model class for table "rekening3_m".
 *
 * The followings are the available columns in table 'rekening3_m':
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property integer $rekening2_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property string $nmrekeninglain3
 * @property string $rekening3_nb
 * @property boolean $rekening3_aktif
 */
class Rekening3M extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening3M the static model class
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
		return 'rekening3_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening2_id, kdrekening3, nmrekening3, nmrekeninglain3', 'required'),
			array('rekening2_id', 'numerical', 'integerOnly'=>true),
			array('kdrekening3', 'length', 'max'=>6),
			array('nmrekening3, nmrekeninglain3', 'length', 'max'=>300),
			array('rekening3_nb', 'length', 'max'=>1),
			array('rekening3_aktif, rekening3_nb', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening3_id, rekening2_id, kdrekening3, nmrekening3, nmrekeninglain3, rekening3_aktif', 'safe', 'on'=>'search'),
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
			'rekening3_id' => 'Rekening ID 3',
//			'rekening1_id' => 'Rekening ID 1',
			'rekening2_id' => 'Rekening ID 2',
			'kdrekening3' => 'Kode Akun',
			'nmrekening3' => 'Nama Akun',
			'nmrekeninglain3' => 'Nama Lain',
			'rekening3_nb' => 'Saldo Normal',
			'rekening3_aktif' => 'Status',
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

		$criteria->compare('rekening3_id',$this->rekening3_id);
//		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('LOWER(nmrekeninglain3)',strtolower($this->nmrekeninglain3),true);
		$criteria->compare('rekening3_aktif',$this->rekening3_aktif);
		$criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('rekening3_id',$this->rekening3_id);
//		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('LOWER(nmrekeninglain3)',strtolower($this->nmrekeninglain3),true);
		$criteria->compare('rekening3_aktif',$this->rekening3_aktif);
		$criteria->compare('LOWER(rekening3_nb)',strtolower($this->rekening3_nb),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}