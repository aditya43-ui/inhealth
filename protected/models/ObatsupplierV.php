<?php

/**
 * This is the model class for table "obatsupplier_v".
 *
 * The followings are the available columns in table 'obatsupplier_v':
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
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
 * @property integer $obatsupplier_id
 * @property string $sumberdana_nama
 * @property integer $sumberdana_id
 * @property integer $pbf_id
 * @property string $pbf_kode
 * @property string $pbf_nama
 * @property string $pbf_singkatan
 * @property string $pbf_alamat
 * @property string $pbf_propinsi
 * @property string $pbf_kabupaten
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property boolean $jenisobatalkes_farmasi
 * @property integer $generik_id
 * @property string $generik_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $satuanbesar_id
 * @property string $satuanbesar_nama
 * @property integer $kemasanbesar
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property string $tglkadaluarsa
 * @property integer $minimalstok
 * @property string $formularium
 * @property boolean $discountinue
 * @property string $image_obat
 * @property string $activedate
 * @property boolean $mintransaksi
 * @property boolean $obatalkes_farmasi
 * @property string $noregister
 * @property string $nobatch
 * @property double $hargabelibesar
 * @property double $diskon_persen
 * @property double $hargabelikecil
 * @property double $ppn_persen
 */
class ObatsupplierV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatsupplierV the static model class
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
		return 'obatsupplier_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, supplier_termin, obatsupplier_id, sumberdana_id, pbf_id, jenisobatalkes_id, generik_id, obatalkes_id, satuanbesar_id, kemasanbesar, satuankecil_id, kekuatan, minimalstok', 'numerical', 'integerOnly'=>true),
			array('hargabelibesar, diskon_persen, hargabelikecil, ppn_persen', 'numerical'),
			array('supplier_kode, jenisobatalkes_kode', 'length', 'max'=>10),
			array('supplier_nama, supplier_propinsi, supplier_kabupaten, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, pbf_nama, generik_nama, noregister', 'length', 'max'=>100),
			array('supplier_telp, supplier_fax, supplier_kodepos, supplier_matauang, supplier_website, supplier_email, sumberdana_nama, pbf_propinsi, pbf_kabupaten, jenisobatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, satuanbesar_nama, satuankecil_nama, formularium, nobatch', 'length', 'max'=>50),
			array('supplier_logo', 'length', 'max'=>500),
			array('supplier_jenis, pbf_kode, pbf_singkatan, obatalkes_kadarobat, satuankekuatan', 'length', 'max'=>20),
			array('obatalkes_barcode, obatalkes_kode, obatalkes_nama, image_obat', 'length', 'max'=>200),
			array('supplier_alamat, pbf_alamat, jenisobatalkes_farmasi, tglkadaluarsa, discountinue, activedate, mintransaksi, obatalkes_farmasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplier_id, supplier_kode, supplier_nama, supplier_alamat, supplier_propinsi, supplier_kabupaten, supplier_telp, supplier_fax, supplier_kodepos, supplier_npwp, supplier_norekening, supplier_namabank, supplier_rekatasnama, supplier_matauang, supplier_website, supplier_email, supplier_logo, supplier_cp, supplier_cp_hp, supplier_cp_email, supplier_cp2, supplier_cp2_hp, supplier_cp2_email, supplier_jenis, supplier_termin, obatsupplier_id, sumberdana_nama, sumberdana_id, pbf_id, pbf_kode, pbf_nama, pbf_singkatan, pbf_alamat, pbf_propinsi, pbf_kabupaten, jenisobatalkes_id, jenisobatalkes_kode, jenisobatalkes_nama, jenisobatalkes_farmasi, generik_id, generik_nama, obatalkes_id, obatalkes_barcode, obatalkes_kode, obatalkes_nama, obatalkes_namalain, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, satuanbesar_id, satuanbesar_nama, kemasanbesar, satuankecil_id, satuankecil_nama, kekuatan, satuankekuatan, tglkadaluarsa, minimalstok, formularium, discountinue, image_obat, activedate, mintransaksi, obatalkes_farmasi, noregister, nobatch, hargabelibesar, diskon_persen, hargabelikecil, ppn_persen', 'safe', 'on'=>'search'),
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
			'supplier_id' => 'Supplier',
			'supplier_kode' => 'Kode Supplier',
			'supplier_nama' => 'Nama Supplier',
			'supplier_alamat' => 'Alamat Supplier',
			'supplier_propinsi' => 'Supplier Propinsi',
			'supplier_kabupaten' => 'Supplier Kabupaten',
			'supplier_telp' => 'Telepon Supplier',
			'supplier_fax' => 'Fax Supplier',
			'supplier_kodepos' => 'Supplier Kodepos',
			'supplier_npwp' => 'Supplier Npwp',
			'supplier_norekening' => 'Supplier Norekening',
			'supplier_namabank' => 'Supplier Namabank',
			'supplier_rekatasnama' => 'Supplier Rekatasnama',
			'supplier_matauang' => 'Supplier Matauang',
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
			'obatsupplier_id' => 'Obatsupplier',
			'sumberdana_nama' => 'Sumberdana Nama',
			'sumberdana_id' => 'Sumberdana',
			'pbf_id' => 'Pbf',
			'pbf_kode' => 'Pbf Kode',
			'pbf_nama' => 'Pbf Nama',
			'pbf_singkatan' => 'Pbf Singkatan',
			'pbf_alamat' => 'Pbf Alamat',
			'pbf_propinsi' => 'Pbf Propinsi',
			'pbf_kabupaten' => 'Pbf Kabupaten',
			'jenisobatalkes_id' => 'Jenisobatalkes',
			'jenisobatalkes_kode' => 'Jenisobatalkes Kode',
			'jenisobatalkes_nama' => 'Jenisobatalkes Nama',
			'jenisobatalkes_farmasi' => 'Jenisobatalkes Farmasi',
			'generik_id' => 'Generik',
			'generik_nama' => 'Generik Nama',
			'obatalkes_id' => 'Obatalkes',
			'obatalkes_barcode' => 'Obatalkes Barcode',
			'obatalkes_kode' => 'Obatalkes Kode',
			'obatalkes_nama' => 'Obatalkes Nama',
			'obatalkes_namalain' => 'Obatalkes Namalain',
			'obatalkes_golongan' => 'Obatalkes Golongan',
			'obatalkes_kategori' => 'Obatalkes Kategori',
			'obatalkes_kadarobat' => 'Obatalkes Kadarobat',
			'satuanbesar_id' => 'Satuanbesar',
			'satuanbesar_nama' => 'Satuanbesar Nama',
			'kemasanbesar' => 'Kemasanbesar',
			'satuankecil_id' => 'Satuankecil',
			'satuankecil_nama' => 'Satuankecil Nama',
			'kekuatan' => 'Kekuatan',
			'satuankekuatan' => 'Satuankekuatan',
			'tglkadaluarsa' => 'Tglkadaluarsa',
			'minimalstok' => 'Minimalstok',
			'formularium' => 'Formularium',
			'discountinue' => 'Discountinue',
			'image_obat' => 'Image Obat',
			'activedate' => 'Activedate',
			'mintransaksi' => 'Mintransaksi',
			'obatalkes_farmasi' => 'Obatalkes Farmasi',
			'noregister' => 'Noregister',
			'nobatch' => 'Nobatch',
			'hargabelibesar' => 'Hargabelibesar',
			'diskon_persen' => 'Keringanan Persen',
			'hargabelikecil' => 'Hargabelikecil',
			'ppn_persen' => 'Ppn Persen',
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

		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
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
		$criteria->compare('supplier_termin',$this->supplier_termin);
		$criteria->compare('obatsupplier_id',$this->obatsupplier_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('jenisobatalkes_farmasi',$this->jenisobatalkes_farmasi);
		$criteria->compare('generik_id',$this->generik_id);
		$criteria->compare('LOWER(generik_nama)',strtolower($this->generik_nama),true);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		$criteria->compare('satuanbesar_id',$this->satuanbesar_id);
		$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
		$criteria->compare('kemasanbesar',$this->kemasanbesar);
		$criteria->compare('satuankecil_id',$this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('kekuatan',$this->kekuatan);
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('minimalstok',$this->minimalstok);
		$criteria->compare('LOWER(formularium)',strtolower($this->formularium),true);
		$criteria->compare('discountinue',$this->discountinue);
		$criteria->compare('LOWER(image_obat)',strtolower($this->image_obat),true);
		$criteria->compare('LOWER(activedate)',strtolower($this->activedate),true);
		$criteria->compare('mintransaksi',$this->mintransaksi);
		$criteria->compare('obatalkes_farmasi',$this->obatalkes_farmasi);
		$criteria->compare('LOWER(noregister)',strtolower($this->noregister),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('hargabelibesar',$this->hargabelibesar);
		$criteria->compare('diskon_persen',$this->diskon_persen);
		$criteria->compare('hargabelikecil',$this->hargabelikecil);
		$criteria->compare('ppn_persen',$this->ppn_persen);

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