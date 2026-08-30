<?php

/**
 * This is the model class for table "laporanrekonsiliasibank_v".
 *
 * The followings are the available columns in table 'laporanrekonsiliasibank_v':
 * @property integer $rekonsiliasibank_id
 * @property string $rekonsiliasibank_no
 * @property string $rekonsiliasibank_tgl
 * @property double $rekonsiliasibank_saldokas
 * @property double $rekonsiliasibank_saldobank
 * @property integer $bank_id
 * @property integer $matauang_id
 * @property string $matauang
 * @property string $singkatan
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
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
 * @property integer $rekonsiliasibankdetail_id
 * @property integer $jenisrekonsiliasibank_id
 * @property string $jenisrekonsiliasibank_nama
 * @property integer $kelrekening_id
 * @property string $koderekeningkel
 * @property string $namakelrekening
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property double $saldodebit
 * @property double $saldokredit
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class LaporanrekonsiliasibankV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrekonsiliasibankV the static model class
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
		return 'laporanrekonsiliasibank_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekonsiliasibank_id, bank_id, matauang_id, kabupaten_id, propinsi_id, rekonsiliasibankdetail_id, jenisrekonsiliasibank_id, kelrekening_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('rekonsiliasibank_saldokas, rekonsiliasibank_saldobank, saldodebit, saldokredit', 'numerical'),
			array('rekonsiliasibank_no', 'length', 'max'=>25),
			array('matauang, singkatan, kabupaten_nama, propinsi_nama, telpbank1, telpbank2, faxbank, emailbank, website, kodepos, koderekeningkel', 'length', 'max'=>50),
			array('namabank, norekening, cabangdari, negara, jenisrekonsiliasibank_nama, namakelrekening, nmrekening1', 'length', 'max'=>100),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('nmrekening2', 'length', 'max'=>200),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('rekonsiliasibank_tgl, alamatbank, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekonsiliasibank_id, rekonsiliasibank_no, rekonsiliasibank_tgl, rekonsiliasibank_saldokas, rekonsiliasibank_saldobank, bank_id, matauang_id, matauang, singkatan, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, namabank, norekening, alamatbank, telpbank1, telpbank2, faxbank, emailbank, website, kodepos, cabangdari, negara, rekonsiliasibankdetail_id, jenisrekonsiliasibank_id, jenisrekonsiliasibank_nama, kelrekening_id, koderekeningkel, namakelrekening, rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, saldodebit, saldokredit, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'rekonsiliasibank_id' => 'ID Rekonsiliasi Bank',
			'rekonsiliasibank_no' => 'No. Rekonsiliasi Bank',
			'rekonsiliasibank_tgl' => 'Tgl. Rekonsiliasi Bank',
			'rekonsiliasibank_saldokas' => 'Saldo Kas pada Pembukuan',
			'rekonsiliasibank_saldobank' => 'Saldo pada Bank',
			'bank_id' => 'Bank',
			'matauang_id' => 'Mata Uang',
			'matauang' => 'Mata Uang',
			'singkatan' => 'Singkatan',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Provinsi',
			'namabank' => 'Nama Bank',
			'norekening' => 'No. Rekening',
			'alamatbank' => 'Alamat Bank',
			'telpbank1' => 'Telepon Bank 1',
			'telpbank2' => 'Telepon Bank 2',
			'faxbank' => 'Fax. Bank',
			'emailbank' => 'Email Bank',
			'website' => 'Website',
			'kodepos' => 'Kode Pos',
			'cabangdari' => 'Cabang dari',
			'negara' => 'Negara',
			'rekonsiliasibankdetail_id' => 'ID Rekonsiliasi Bank Detail',
			'jenisrekonsiliasibank_id' => 'ID Rekonsiliasi Bank',
			'jenisrekonsiliasibank_nama' => 'Nama Rekonsiliasi Bank',
			'kelrekening_id' => 'Kelompok Rekening',
			'koderekeningkel' => 'Kode Kelompok Rekening',
			'namakelrekening' => 'Nama Kelompok Rekening',
			'rekening1_id' => 'Rekening 1',
			'kdrekening1' => 'Kode Rekening 1',
			'nmrekening1' => 'Nama Rekening 1',
			'rekening2_id' => 'Rekening 2',
			'kdrekening2' => 'Kode Rekening 2',
			'nmrekening2' => 'Nama Rekening 2',
			'rekening3_id' => 'Rekening 3',
			'kdrekening3' => 'Kode Rekening 3',
			'nmrekening3' => 'Nama Rekening 3',
			'rekening4_id' => 'Rekening 4',
			'kdrekening4' => 'Kode Rekening 4',
			'nmrekening4' => 'Nama Rekening 4',
			'rekening5_id' => 'Rekening 5',
			'kdrekening5' => 'Kode Rekening 5',
			'nmrekening5' => 'Nama Rekening 5',
			'saldodebit' => 'Saldo Debit',
			'saldokredit' => 'Saldo Kredit',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->rekonsiliasibank_id)){
			$criteria->addCondition('rekonsiliasibank_id = '.$this->rekonsiliasibank_id);
		}
		$criteria->compare('LOWER(rekonsiliasibank_no)',strtolower($this->rekonsiliasibank_no),true);
		$criteria->compare('LOWER(rekonsiliasibank_tgl)',strtolower($this->rekonsiliasibank_tgl),true);
		$criteria->compare('rekonsiliasibank_saldokas',$this->rekonsiliasibank_saldokas);
		$criteria->compare('rekonsiliasibank_saldobank',$this->rekonsiliasibank_saldobank);
		if(!empty($this->bank_id)){
			$criteria->addCondition('bank_id = '.$this->bank_id);
		}
		if(!empty($this->matauang_id)){
			$criteria->addCondition('matauang_id = '.$this->matauang_id);
		}
		$criteria->compare('LOWER(matauang)',strtolower($this->matauang),true);
		$criteria->compare('LOWER(singkatan)',strtolower($this->singkatan),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
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
		if(!empty($this->rekonsiliasibankdetail_id)){
			$criteria->addCondition('rekonsiliasibankdetail_id = '.$this->rekonsiliasibankdetail_id);
		}
		if(!empty($this->jenisrekonsiliasibank_id)){
			$criteria->addCondition('jenisrekonsiliasibank_id = '.$this->jenisrekonsiliasibank_id);
		}
		$criteria->compare('LOWER(jenisrekonsiliasibank_nama)',strtolower($this->jenisrekonsiliasibank_nama),true);
		if(!empty($this->kelrekening_id)){
			$criteria->addCondition('kelrekening_id = '.$this->kelrekening_id);
		}
		$criteria->compare('LOWER(koderekeningkel)',strtolower($this->koderekeningkel),true);
		$criteria->compare('LOWER(namakelrekening)',strtolower($this->namakelrekening),true);
		if(!empty($this->rekening1_id)){
			$criteria->addCondition('rekening1_id = '.$this->rekening1_id);
		}
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		if(!empty($this->rekening2_id)){
			$criteria->addCondition('rekening2_id = '.$this->rekening2_id);
		}
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		if(!empty($this->rekening3_id)){
			$criteria->addCondition('rekening3_id = '.$this->rekening3_id);
		}
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		if(!empty($this->rekening4_id)){
			$criteria->addCondition('rekening4_id = '.$this->rekening4_id);
		}
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		if(!empty($this->rekening5_id)){
			$criteria->addCondition('rekening5_id = '.$this->rekening5_id);
		}
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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
            ));
        }
}