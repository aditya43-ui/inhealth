<?php

/**
 * This is the model class for table "inbox".
 *
 * The followings are the available columns in table 'inbox':
 * @property string $UpdatedInDB
 * @property string $ReceivingDateTime
 * @property string $Text
 * @property string $SenderNumber
 * @property string $Coding
 * @property string $UDH
 * @property string $SMSCNumber
 * @property integer $Class
 * @property string $TextDecoded
 * @property integer $ID
 * @property string $RecipientID
 * @property boolean $Processed
 */
class Inbox extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inbox the static model class
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
		return 'inbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UpdatedInDB, ReceivingDateTime, Text, UDH, Class, RecipientID', 'required'),
			array('Class', 'numerical', 'integerOnly'=>true),
			array('SenderNumber, SMSCNumber', 'length', 'max'=>20),
			array('Coding', 'length', 'max'=>255),
			array('TextDecoded, Processed', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UpdatedInDB, ReceivingDateTime, Text, SenderNumber, Coding, UDH, SMSCNumber, Class, TextDecoded, ID, RecipientID, Processed', 'safe', 'on'=>'search'),
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
			'UpdatedInDB' => 'Updated In Db',
			'ReceivingDateTime' => 'Waktu Diterima',
			'Text' => 'Text',
			'SenderNumber' => 'Nomor Pengirim',
			'Coding' => 'Coding',
			'UDH' => 'Udh',
			'SMSCNumber' => 'Nomor SMSC',
			'Class' => 'Class',
			'TextDecoded' => 'Isi Pesan Teks',
			'ID' => 'ID',
			'RecipientID' => 'Recipient',
			'Processed' => 'Processed',
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

		// $criteria->compare('LOWER("UpdatedInDB")',strtolower($this->UpdatedInDB),true);
		// $criteria->compare('LOWER("ReceivingDateTime")',strtolower($this->ReceivingDateTime),true);
		$criteria->compare('LOWER("Text")',strtolower($this->Text),true);
		$criteria->compare('LOWER("SenderNumber")',strtolower($this->SenderNumber),true);
		$criteria->compare('LOWER("Coding")',strtolower($this->Coding),true);
		$criteria->compare('LOWER("UDH")',strtolower($this->UDH),true);
		$criteria->compare('LOWER("SMSCNumber")',strtolower($this->SMSCNumber),true);
		$criteria->compare('Class',$this->Class);
		$criteria->compare('LOWER("TextDecoded")',strtolower($this->TextDecoded),true);
		$criteria->compare('"ID"',$this->ID);
		$criteria->compare('LOWER("RecipientID")',strtolower($this->RecipientID),true);
		$criteria->compare('"Processed"',$this->Processed);

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
					'sort'=>array(
						'defaultOrder'=>array(
						  'ReceivingDateTime'=>true
						)
					  )

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
					'sort'=>array(
						'defaultOrder'=>array(
						  'ReceivingDateTime'=>true
						)
					  )
            ));
        }
}