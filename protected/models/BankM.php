<?php

/**
 * This is the model class for table "bank_m".
 *
 * The followings are the available columns in table 'bank_m':
 * @property integer $bank_id
 * @property integer $propinsi_id
 * @property integer $matauang_id
 * @property integer $kabupaten_id
 * @property string $namabank
 * @property string $norekening
 * @property string $alamatbank
 * @property string $telpbank1
 * @property string $telpbank2
 * @property string $faxbank
 * @property string $emailbank
 * @property string $website
 * @property string $kodepos
 * @property string $cabangdari
 * @property string $negara
 * @property boolean $bank_aktif
 */
class BankM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
        public $rekDebit, $rekKredit, $create_time, $create_loginpemakai_id, $create_ruangan, $rekening4_id;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bank_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namabank, norekening', 'required'),
			array('propinsi_id, matauang_id, kabupaten_id, profilrs_id', 'numerical', 'integerOnly'=>true),
			array('namabank, norekening, cabangdari, negara', 'length', 'max'=>100),
			array('telpbank1, telpbank2, faxbank, emailbank, website, kodepos', 'length', 'max'=>50),
			array('alamatbank, bank_aktif, bank_atasnama, ispenerimaan, ispengeluaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bank_atasnama, bank_id, propinsi_id, matauang_id, kabupaten_id, namabank, norekening, alamatbank, telpbank1, telpbank2, faxbank, emailbank, website, kodepos, cabangdari, negara, bank_aktif, ispenerimaan, ispengeluaran, profilrs_id', 'safe', 'on'=>'search'),
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
                    'propinsi'=>array(self::BELONGS_TO,'PropinsiM','propinsi_id'),
                    'kabupaten'=>array(self::BELONGS_TO,'KabupatenM','kabupaten_id'),
                    'matauang'=>array(self::BELONGS_TO,'MatauangM','matauang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bank_id' => 'Bank',
			'propinsi_id' => 'Provinsi',
			'matauang_id' => 'Mata Uang',
			'kabupaten_id' => 'Kabupaten',
			'namabank' => 'Nama Bank',
			'norekening' => 'No. Rekening',
			'alamatbank' => 'Alamat Bank',
			'telpbank1' => 'Telp Bank 1',
			'telpbank2' => 'Telp Bank 2',
			'faxbank' => 'Fax Bank',
			'emailbank' => 'Email Bank',
			'website' => 'Website',
			'kodepos' => 'Kode Pos',
			'cabangdari' => 'Cabang dari',
			'negara' => 'Negara',
			'bank_aktif' => 'Bank Aktif',
            'bank_atasnama' => 'Atas Nama',
                    'ispenerimaan'=> 'Penerimaan'
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

		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(telpbank1)',strtolower($this->telpbank1),true);
		$criteria->compare('LOWER(telpbank2)',strtolower($this->telpbank2),true);
		$criteria->compare('LOWER(faxbank)',strtolower($this->faxbank),true);
		$criteria->compare('LOWER(emailbank)',strtolower($this->emailbank),true);
		$criteria->compare('LOWER(website)',strtolower($this->website),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(cabangdari)',strtolower($this->cabangdari),true);
		$criteria->compare('LOWER(negara)',strtolower($this->negara),true);
		$criteria->compare('bank_aktif',$this->bank_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchBank()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(telpbank1)',strtolower($this->telpbank1),true);
		$criteria->compare('LOWER(telpbank2)',strtolower($this->telpbank2),true);
		$criteria->compare('LOWER(faxbank)',strtolower($this->faxbank),true);
		$criteria->compare('LOWER(emailbank)',strtolower($this->emailbank),true);
		$criteria->compare('LOWER(website)',strtolower($this->website),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(cabangdari)',strtolower($this->cabangdari),true);
		$criteria->compare('LOWER(negara)',strtolower($this->negara),true);
                $criteria->addCondition("bank_id not in (select bank_id from bankrek_m)");
		$criteria->compare('bank_aktif',$this->bank_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

        $criteria=new CDbCriteria;
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(telpbank1)',strtolower($this->telpbank1),true);
		$criteria->compare('LOWER(telpbank2)',strtolower($this->telpbank2),true);
		$criteria->compare('LOWER(faxbank)',strtolower($this->faxbank),true);
		$criteria->compare('LOWER(emailbank)',strtolower($this->emailbank),true);
		$criteria->compare('LOWER(website)',strtolower($this->website),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(cabangdari)',strtolower($this->cabangdari),true);
		$criteria->compare('LOWER(negara)',strtolower($this->negara),true);
		$criteria->compare('bank_aktif',$this->bank_aktif);
               //  Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }

        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            if(!empty($propinsi_id))
                return KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true),array('order'=>'kabupaten_nama'));
            else {
                return array();
			}
        }

		public static function getItems() {
        $criteria = new CDbCriteria();
        $criteria->addCondition("bank_aktif = TRUE");
        $criteria->order = "namabank";

        return self::model()->findAll($criteria);
    }

	public function searchBank2($print = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('matauang_id',$this->matauang_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekening)',strtolower($this->norekening),true);
		$criteria->compare('LOWER(alamatbank)',strtolower($this->alamatbank),true);
		$criteria->compare('LOWER(telpbank1)',strtolower($this->telpbank1),true);
		$criteria->compare('LOWER(telpbank2)',strtolower($this->telpbank2),true);
		$criteria->compare('LOWER(faxbank)',strtolower($this->faxbank),true);
		$criteria->compare('LOWER(emailbank)',strtolower($this->emailbank),true);
		$criteria->compare('LOWER(website)',strtolower($this->website),true);
		$criteria->compare('LOWER(kodepos)',strtolower($this->kodepos),true);
		$criteria->compare('LOWER(cabangdari)',strtolower($this->cabangdari),true);
		$criteria->compare('LOWER(negara)',strtolower($this->negara),true);
                //$criteria->addCondition("bank_id not in (select bank_id from bankrek_m)");
		$criteria->compare('bank_aktif',$this->bank_aktif);
		if ($print) $criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getBankNoRekening() {
        return $this->namabank.(empty($this->norekening) ? "" : " - ".$this->norekening);
    }

    public function getBankDanAtasNama() {
        return $this->namabank." - ".$this->bank_atasnama;
    }
}

?>
