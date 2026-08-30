<?php

/**
 * This is the model class for table "komentar_s".
 *
 * The followings are the available columns in table 'komentar_s':
 * @property integer $komentar_id
 * @property string $tglkomentar
 * @property string $namakomentar
 * @property string $deskripsikomentat
 * @property string $emailkomentar
 * @property string $websitekomentar
 * @property boolean $komentar_tampilkan
 * @property string $instanasi
 */
class KomentarS extends CActiveRecord
{
	public $verifyCode;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomentarS the static model class
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
		return 'komentar_s';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglkomentar, namakomentar, deskripsikomentat, emailkomentar', 'required'),
			array('namakomentar, emailkomentar, instanasi', 'length', 'max'=>100),
			array('websitekomentar', 'length', 'max'=>50),
			array('komentar_tampilkan', 'safe'),
//			array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komentar_id, tglkomentar, namakomentar, deskripsikomentat, emailkomentar, websitekomentar, komentar_tampilkan, instanasi', 'safe', 'on'=>'search'),
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
			'komentar_id' => 'Komentar',
			'tglkomentar' => 'Tglkomentar',
			'namakomentar' => 'Nama',
			'deskripsikomentat' => 'Komentar',
			'emailkomentar' => 'Email',
			'websitekomentar' => 'Website',
			'komentar_tampilkan' => 'Komentar Tampilkan',
			'instanasi' => 'Instansi',
			'verifyCode'=>'Verification Code',
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

		$criteria->compare('komentar_id',$this->komentar_id);
		$criteria->compare('LOWER(tglkomentar)',strtolower($this->tglkomentar),true);
		$criteria->compare('LOWER(namakomentar)',strtolower($this->namakomentar),true);
		$criteria->compare('LOWER(deskripsikomentat)',strtolower($this->deskripsikomentat),true);
		$criteria->compare('LOWER(emailkomentar)',strtolower($this->emailkomentar),true);
		$criteria->compare('LOWER(websitekomentar)',strtolower($this->websitekomentar),true);
		$criteria->compare('komentar_tampilkan',$this->komentar_tampilkan);
		$criteria->compare('LOWER(instanasi)',strtolower($this->instanasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('komentar_id',$this->komentar_id);
		$criteria->compare('LOWER(tglkomentar)',strtolower($this->tglkomentar),true);
		$criteria->compare('LOWER(namakomentar)',strtolower($this->namakomentar),true);
		$criteria->compare('LOWER(deskripsikomentat)',strtolower($this->deskripsikomentat),true);
		$criteria->compare('LOWER(emailkomentar)',strtolower($this->emailkomentar),true);
		$criteria->compare('LOWER(websitekomentar)',strtolower($this->websitekomentar),true);
		$criteria->compare('komentar_tampilkan',$this->komentar_tampilkan);
		$criteria->compare('LOWER(instanasi)',strtolower($this->instanasi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}