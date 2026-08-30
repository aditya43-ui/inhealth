<?php

/**
 * This is the model class for table "penyedia_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'penyedia_m':
 * @property integer $penyedia_id
 * @property integer $supplier_id
 * @property integer $pbf_id
 * @property string $penyedia_kode
 * @property string $penyedia_nama
 * @property string $penyedia_namalain
 * @property string $penyedia_jenis
 * @property string $penyedia_alamat
 * @property string $penyedia_propinsi
 * @property string $penyedia_kabupaten
 * @property string $penyedia_kodepos
 * @property string $penyedia_telepon
 * @property string $penyedia_fax
 * @property string $penyedia_email
 * @property string $penyedia_website
 * @property string $penyedia_norekening
 * @property string $penyedia_direktur
 * @property string $penyedia_cp
 * @property string $penyedia_jabatancp
 * @property string $penyedia_nomobilecp
 * @property boolean $penyedia_aktif
 * @property string $penyedia_statusverifikasi
 *
 * The followings are the available model relations:
 * @property PengadaandokumenpenyediaM[] $pengadaandokumenpenyediaMs
 * @property SupplierM $supplier
 * @property PbfM $pbf
 * @property PenawaranpenyediaT[] $penawaranpenyediaTs
 */
class PenyediaM extends CActiveRecord
{
        public $pbf_nama, $propinsi_id, $nomor_dokumen;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenyediaM the static model class
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
		return 'penyedia_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('penyedia_kode, penyedia_nama, penyedia_jenis, penyedia_alamat, penyedia_kodepos,'
                            . 'penyedia_telepon, penyedia_email, penyedia_statusverifikasi', 'required'),
			array('supplier_id, pbf_id', 'numerical', 'integerOnly'=>true),
			array('penyedia_kode, penyedia_jenis, penyedia_norekening, penyedia_statusverifikasi', 'length', 'max'=>50),
			array('penyedia_nama, penyedia_namalain, penyedia_direktur, penyedia_cp', 'length', 'max'=>200),
			array('penyedia_propinsi, penyedia_kabupaten, penyedia_email', 'length', 'max'=>100),
			array('penyedia_kodepos', 'length', 'max'=>5),
			array('penyedia_telepon, penyedia_fax', 'length', 'max'=>12),
			array('penyedia_website', 'length', 'max'=>250),
			array('penyedia_jabatancp', 'length', 'max'=>150),
			array('penyedia_nomobilecp', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penyedia_id, supplier_id, pbf_id, penyedia_kode, penyedia_nama, penyedia_namalain, penyedia_jenis, penyedia_alamat, penyedia_propinsi, penyedia_kabupaten, penyedia_kodepos, penyedia_telepon, penyedia_fax, penyedia_email, penyedia_website, penyedia_norekening, penyedia_direktur, penyedia_cp, penyedia_jabatancp, penyedia_nomobilecp, penyedia_aktif, penyedia_statusverifikasi', 'safe', 'on'=>'search'),
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
			'pengadaandokumenpenyediaMs' => array(self::HAS_MANY, 'PengadaandokumenpenyediaM', 'penyedia_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'pbf' => array(self::BELONGS_TO, 'PbfM', 'pbf_id'),
			'penawaranpenyediaTs' => array(self::HAS_MANY, 'PenawaranpenyediaT', 'penyedia_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penyedia_id' => 'Penyedia',
			'supplier_id' => 'Supplier',
			'pbf_id' => 'Pbf',
			'penyedia_kode' => 'Kode',
			'penyedia_nama' => 'Nama Perusahaan Penyedia',
			'penyedia_namalain' => 'Nama Lain',
			'penyedia_jenis' => 'Jenis',
			'penyedia_alamat' => 'Alamat',
			'penyedia_propinsi' => 'Propinsi',
			'penyedia_kabupaten' => 'Kota / Kabupaten',
			'penyedia_kodepos' => 'Kode Pos',
			'penyedia_telepon' => 'Telepon',
			'penyedia_fax' => 'Fax',
			'penyedia_email' => 'Email',
			'penyedia_website' => 'Website',
			'penyedia_norekening' => 'Nomor Rekening',
			'penyedia_direktur' => 'Direktur',
			'penyedia_cp' => 'Contact Person',
			'penyedia_jabatancp' => 'Jabatan Contact Person',
			'penyedia_nomobilecp' => 'No. HP Contact Person',
			'penyedia_aktif' => 'Aktif',
			'penyedia_statusverifikasi' => 'Status Verifikasi',
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

		$criteria->compare('penyedia_id',$this->penyedia_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('pbf_id',$this->pbf_id);
		$criteria->compare('penyedia_kode',$this->penyedia_kode,true);
		$criteria->compare('penyedia_nama',$this->penyedia_nama,true);
		$criteria->compare('penyedia_namalain',$this->penyedia_namalain,true);
		$criteria->compare('penyedia_jenis',$this->penyedia_jenis,true);
		$criteria->compare('penyedia_alamat',$this->penyedia_alamat,true);
		$criteria->compare('penyedia_propinsi',$this->penyedia_propinsi,true);
		$criteria->compare('penyedia_kabupaten',$this->penyedia_kabupaten,true);
		$criteria->compare('penyedia_kodepos',$this->penyedia_kodepos,true);
		$criteria->compare('penyedia_telepon',$this->penyedia_telepon,true);
		$criteria->compare('penyedia_fax',$this->penyedia_fax,true);
		$criteria->compare('penyedia_email',$this->penyedia_email,true);
		$criteria->compare('penyedia_website',$this->penyedia_website,true);
		$criteria->compare('penyedia_norekening',$this->penyedia_norekening,true);
		$criteria->compare('penyedia_direktur',$this->penyedia_direktur,true);
		$criteria->compare('penyedia_cp',$this->penyedia_cp,true);
		$criteria->compare('penyedia_jabatancp',$this->penyedia_jabatancp,true);
		$criteria->compare('penyedia_nomobilecp',$this->penyedia_nomobilecp,true);
		$criteria->compare('penyedia_aktif',$this->penyedia_aktif);
		$criteria->compare('penyedia_statusverifikasi',$this->penyedia_statusverifikasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Search Data untuk dicetak
         * @return \CActiveDataProvider
         */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('penyedia_id',$this->penyedia_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('pbf_id',$this->pbf_id);
		$criteria->compare('penyedia_kode',$this->penyedia_kode,true);
		$criteria->compare('penyedia_nama',$this->penyedia_nama,true);
		$criteria->compare('penyedia_namalain',$this->penyedia_namalain,true);
		$criteria->compare('penyedia_jenis',$this->penyedia_jenis,true);
		$criteria->compare('penyedia_alamat',$this->penyedia_alamat,true);
		$criteria->compare('penyedia_propinsi',$this->penyedia_propinsi,true);
		$criteria->compare('penyedia_kabupaten',$this->penyedia_kabupaten,true);
		$criteria->compare('penyedia_kodepos',$this->penyedia_kodepos,true);
		$criteria->compare('penyedia_telepon',$this->penyedia_telepon,true);
		$criteria->compare('penyedia_fax',$this->penyedia_fax,true);
		$criteria->compare('penyedia_email',$this->penyedia_email,true);
		$criteria->compare('penyedia_website',$this->penyedia_website,true);
		$criteria->compare('penyedia_norekening',$this->penyedia_norekening,true);
		$criteria->compare('penyedia_direktur',$this->penyedia_direktur,true);
		$criteria->compare('penyedia_cp',$this->penyedia_cp,true);
		$criteria->compare('penyedia_jabatancp',$this->penyedia_jabatancp,true);
		$criteria->compare('penyedia_nomobilecp',$this->penyedia_nomobilecp,true);
		$criteria->compare('penyedia_aktif',$this->penyedia_aktif);
		$criteria->compare('penyedia_statusverifikasi',$this->penyedia_statusverifikasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        /**
         * Mengambil list propinsi_m
         * @return mixed Data array untuk Propinsi
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true), array('order'=>'propinsi_nama asc'));
        }
        
        /**
         * Menambil data kabupaten/kota berdasarkan propinsi yang dipilih.
         * Propinsi bisa ditentukan oleh :
         * * ID Propinsi yang diinput.
         * * ID Propinsi yang ada di model ini.
         * 
         * @param  integer $propinsi_id ID di tabel propinsi_m  
         * @return mixed Data array untuk data Kabupaten.
         */    
        public function getKabupatenItems($propinsi_id=null)
        {
            if (!empty($propinsi_id)) {
                return KabupatenM::model()->findAllByAttributes(array('kabupaten_aktif'=>true, 'propinsi_id'=>$propinsi_id), array('order'=>'kabupaten_nama asc'));
            } elseif (!empty($this->propinsi_id)) {
                return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama asc');
            } else {
                return array();
            }
        }

        /**
         * Pencarian dialog di transaksi surat perjanjian
         * @return \CActiveDataProvider
         */
        public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = 't.*, p.nomor_dokumen';
                $criteria->join = "LEFT JOIN pengadaandokumenpenyedia_m p ON t.penyedia_id = p.penyedia_id";
                $criteria->addCondition("p.jenis_dokumen LIKE '%".'NPWP'."%'");
		$criteria->compare('penyedia_id',$this->penyedia_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('pbf_id',$this->pbf_id);
		$criteria->compare('penyedia_kode',$this->penyedia_kode,true);
		$criteria->compare('penyedia_nama',$this->penyedia_nama,true);
		$criteria->compare('penyedia_namalain',$this->penyedia_namalain,true);
		$criteria->compare('penyedia_jenis',$this->penyedia_jenis,true);
		$criteria->compare('penyedia_alamat',$this->penyedia_alamat,true);
		$criteria->compare('penyedia_propinsi',$this->penyedia_propinsi,true);
		$criteria->compare('penyedia_kabupaten',$this->penyedia_kabupaten,true);
		$criteria->compare('penyedia_kodepos',$this->penyedia_kodepos,true);
		$criteria->compare('penyedia_telepon',$this->penyedia_telepon,true);
		$criteria->compare('penyedia_fax',$this->penyedia_fax,true);
		$criteria->compare('penyedia_email',$this->penyedia_email,true);
		$criteria->compare('penyedia_website',$this->penyedia_website,true);
		$criteria->compare('penyedia_norekening',$this->penyedia_norekening,true);
		$criteria->compare('penyedia_direktur',$this->penyedia_direktur,true);
		$criteria->compare('penyedia_cp',$this->penyedia_cp,true);
		$criteria->compare('penyedia_jabatancp',$this->penyedia_jabatancp,true);
		$criteria->compare('penyedia_nomobilecp',$this->penyedia_nomobilecp,true);
		$criteria->compare('penyedia_aktif',$this->penyedia_aktif);
		$criteria->compare('penyedia_statusverifikasi',$this->penyedia_statusverifikasi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}