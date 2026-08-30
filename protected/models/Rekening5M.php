<?php

/**
 * This is the model class for table "rekening5_m".
 *
 * The followings are the available columns in table 'rekening5_m':
 * @property integer $rekening5_id
 * @property integer $rekening4_id
 * @property integer $tiperekening_id
 * @property integer $rekening2_id
 * @property integer $rekening3_id
 * @property integer $rekening1_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property string $nmrekeninglain5
 * @property string $rekening5_nb
 * @property string $keterangan
 * @property integer $nourutrek
 * @property boolean $rekening5_aktif
 * @property string $kelompokrek
 * @property boolean $sak
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class Rekening5M extends CActiveRecord {
	public $tr_class;

	public $rek_column, $periodeposting_id, $rekperiod_id, $saldoawal_id, $rekening4_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rekening5M the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'rekening5_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kdrekening5,tiperekening_id ,nmrekening5, nmrekeninglain5, rekening5_nb, create_time, create_loginpemakai_id,levelrek, create_ruangan', 'required'),
			array('levelrek, tiperekening_id,nourutrek', 'numerical', 'integerOnly' => true),
			array('kdrekening5', 'length', 'max' => 50),
			array('nmrekening5, nmrekeninglain5', 'length', 'max' => 500),
			array('rekening5_nb', 'length', 'max' => 1),
			array('kelompokrek', 'length', 'max' => 20),
			array('create_time,update_time', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => false, 'on' => 'insert'),
			array('update_time', 'default', 'value' => date('Y-m-d'), 'setOnEmpty' => false, 'on' => 'update'),
			array('keterangan, rekening5_aktif, sak, update_time, update_loginpemakai_id,kelrekening_id,parent_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekening5_id, rekening4_id, tiperekening_id, kdrekening5, nmrekening5, nmrekeninglain5, rekening5_nb, keterangan, nourutrek, rekening5_aktif, kelompokrek, sak, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'rekening5_id' => 'Rekening ID 5',
			'rekening4_id' => 'Rekening ID 4',
			'tiperekening_id' => 'Tipe Akun',
			'kdrekening5' => 'Kode Akun',
			'nmrekening5' => 'Nama Akun',
			'nmrekeninglain5' => 'Nama Lain',
			'rekening5_nb' => 'Saldo Normal',
			'keterangan' => 'Keterangan',
			'nourutrek' => 'No. Urut',
			'rekening5_aktif' => 'Status',
			'kelompokrek' => 'Kelompok Rekening',
			// 'kelrekening_id' =>''
			'kelrekening_id' => 'Kelompok Akun',
			'parent_id' => 'Rekening Induk',
			'levelrek' => 'Level Rekening',
			'sak' => 'Sak',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('rekening5_id', $this->rekening5_id);
		$criteria->compare('rekening4_id', $this->rekening4_id);
		$criteria->compare('tiperekening_id', $this->tiperekening_id);
		$criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
		$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
		$criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
		$criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
		$criteria->compare('nourutrek', $this->nourutrek);
		$criteria->compare('rekening5_aktif', $this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
		$criteria->compare('sak', $this->sak);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->compare('rekening5_id', $this->rekening5_id);
		$criteria->compare('rekening4_id', $this->rekening4_id);
		$criteria->compare('tiperekening_id', $this->tiperekening_id);
		$criteria->compare('LOWER(kdrekening5)', strtolower($this->kdrekening5), true);
		$criteria->compare('LOWER(nmrekening5)', strtolower($this->nmrekening5), true);
		$criteria->compare('LOWER(nmrekeninglain5)', strtolower($this->nmrekeninglain5), true);
		$criteria->compare('LOWER(rekening5_nb)', strtolower($this->rekening5_nb), true);
		$criteria->compare('LOWER(keterangan)', strtolower($this->keterangan), true);
		$criteria->compare('nourutrek', $this->nourutrek);
		$criteria->compare('rekening5_aktif', $this->rekening5_aktif);
		$criteria->compare('LOWER(kelompokrek)', strtolower($this->kelompokrek), true);
		$criteria->compare('sak', $this->sak);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function searchSaldoAwal(){
		$criteria = new CDbCriteria();
		if (!empty($this->rekperiod_id)){

				$criteria->select = " "
					. "t.nmrekening5, "
					. "t.kdrekening5, "
					. "t.rekening5_id, "
					. " ".$this->rekperiod_id." as rekperiod_id, "
					. " ".$this->periodeposting_id." as periodeposting_id, "
					. "(SELECT " //saldoawal_id
					. "		sa.saldoawal_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as saldoawal_id,"
					. "(SELECT " //matauang_id
					. "		sa.matauang_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as matauang_id,"
					. "(SELECT " //kursrp_id
					. "		sa.kursrp_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as kursrp_id,"
					. " (SELECT "  //saldoawal_awal
					. "		sa.jmlsaldoawald "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawald, "
					. " (SELECT "  //saldoawal_akhir
					. "		sa.jmlsaldoawalk "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawalk ";
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}
		$criteria->join = "LEFT JOIN rekening5_m as t2 ON t.rekening5_id = t2.parent_id";
		$criteria->addCondition('t2.rekening5_id IS NULL');
		// $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
		//				. "	LEFT JOIN saldoawal_t sa ON sa.rekening5_id =  t.rekening5_id ";

		if (!empty($this->tiperekening_id)){
			$criteria->addCondition(" t.tiperekening_id = ".$this->tiperekening_id);
		}else{
			$criteria->addCondition(" t.tiperekening_id = 999999");
		}

		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}

		$criteria->order = " t.kdrekening5 ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	public function searchSaldoAwalPrint(){
		$criteria = new CDbCriteria();
		if (!empty($this->rekperiod_id)){

				$criteria->select = " "
					. "t.nmrekening5, "
					. "t.kdrekening5, "
					. "t.rekening5_id, "
					. " ".$this->rekperiod_id." as rekperiod_id, "
					. " ".$this->periodeposting_id." as periodeposting_id, "
					. "(SELECT " //saldoawal_id
					. "		sa.saldoawal_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as saldoawal_id,"
					. "(SELECT " //matauang_id
					. "		sa.matauang_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as matauang_id,"
					. "(SELECT " //kursrp_id
					. "		sa.kursrp_id "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") as kursrp_id,"
					. " (SELECT "  //saldoawal_awal
					. "		sa.jmlsaldoawald "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawald, "
					. " (SELECT "  //saldoawal_akhir
					. "		sa.jmlsaldoawalk "
					. "	FROM "
					. "		saldoawal_t sa "
					. "	WHERE sa.rekening5_id = t.rekening5_id AND sa.rekperiod_id = ".$this->rekperiod_id.") jmlsaldoawalk ";
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}
		$criteria->join = "LEFT JOIN rekening5_m as t2 ON t.rekening5_id = t2.parent_id";
		$criteria->addCondition('t2.rekening5_id IS NULL');
		// $criteria->join = " LEFT JOIN rekening5_m r5 ON r5.rekening5_id = t.rekening5_id ";
		//				. "	LEFT JOIN saldoawal_t sa ON sa.rekening5_id =  t.rekening5_id ";

		if (!empty($this->tiperekening_id)){
			$criteria->addCondition(" t.tiperekening_id = ".$this->tiperekening_id);
		}else{
			$criteria->addCondition(" t.tiperekening_id = 999999");
		}

		if (!empty($this->rekperiod_id)){
			//$criteria->addCondition(" sa.rekperiod_id = ".$this->rekperiod_id);
		}else{
			//$criteria->addCondition(" sa.rekperiod_id = 999999");
		}

		$criteria->order = " t.kdrekening5 ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}
