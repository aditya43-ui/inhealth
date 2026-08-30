<?php

/**
 * This is the model class for table "outbox".
 *
 * The followings are the available columns in table 'outbox':
 * @property string $UpdatedInDB
 * @property string $InsertIntoDB
 * @property string $SendingDateTime
 * @property string $SendBefore
 * @property string $SendAfter
 * @property string $Text
 * @property string $DestinationNumber
 * @property string $Coding
 * @property string $UDH
 * @property integer $Class
 * @property string $TextDecoded
 * @property integer $ID
 * @property boolean $MultiPart
 * @property integer $RelativeValidity
 * @property string $SenderID
 * @property string $SendingTimeOut
 * @property string $DeliveryReport
 * @property string $CreatorID
 */
class Outbox extends CActiveRecord
{
	public $requestby;
	public $campaign;
	public $noaccent;
	public $is_masking = false;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Outbox the static model class
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
		return 'outbox';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CreatorID', 'required'),
			array('Class, RelativeValidity', 'numerical', 'integerOnly'=>true),
			array('DestinationNumber', 'length', 'max'=>20),
			array('Coding, SenderID', 'length', 'max'=>255),
			array('DeliveryReport', 'length', 'max'=>10),
			array('SendBefore, SendAfter, Text, UDH, TextDecoded, MultiPart', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UpdatedInDB, InsertIntoDB, SendingDateTime, SendBefore, SendAfter, Text, DestinationNumber, Coding, UDH, Class, TextDecoded, ID, MultiPart, RelativeValidity, SenderID, SendingTimeOut, DeliveryReport, CreatorID', 'safe', 'on'=>'search'),
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
			'InsertIntoDB' => 'Insert Into Db',
			'SendingDateTime' => 'Sending Date Time',
			'SendBefore' => 'Send Before',
			'SendAfter' => 'Send After',
			'Text' => 'Text',
			'DestinationNumber' => 'No. Tujuan',
			'Coding' => 'Coding',
			'UDH' => 'Udh',
			'Class' => 'Class',
			'TextDecoded' => 'Pesan Teks',
			'ID' => 'ID',
			'MultiPart' => 'Multi Part',
			'RelativeValidity' => 'Relative Validity',
			'SenderID' => 'Sender',
			'SendingTimeOut' => 'Sending Time Out',
			'DeliveryReport' => 'Delivery Report',
			'CreatorID' => 'Pembuat Pesan',
                        'destinationnumber' => 'No. Tujuan',
			'is_masking' =>' Gunakan SMS Blast',
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

		$criteria->compare('LOWER("UpdatedInDB")',strtolower($this->UpdatedInDB),true);
		$criteria->compare('LOWER("InsertIntoDB")',strtolower($this->InsertIntoDB),true);
		$criteria->compare('LOWER("SendingDateTime")',strtolower($this->SendingDateTime),true);
		$criteria->compare('LOWER("SendBefore")',strtolower($this->SendBefore),true);
		$criteria->compare('LOWER("SendAfter")',strtolower($this->SendAfter),true);
		$criteria->compare('LOWER("Text")',strtolower($this->Text),true);
		$criteria->compare('LOWER("DestinationNumber")',strtolower($this->DestinationNumber),true);
		$criteria->compare('LOWER("Coding")',strtolower($this->Coding),true);
		$criteria->compare('LOWER("UDH")',strtolower($this->UDH),true);
		$criteria->compare('Class',$this->Class);
		$criteria->compare('LOWER("TextDecoded")',strtolower($this->TextDecoded),true);
		$criteria->compare('"ID"',$this->ID);
		$criteria->compare('"MultiPart"',$this->MultiPart);
		$criteria->compare('"RelativeValidity"',$this->RelativeValidity);
		$criteria->compare('LOWER("SenderID")',strtolower($this->SenderID),true);
		$criteria->compare('LOWER("SendingTimeOut")',strtolower($this->SendingTimeOut),true);
		$criteria->compare('LOWER("DeliveryReport")',strtolower($this->DeliveryReport),true);
		$criteria->compare('LOWER("CreatorID")',strtolower($this->CreatorID),true);

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
						  'SendingDateTime'=>true
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
						  'SendingDateTime'=>true
						)
					  )
            ));
        }
}