<?php

/**
 * This is the model class for table "informasireturpembelian_v".
 *
 * The followings are the available columns in table 'informasireturpembelian_v':
 * @property integer $returpembelian_id
 * @property string $tglretur
 * @property string $noretur
 * @property string $alasanretur
 * @property string $keteranganretur
 * @property double $totalretur
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $penerimaanbarang_id
 * @property string $tglterima
 * @property string $noterima
 * @property string $tglterimafaktur
 * @property string $tglsuratjalan
 * @property string $nosuratjalan
 * @property integer $fakturpembelian_id
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property string $supplier_namalain
 * @property string $supplier_alamat
 * @property string $supplier_propinsi
 * @property string $supplier_kabupaten
 * @property string $supplier_telp
 * @property string $supplier_fax
 * @property string $supplier_kodepos
 * @property string $supplier_npwp
 * @property string $supplier_norekening
 * @property string $supplier_namabank
 * @property string $supplier_rekatasnama
 * @property string $supplier_matauang
 * @property string $supplier_website
 * @property string $supplier_email
 * @property string $supplier_logo
 * @property string $supplier_cp
 * @property string $supplier_cp_hp
 * @property string $supplier_cp_email
 * @property string $supplier_cp2
 * @property string $supplier_cp2_hp
 * @property string $supplier_cp2_email
 * @property string $supplier_jenis
 * @property integer $supplier_termin
 * @property string $longitude
 * @property string $latitude
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class InformasireturpembelianV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasireturpembelianV the static model class
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
		return 'informasireturpembelian_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('returpembelian_id, instalasi_id, ruangan_id, penerimaanbarang_id, fakturpembelian_id, supplier_id, supplier_termin', 'numerical', 'integerOnly'=>true),
			array('totalretur', 'numerical'),
			array('noretur, instalasi_nama, ruangan_nama, nosuratjalan, nofaktur, supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email', 'length', 'max'=>50),
			array('alasanretur', 'length', 'max'=>200),
			array('noterima, supplier_jenis', 'length', 'max'=>20),
			array('supplier_kode', 'length', 'max'=>10),
			array('supplier_nama, supplier_namalain, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email', 'length', 'max'=>100),
			array('supplier_logo', 'length', 'max'=>500),
			array('tglretur, keteranganretur, tglterima, tglterimafaktur, tglsuratjalan, tglfaktur, tgljatuhtempo, keteranganfaktur, supplier_alamat, longitude, latitude, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('returpembelian_id, tglretur, noretur, alasanretur, keteranganretur, totalretur, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, penerimaanbarang_id, tglterima, noterima, tglterimafaktur, tglsuratjalan, nosuratjalan, fakturpembelian_id, tglfaktur, nofaktur, tgljatuhtempo, keteranganfaktur, supplier_id, supplier_kode, supplier_nama, supplier_namalain, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_logo, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, longitude, latitude, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'returpembelian_id' => 'Retur ID',
			'tglretur' => 'Tanggal Retur',
			'noretur' => 'No. Retur',
			'alasanretur' => 'Alasan Retur',
			'keteranganretur' => 'Keterangan Retur',
			'totalretur' => 'Total Retur',
			'instalasi_id' => 'Instalasi ID',
			'instalasi_nama' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'penerimaanbarang_id' => 'Penerimaan Barang',
			'tglterima' => 'Tanggal Terima',
			'noterima' => 'No. Terima',
			'tglterimafaktur' => 'Tanggal Terima Faktur',
			'tglsuratjalan' => 'Tanggal Surat Jalan',
			'nosuratjalan' => 'No. Surat Jalan',
			'fakturpembelian_id' => 'Faktur Pembelian',
			'tglfaktur' => 'Tanggal Faktur',
			'nofaktur' => 'No. Faktur',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'keteranganfaktur' => 'Keterangan Faktur',
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Supplier',
			'supplier_namalain' => 'Supplier Nama lain',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_propinsi' => 'Supplier Propinsi',
			'supplier_kabupaten' => 'Supplier Kabupaten',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_fax' => 'Fax Supplier',
			'supplier_kodepos' => 'Supplier Kodepos',
			'supplier_npwp' => 'Supplier Npwp',
			'supplier_norekening' => 'Supplier No. Rekening',
			'supplier_namabank' => 'Supplier Bank',
			'supplier_rekatasnama' => 'Supplier Rekening a/n',
			'supplier_matauang' => 'Supplier Mata Uang',
			'supplier_website' => 'Website Supplier',
			'supplier_email' => 'Email Supplier',
			'supplier_logo' => 'Supplier Logo',
			'supplier_cp' => 'Supplier Cp',
			'supplier_cp_hp' => 'Supplier Cp Hp',
			'supplier_cp_email' => 'Supplier Cp Email',
			'supplier_cp2' => 'Supplier Cp2',
			'supplier_cp2_hp' => 'Supplier Cp2 Hp',
			'supplier_cp2_email' => 'Supplier Cp2 Email',
			'supplier_jenis' => 'Supplier Jenis',
			'supplier_termin' => 'Supplier Termin',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
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

		if(!empty($this->returpembelian_id)){
			$criteria->addCondition('returpembelian_id = '.$this->returpembelian_id);
		}
		$criteria->compare('LOWER(tglretur)',strtolower($this->tglretur),true);
		$criteria->compare('LOWER(noretur)',strtolower($this->noretur),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->penerimaanbarang_id)){
			$criteria->addCondition('penerimaanbarang_id = '.$this->penerimaanbarang_id);
		}
		$criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->compare('LOWER(noterima)',strtolower($this->noterima),true);
		$criteria->compare('LOWER(tglterimafaktur)',strtolower($this->tglterimafaktur),true);
		$criteria->compare('LOWER(tglsuratjalan)',strtolower($this->tglsuratjalan),true);
		$criteria->compare('LOWER(nosuratjalan)',strtolower($this->nosuratjalan),true);
		if(!empty($this->fakturpembelian_id)){
			$criteria->addCondition('fakturpembelian_id = '.$this->fakturpembelian_id);
		}
		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
		if(!empty($this->supplier_id)){
			$criteria->addCondition('supplier_id = '.$this->supplier_id);
		}
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('LOWER(supplier_namalain)',strtolower($this->supplier_namalain),true);
		$criteria->compare('LOWER(supplier_alamat)',strtolower($this->supplier_alamat),true);
		$criteria->compare('LOWER(supplier_propinsi)',strtolower($this->supplier_propinsi),true);
		$criteria->compare('LOWER(supplier_kabupaten)',strtolower($this->supplier_kabupaten),true);
		$criteria->compare('LOWER(supplier_telp)',strtolower($this->supplier_telp),true);
		$criteria->compare('LOWER(supplier_fax)',strtolower($this->supplier_fax),true);
		$criteria->compare('LOWER(supplier_kodepos)',strtolower($this->supplier_kodepos),true);
		$criteria->compare('LOWER(supplier_npwp)',strtolower($this->supplier_npwp),true);
		$criteria->compare('LOWER(supplier_norekening)',strtolower($this->supplier_norekening),true);
		$criteria->compare('LOWER(supplier_namabank)',strtolower($this->supplier_namabank),true);
		$criteria->compare('LOWER(supplier_rekatasnama)',strtolower($this->supplier_rekatasnama),true);
		$criteria->compare('LOWER(supplier_matauang)',strtolower($this->supplier_matauang),true);
		$criteria->compare('LOWER(supplier_website)',strtolower($this->supplier_website),true);
		$criteria->compare('LOWER(supplier_email)',strtolower($this->supplier_email),true);
		$criteria->compare('LOWER(supplier_logo)',strtolower($this->supplier_logo),true);
		$criteria->compare('LOWER(supplier_cp)',strtolower($this->supplier_cp),true);
		$criteria->compare('LOWER(supplier_cp_hp)',strtolower($this->supplier_cp_hp),true);
		$criteria->compare('LOWER(supplier_cp_email)',strtolower($this->supplier_cp_email),true);
		$criteria->compare('LOWER(supplier_cp2)',strtolower($this->supplier_cp2),true);
		$criteria->compare('LOWER(supplier_cp2_hp)',strtolower($this->supplier_cp2_hp),true);
		$criteria->compare('LOWER(supplier_cp2_email)',strtolower($this->supplier_cp2_email),true);
		$criteria->compare('LOWER(supplier_jenis)',strtolower($this->supplier_jenis),true);
		if(!empty($this->supplier_termin)){
			$criteria->addCondition('supplier_termin = '.$this->supplier_termin);
		}
		$criteria->compare('LOWER(longitude)',strtolower($this->longitude),true);
		$criteria->compare('LOWER(latitude)',strtolower($this->latitude),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

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