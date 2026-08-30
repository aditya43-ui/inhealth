<?php

/**
 * This is the model class for table "bankrek_m".
 *
 * The followings are the available columns in table 'bankrek_m':
 * @property integer $bankrek_id
 * @property integer $rekening4_id
 * @property integer $rekening3_id
 * @property integer $rekening2_id
 * @property integer $bank_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $saldonormal
 */
class BankrekM extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankrekM the static model class
	 */
	public $namaBank,$rekKredit,$rekDebit,$propinsi_id,$kabupaten_id,$kodepos,$website,
               $faxbank,$negara,$matauang_id,$namabank,$alamatbank,$norekening,$telpbank1,
               $telpbank2,$emailbank,$cabangdari,$bank_aktif,$nmrekening5,$nmrekening5_lain;
        
        public $propinsi_nama, $matauang, $kabupaten_nama, $kdrekening5, $nmrekening3, $nmrekening4, $kdrekening4;
        
        public $rekening_debit, $rekeningKredit, $create_time, $create_loginpemakai_id, $create_ruangan;
		

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'bankrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bank_id, saldonormal',  'required'),
			array('rekening4_id, rekening3_id, rekening2_id, bank_id, rekening5_id, rekening1_id', 'numerical', 'integerOnly'=>true),
			array('saldonormal', 'length', 'max'=>10),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bankrek_id, rekening4_id, rekening_debit, rekeningKredit, propinsi_nama, matauang, kabupaten_nama, propinsi_id, kabupaten_id, kodepos, nmrekening5, nmrekening5_lain, website, faxbank, negara, matauang_id, namabank, alamatbank, norekening, telpbank1, telpbank2, emailbank, cabangdari, bank_aktif, namaBank,rekKredit,rekDebit, rekening3_id, rekening2_id, bank_id, rekening5_id, rekening1_id, saldonormal', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'rekeningdebit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'rekeningkredit' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),						
			'rekening4'=>array(self::BELONGS_TO,'Rekening4M','rekening4_id'),
			'rekening3'=>array(self::BELONGS_TO,'Rekening3M','rekening3_id'),
			'rekening2'=>array(self::BELONGS_TO,'Rekening2M','rekening2_id'),
			'rekening1'=>array(self::BELONGS_TO,'Rekening1M','rekening1_id'),
			'bank'=>array(self::BELONGS_TO,'BankM','bank_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'bankrek_id' => 'Bankrek',
			'rekening4_id' => 'Rekening4',
			'rekening3_id' => 'Rekening3',
			'rekening2_id' => 'Rekening2',
			'bank_id' => 'Bank',
			'rekening5_id' => 'Rekening5',
			'rekening1_id' => 'Rekening1',
			'saldonormal' => 'Saldo Normal',
			'propinsi_id'=>'Provinsi',
			'kabupaten_id'=>'Kabupaten',
			'telpbank1'=>'Telp Bank 1',
			'telpbank2'=>'Telp Bank 2',
			'website'=>'Website',
			'matauang_id'=>'Mata Uang',
			'kodepos'=>'Kode Pos',
			'faxbank'=>'Fax Bank',
			'namabank'=>'Nama Bank',
			'alamatbank'=>'Alamat Bank',
			'norekening'=>'No. Rekening',
			'emailbank'=>'Email Bank',
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

		$criteria->compare('bankrek_id',$this->bankrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('bankrek_id',$this->bankrek_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(saldonormal)',strtolower($this->saldonormal),true);
//		$criteria->compare('LOWER(saldonormal)', strtolower($this->saldonormal), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function getPropinsiItems() {
		return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif' => true), array('order' => 'propinsi_nama'));
	}

	/**
	 * Mengambil daftar semua kabupaten berdasarkan propinsi
	 * @return CActiveDataProvider 
	 */
	public function getKabupatenItems($propinsi_id = null) {
		if (!empty($propinsi_id))
			return KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $propinsi_id, 'kabupaten_aktif' => true), array('order' => 'kabupaten_nama'));
		else {
			return array();
		}
	}

}
