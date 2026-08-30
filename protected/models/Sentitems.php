<?php

/**
 * This is the model class for table "sentitems".
 *
 * The followings are the available columns in table 'sentitems':
 * @property string $UpdatedInDB
 * @property string $InsertIntoDB
 * @property string $SendingDateTime
 * @property string $DeliveryDateTime
 * @property string $Text
 * @property string $DestinationNumber
 * @property string $Coding
 * @property string $UDH
 * @property string $SMSCNumber
 * @property integer $Class
 * @property string $TextDecoded
 * @property integer $ID
 * @property string $SenderID
 * @property integer $SequencePosition
 * @property string $Status
 * @property integer $StatusError
 * @property integer $TPMR
 * @property integer $RelativeValidity
 * @property string $CreatorID
 */
class Sentitems extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sentitems the static model class
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
		return 'sentitems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UpdatedInDB, InsertIntoDB, SendingDateTime, Text, Class, SenderID, StatusError, TPMR, RelativeValidity, CreatorID', 'required'),
			array('Class, SequencePosition, StatusError, TPMR, RelativeValidity', 'numerical', 'integerOnly'=>true),
			array('DestinationNumber, SMSCNumber', 'length', 'max'=>20),
			array('Coding, SenderID, Status', 'length', 'max'=>255),
			array('DeliveryDateTime, TextDecoded', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('UpdatedInDB, InsertIntoDB, SendingDateTime, DeliveryDateTime, Text, DestinationNumber, Coding, UDH, SMSCNumber, Class, TextDecoded, ID, SenderID, SequencePosition, Status, StatusError, TPMR, RelativeValidity, CreatorID', 'safe', 'on'=>'search'),
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
			'SendingDateTime' => 'Waktu Terkirim',
			'DeliveryDateTime' => 'Delivery Date Time',
			'Text' => 'Text',
			'DestinationNumber' => 'Nomor Tujuan',
			'Coding' => 'Coding',
			'UDH' => 'Udh',
			'SMSCNumber' => 'Nomor SMS Center',
			'Class' => 'Class',
			'TextDecoded' => 'Isi Pesan Teks',
			'ID' => 'ID',
			'SenderID' => 'Sender',
			'SequencePosition' => 'Sequence Position',
			'Status' => 'Status',
			'StatusError' => 'Status Error',
			'TPMR' => 'Tpmr',
			'RelativeValidity' => 'Relative Validity',
			'CreatorID' => 'Creator',
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

		$criteria->compare('("UpdatedInDB")',($this->UpdatedInDB));
		$criteria->compare('("InsertIntoDB")',($this->InsertIntoDB));
		// $criteria->compare('("SendingDateTime")',($this->SendingDateTime));
		$criteria->compare('("DeliveryDateTime")',($this->DeliveryDateTime));
		$criteria->compare('LOWER("Text")',strtolower($this->Text),true);
		$criteria->compare('LOWER("DestinationNumber")',strtolower($this->DestinationNumber),true);
		$criteria->compare('LOWER("Coding")',strtolower($this->Coding),true);
		$criteria->compare('LOWER("UDH")',strtolower($this->UDH),true);
		$criteria->compare('LOWER("SMSCNumber")',strtolower($this->SMSCNumber),true);
		$criteria->compare('"Class"',$this->Class);
		$criteria->compare('LOWER("TextDecoded")',strtolower($this->TextDecoded),true);
		$criteria->compare('"ID"',$this->ID);
		$criteria->compare('LOWER("SenderID")',strtolower($this->SenderID),true);
		$criteria->compare('"SequencePosition"',$this->SequencePosition);
		$criteria->compare('LOWER("Status")',strtolower($this->Status),true);
		$criteria->compare('"StatusError"',$this->StatusError);
		$criteria->compare('"TPMR"',$this->TPMR);
		$criteria->compare('"RelativeValidity"',$this->RelativeValidity);
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
						  'SendingDateTime"'=>true
						)
					  )
            ));
        }

        public function searchTable()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->select = array('"ID"','string_agg("TextDecoded", \'\') as "TextDecoded"','max("SendingDateTime") as "SendingDateTime"','"SMSCNumber"','"DestinationNumber"','"Status"','"SenderID"');
            $criteria->group = '"ID","TextDecoded","SendingDateTime","SMSCNumber","DestinationNumber","Status","SenderID"';
            $SendingDateTime = $this->SendingDateTime;
            

			$Tgl = (explode(" - ",$SendingDateTime));
            
            /*
            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            $criteria->addBetweenCondition('DATE("SendingDateTime")', $Tgl[0], $Tgl[1]);
             * 
             */

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
					'sort'=>array(
						'defaultOrder'=>'"SendingDateTime"'
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