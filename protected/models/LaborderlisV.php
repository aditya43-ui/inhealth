<?php

/**
 * This is the model class for table "laborderlis_v".
 *
 * The followings are the available columns in table 'laborderlis_v':
 * @property integer $patientid
 * @property string $patientcode
 * @property string $patientname
 * @property string $calling
 * @property string $patientsexname
 * @property string $patientdob
 * @property string $patientaddress
 * @property string $patientcitycode
 * @property string $patientcityname
 * @property string $patientdistrictcode
 * @property string $patientdistrictname
 * @property string $patientvillagecode
 * @property string $patientvillagename
 * @property string $patientphonenumber
 * @property string $patientmobilenumber
 * @property string $patientemail
 * @property string $patientnik
 * @property string $visitenumber
 * @property string $ordernumber
 * @property string $orderdatetime
 * @property integer $doktorordercode
 * @property string $doctorordername
 * @property integer $doktormodcode
 * @property string $mod_name
 * @property string $diagnosiscode
 * @property string $diagnosisname
 * @property string $serviceunitcode
 * @property string $serviceunitname
 * @property string $guarantorid
 * @property string $guarantorname
 * @property integer $agreementid
 * @property string $agreementname
 * @property integer $serviceclasscode
 * @property string $serviceclassname
 * @property integer $wardroomcode
 * @property string $wardroomname
 * @property integer $bedcode
 * @property string $bedname
 * @property boolean $receivedflag
 * @property string $labregno_lis
 * @property string $receiveddatetime_lis
 * @property boolean $iscito
 * @property string $labresult
 * @property string $category_id
 * @property string $category_name
 */
class LaborderlisV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laborderlis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('patientid, doktorordercode, doktormodcode, agreementid, serviceclasscode, wardroomcode, bedcode', 'numerical', 'integerOnly'=>true),
			array('patientcode, patientvillagecode, diagnosiscode', 'length', 'max'=>10),
			array('patientname, patientemail, serviceunitname, wardroomname, labregno_lis', 'length', 'max'=>100),
			array('calling, patientsexname, patientmobilenumber, visitenumber', 'length', 'max'=>20),
			array('patientcityname, patientdistrictname, patientvillagename, doctorordername, mod_name, agreementname, serviceclassname', 'length', 'max'=>50),
			array('patientphonenumber', 'length', 'max'=>15),
			array('patientnik', 'length', 'max'=>30),
			array('diagnosisname', 'length', 'max'=>200),
			array('serviceunitcode', 'length', 'max'=>2),
			array('patientdob, patientaddress, patientcitycode, patientdistrictcode, ordernumber, orderdatetime, guarantorid, guarantorname, bedname, receivedflag, receiveddatetime_lis, iscito, labresult, category_id, category_name', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('patientid, patientcode, patientname, calling, patientsexname, patientdob, patientaddress, patientcitycode, patientcityname, patientdistrictcode, patientdistrictname, patientvillagecode, patientvillagename, patientphonenumber, patientmobilenumber, patientemail, patientnik, visitenumber, ordernumber, orderdatetime, doktorordercode, doctorordername, doktormodcode, mod_name, diagnosiscode, diagnosisname, serviceunitcode, serviceunitname, guarantorid, guarantorname, agreementid, agreementname, serviceclasscode, serviceclassname, wardroomcode, wardroomname, bedcode, bedname, receivedflag, labregno_lis, receiveddatetime_lis, iscito, labresult, category_id, category_name', 'safe', 'on'=>'search'),
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
			'patientid' => 'Patientid',
			'patientcode' => 'Patientcode',
			'patientname' => 'Patientname',
			'calling' => 'Calling',
			'patientsexname' => 'Patientsexname',
			'patientdob' => 'Patientdob',
			'patientaddress' => 'Patientaddress',
			'patientcitycode' => 'Patientcitycode',
			'patientcityname' => 'Patientcityname',
			'patientdistrictcode' => 'Patientdistrictcode',
			'patientdistrictname' => 'Patientdistrictname',
			'patientvillagecode' => 'Patientvillagecode',
			'patientvillagename' => 'Patientvillagename',
			'patientphonenumber' => 'Patientphonenumber',
			'patientmobilenumber' => 'Patientmobilenumber',
			'patientemail' => 'Patientemail',
			'patientnik' => 'Patientnik',
			'visitenumber' => 'Visitenumber',
			'ordernumber' => 'Ordernumber',
			'orderdatetime' => 'Orderdatetime',
			'doktorordercode' => 'Doktorordercode',
			'doctorordername' => 'Doctorordername',
			'doktormodcode' => 'Doktormodcode',
			'mod_name' => 'Mod Name',
			'diagnosiscode' => 'Diagnosiscode',
			'diagnosisname' => 'Diagnosisname',
			'serviceunitcode' => 'Serviceunitcode',
			'serviceunitname' => 'Serviceunitname',
			'guarantorid' => 'Guarantorid',
			'guarantorname' => 'Guarantorname',
			'agreementid' => 'Agreementid',
			'agreementname' => 'Agreementname',
			'serviceclasscode' => 'Serviceclasscode',
			'serviceclassname' => 'Serviceclassname',
			'wardroomcode' => 'Wardroomcode',
			'wardroomname' => 'Wardroomname',
			'bedcode' => 'Bedcode',
			'bedname' => 'Bedname',
			'receivedflag' => 'Receivedflag',
			'labregno_lis' => 'Labregno Lis',
			'receiveddatetime_lis' => 'Receiveddatetime Lis',
			'iscito' => 'Iscito',
			'labresult' => 'Labresult',
			'category_id' => 'Category',
			'category_name' => 'Category Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('patientid',$this->patientid);
		$criteria->compare('patientcode',$this->patientcode,true);
		$criteria->compare('patientname',$this->patientname,true);
		$criteria->compare('calling',$this->calling,true);
		$criteria->compare('patientsexname',$this->patientsexname,true);
		$criteria->compare('patientdob',$this->patientdob,true);
		$criteria->compare('patientaddress',$this->patientaddress,true);
		$criteria->compare('patientcitycode',$this->patientcitycode,true);
		$criteria->compare('patientcityname',$this->patientcityname,true);
		$criteria->compare('patientdistrictcode',$this->patientdistrictcode,true);
		$criteria->compare('patientdistrictname',$this->patientdistrictname,true);
		$criteria->compare('patientvillagecode',$this->patientvillagecode,true);
		$criteria->compare('patientvillagename',$this->patientvillagename,true);
		$criteria->compare('patientphonenumber',$this->patientphonenumber,true);
		$criteria->compare('patientmobilenumber',$this->patientmobilenumber,true);
		$criteria->compare('patientemail',$this->patientemail,true);
		$criteria->compare('patientnik',$this->patientnik,true);
		$criteria->compare('visitenumber',$this->visitenumber,true);
		$criteria->compare('ordernumber',$this->ordernumber,true);
		$criteria->compare('orderdatetime',$this->orderdatetime,true);
		$criteria->compare('doktorordercode',$this->doktorordercode);
		$criteria->compare('doctorordername',$this->doctorordername,true);
		$criteria->compare('doktormodcode',$this->doktormodcode);
		$criteria->compare('mod_name',$this->mod_name,true);
		$criteria->compare('diagnosiscode',$this->diagnosiscode,true);
		$criteria->compare('diagnosisname',$this->diagnosisname,true);
		$criteria->compare('serviceunitcode',$this->serviceunitcode,true);
		$criteria->compare('serviceunitname',$this->serviceunitname,true);
		$criteria->compare('guarantorid',$this->guarantorid,true);
		$criteria->compare('guarantorname',$this->guarantorname,true);
		$criteria->compare('agreementid',$this->agreementid);
		$criteria->compare('agreementname',$this->agreementname,true);
		$criteria->compare('serviceclasscode',$this->serviceclasscode);
		$criteria->compare('serviceclassname',$this->serviceclassname,true);
		$criteria->compare('wardroomcode',$this->wardroomcode);
		$criteria->compare('wardroomname',$this->wardroomname,true);
		$criteria->compare('bedcode',$this->bedcode);
		$criteria->compare('bedname',$this->bedname,true);
		$criteria->compare('receivedflag',$this->receivedflag);
		$criteria->compare('labregno_lis',$this->labregno_lis,true);
		$criteria->compare('receiveddatetime_lis',$this->receiveddatetime_lis,true);
		$criteria->compare('iscito',$this->iscito);
		$criteria->compare('labresult',$this->labresult,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('category_name',$this->category_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaborderlisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
